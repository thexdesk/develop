<?php

namespace Codex\Comments;

use Illuminate\Routing\Controller;

class CommentsScriptController extends Controller
{
    public function getScript()
    {
        $manager    = resolve(CommentsManager::class);
        $connection = request()->query('connection');
        $url        = request()->query('url');
        $id         = request()->query('id');
        $config     = $manager->getConnectionConfig($connection);
        $comments   = $manager->connection($connection);
        $options    = [
            'url' => $url,
            'id'  => $id,
        ];
        $data       = $comments->render($options);

        return response(
            $data[ 'script' ],
            200, [
                'Content-Type' => 'application/javascript',
            ]
        );
    }

}
