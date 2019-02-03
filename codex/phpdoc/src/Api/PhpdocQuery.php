<?php

namespace Codex\Phpdoc\Api;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;

class PhpdocQuery
{
    public function phpdoc($rootValue, array $args, $context, ResolveInfo $info)
    {
        $codex       = codex();
        $projectKey  = data_get($args, 'projectKey', codex()->getProjects()->getDefault());
        $project     = $codex->getProject($projectKey);
        $revisionKey = data_get($args, 'revisionKey', $project->getRevisions()->getDefaultKey());
        $revision    = $project->getRevision($revisionKey);
        $phpdoc      = $revision->phpdoc();
        $manifest    = $phpdoc->getManifest();
        $result      = array_merge($phpdoc->getManifest()->toArray(), compact('manifest', 'phpdoc', 'revision'));
        return $result;
    }

    public function file($rootValue, array $args, $context, ResolveInfo $info)
    {
        /** @var \Codex\Contracts\Revisions\Revision $revision */
        $revision = $rootValue[ 'revision' ];
        $phpdoc   = $revision->phpdoc();

        if (array_has($args, 'fullName')) {
            $file = $phpdoc->getFileByFullName($args[ 'fullName' ]);
        } else {
            if (array_has($args, 'hash')) {
                $phpdoc->getFile($args[ 'hash' ]);
            } else {
                throw new Error('Require either fullName or hash arg');
            }
        }

        $fileData = $file->toArray();
        return $fileData;
    }
}
