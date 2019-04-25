<?php


namespace Codex\Git;

use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class GitAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;
        $semver = $projects->child('branching', T::MAP)->api('BranchingConfig', [ 'new' ]);
        $semver->child('production', T::STRING,'master');
        $semver->child('development', T::STRING,'develop');
        $git = $projects->child('git', T::MAP)->api('GitConfig', [ 'new' ]);
        $git->child('enabled', T::BOOL,false);
        $git->child('owner', T::STRING);
        $git->child('repository', T::STRING);
        $git->child('connection', T::STRING);
        $git->child('branches', T::ARRAY(T::STRING));
        $git->child('versions', T::STRING);
        $skip = $git->child('skip', T::MAP);
        $skip->child('patch_versions', T::BOOL);
        $skip->child('minor_versions', T::BOOL);
        $paths = $git->child('paths', T::MAP);
        $paths->child('docs', T::STRING);
        $paths->child('index', T::STRING);
        $webhook = $git->child('webhook', T::MAP);
        $webhook->child('enabled', T::BOOL);
        $webhook->child('secret', T::STRING)->noApi();

        $git_links = $projects->child('git_links', T::MAP)->api('GitLinksConfig', [ 'new' ]);
        $git_links->child('enabled', T::BOOL);
        $git_links->child('map', T::ARRAY(T::STRING) ,[]);
        $git_links->child('links', T::MAP ,[]);

        $registry->revisions->inheritKeys(['git','git_links']);
        $registry->documents->inheritKeys(['git','git_links']);
    }
}

