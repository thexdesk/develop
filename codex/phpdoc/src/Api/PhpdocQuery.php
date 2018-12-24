<?php

namespace Codex\Phpdoc\Api;

use Codex\Api\GraphQL\Utils;
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
        $show        = Utils::transformSelectionToShow($info->getFieldSelection(2));
        $phpdoc      = $revision->phpdoc();
        return array_merge($phpdoc->getManifest()->toArray(), compact('phpdoc', 'revision'));
    }

    public function file($rootValue, array $args, $context, ResolveInfo $info)
    {
        /** @var \Codex\Contracts\Revisions\Revision $revision */
        $revision = $rootValue[ 'revision' ];
        $phpdoc   = $revision->phpdoc();

        if (array_has($args, 'fullName')) {
            $file = $phpdoc->getFileByFullName($args[ 'fullName' ]);
            $fileData = $file->toArray();
            $show = Utils::transformSelectionToShow($info->getFieldSelection(50));
            $filtered = [];
            foreach($show as $key){
                data_set($filtered, $key, data_get($fileData, $key));
            }
            return $filtered;
        }
    }
}
