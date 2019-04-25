<?php


namespace Codex\Git;

use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;
use Codex\Attributes\AttributeType as T;

class GitAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;
        $semver   = $projects->child('branching', T::MAP)->api('BranchingConfig', [ 'new' ]);
        $semver->child('production', T::STRING, 'master');
        $semver->child('development', T::STRING, 'develop');
        $git = $projects->child('git', T::MAP)->api('GitConfig', [ 'new' ]);
        $git->child('enabled', T::BOOL, false);
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
        $git_links->child('map', T::ARRAY(T::STRING), []);
        $git_links->child('links', T::MAP, []);

        $registry->revisions->inheritKeys([ 'git', 'git_links' ]);
        $registry->documents->inheritKeys([ 'git', 'git_links' ]);

    }

    public function register2(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;
        $branching   = $projects->child('branching', T::MAP)->api('BranchingConfig', [ 'new' ]);
        $branching->child('production', T::STRING, 'master');
        $branching->child('development', T::STRING, 'develop');


        $git      = $projects->child('git', T::MAP)->api('GitConfig', [ 'new' ]);
        $git->child('enabled', T::BOOL, false);


        $remotes = $git->child('remotes', T::MAP)->api('GitRemoteConfig', [ 'new' ]);
        $remotes->child('connection', T::STRING);
        $remotes->child('owner', T::STRING);
        $remotes->child('repository', T::STRING);
        $remotes->child('url', T::STRING);
        $remotes->child('document_url', T::STRING);
        $remotesWebhook = $remotes->child('webhook', T::MAP);
        $remotesWebhook->child('enabled', T::BOOL);
        $remotesWebhook->child('secret', T::STRING);


        $syncs = $git->child('syncs', T::ARRAY(T::MAP))->api('GitSyncConfig', [ 'new', 'array' ]);
        $syncs->child('remote', T::STRING)->required();
        $syncs->child('branches', T::ARRAY(T::STRING), []);
        $syncs->child('versions', T::STRING, null);
        $syncsSkip = $syncs->child('skip', T::MAP)->api('GitSyncSkipConfig', [ 'new' ]);
        $syncsSkip->child('patch_versions', T::BOOL, false);
        $syncsSkip->child('minor_versions', T::BOOL, false);
        $syncsCopy = $syncs->child('copy', T::MAP);


        $links = $git->child('links', T::MAP)->api('GitLinkConfig', [ 'new' ]);
        $links->child('enabled', T::BOOL, false);
        $links->child('remote', T::STRING)->required();
        $links->child('map', T::MAP);
        $links->child('links', T::MAP);
        $registry->revisions->inheritKeys([ 'git' ]);
        $registry->documents->inheritKeys([ 'git' ]);
    }
}

