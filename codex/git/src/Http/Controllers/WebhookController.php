<?php

namespace Codex\Git\Http\Controllers;

use Codex\Projects\Project;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    use DispatchesJobs;

    public function bitbucket()
    {
        $codex = codex();
        $codex->log('info', 'codex.git.webhook.call', [ 'remote' => 'bitbucket' ]);

        $headers = array_only(request()->headers->all(), [
            'x-request-uuid',
            'x-event-key',
            'user-agent',
            'x-hook-uuid',
        ]);
        $data    = array_dot(request()->all());

        $valid =
            $headers[ 'user-agent' ][ 0 ] === 'Bitbucket-Webhooks/2.0' &&
            $headers[ 'x-event-key' ][ 0 ] === 'repo:push' &&
            isset($data[ 'repository.name' ]);

        if ( ! $valid) {
            $codex->log('info', 'codex.git.webhook.invalid', [ 'remote' => 'bitbucket' ]);
            return response('Invalid headzors', 500);
        }

        return $this->applyToGitProjects('bitbucket', function () use ($data) {
            return $data[ 'repository.full_name' ];
        });
    }

    /**
     * webhook
     *
     * @param $type
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function github()
    {
        $codex = codex();
        $codex->log('info', 'codex.git.webhook.call', [ 'remote' => 'github' ]);

        $headers = [
            'delivery'   => request()->header('x-github-delivery'),
            'event'      => request()->header('x-github-event'),
            'user-agent' => request()->header('user-agent'),
            'signature'  => request()->header('x-hub-signature'),
        ];
        $data    = array_dot(request()->all());

        return $this->applyToGitProjects('github', function (Project $project) use ($data, $headers, $codex) {
            $hash  = trim(hash_hmac('sha1', file_get_contents("php://input"), $project[ 'git.webhook.secret' ]));
            $valid = $headers[ 'signature' ] === "sha1=$hash";

            $codex->log('info', 'codex.git.webhook.call.data', [
                'signature' => $headers[ 'signature' ],
                'secret'    => $project[ 'git.webhook.secret' ],
                'hash'      => $hash,
                'valid'     => $valid,
            ]);

            if ($valid) {
                return strtolower($data[ 'repository.full_name' ]);
            } else {
                $codex->log('info', 'codex.git.webhook.invalid', [ 'remote' => 'github' ]);
                return response()->json([ 'message' => 'invalid hash' ], 403);
            }
        });
    }

    protected function applyToGitProjects($remote, \Closure $closure)
    {
        $codex = codex();
        foreach ($codex->projects->all() as $project) {
            $name = $project->getName();

            if ( ! $project['git.enabled'] || ! $project['git.webhook.enabled'] || $project['git.connection'] !== $remote) {
                continue;
            }

            $projectRepo = $project->config('git.owner') . '/' . $project->config('git.repository');
            $hookRepo    = call_user_func_array($closure, [ $project ]);

            if ($hookRepo instanceof Response) {
                return $hookRepo;
            }
            if ($hookRepo !== $projectRepo) {
                continue;
            }

            $this->dispatch(new SyncJob($name));
            $this->codex->log('info', 'codex.git.webhook.success', [ 'remote' => $remote, 'name' => $name ]);

            return response('', 200);
        }
    }
}
