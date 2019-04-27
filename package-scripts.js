const {rimraf, series, copy, mkdirp} = require('nps-utils');
const {resolve} = require('path');

const path = (...parts) => resolve(__dirname, ...parts);

const _themePath = path('../theme');
const themePath = (...parts) => resolve(_themePath, ...parts);

const _docsPath = path('docs');
const docsPath = (...parts) => resolve(_docsPath, ...parts);

const _packagesPath = path('codex');
const packagesPath = (...parts) => resolve(_packagesPath, ...parts);
const packagePath = (name, ...parts) => resolve(_packagesPath, name, ...parts);
const packageReadmePath = (name) => packagePath(name, 'README.md');

const licensePath = path('LICENSE.md');



const _link = (type = 'dev') => ({
    script: series(
        mkdirp(path('public/vendor')),
        rimraf(path('public/vendor/codex_core')),
        rimraf(path('public/vendor/codex_comments')),
        rimraf(path('public/vendor/codex_phpdoc')),
        rimraf(path('public/vendor/codex_auth')),
        `ln -s ${themePath('app', type, 'vendor/codex_core')} ${path('public/vendor/codex_core')}`,
        `ln -s ${themePath('app', type, 'vendor/codex_comments')} ${path('public/vendor/codex_comments')}`,
        `ln -s ${themePath('app', type, 'vendor/codex_phpdoc')} ${path('public/vendor/codex_phpdoc')}`,
        `ln -s ${themePath('app', type, 'vendor/codex_auth')} ${path('public/vendor/codex_auth')}`
    )
});
const _copy = (type = 'dev') => ({
    script: series(
        rimraf(path('codex/core/resources/assets')),
        rimraf(path('codex/comments/resources/assets')),
        rimraf(path('codex/phpdoc/resources/assets')),
        `cp -r ${themePath('app', type, 'vendor/codex_core')} ${path('codex/core/resources/assets')}`,
        `cp -r ${themePath('app', type, 'vendor/codex_comments')} ${path('codex/comments/resources/assets')}`,
        `cp -r ${themePath('app', type, 'vendor/codex_phpdoc')} ${path('codex/phpdoc/resources/assets')}`,
        `cd ../codex-project.ninja && composer assets`
        // rimraf(path('public/vendor')),
        // `php artisan vendor:publish --tag=public`
    )
});

module.exports = {

    scripts: {
        'docs:link': {
            script: series(
                rimraf(packagePath('core', 'resources/docs/addons')),
                mkdirp(packagePath('core', 'resources/docs/addons')),
                `ln -s ${packageReadmePath('algolia-search')} ${packagePath('core', 'resources/docs/addons/algolia-search.md')}`,
                `ln -s ${packageReadmePath('auth')} ${packagePath('core', 'resources/docs/addons/auth.md')}`,
                `ln -s ${packageReadmePath('blog')} ${packagePath('core', 'resources/docs/addons/blog.md')}`,
                `ln -s ${packageReadmePath('comments')} ${packagePath('core', 'resources/docs/addons/comments.md')}`,
                `ln -s ${packageReadmePath('composer-plugin')} ${packagePath('core', 'resources/docs/addons/composer-plugin.md')}`,
                `ln -s ${packageReadmePath('filesystems')} ${packagePath('core', 'resources/docs/addons/filesystems.md')}`,
                `ln -s ${packageReadmePath('git')} ${packagePath('core', 'resources/docs/addons/git.md')}`,
                `ln -s ${packageReadmePath('packagist')} ${packagePath('core', 'resources/docs/addons/packagist.md')}`,
                `ln -s ${packageReadmePath('phpdoc')} ${packagePath('core', 'resources/docs/addons/phpdoc.md')}`,
                `ln -s ${packageReadmePath('sitemap')} ${packagePath('core', 'resources/docs/addons/sitemap.md')}`,

                rimraf(docsPath('codex/master')),
                `ln -s ${path('codex/core/resources/docs')} ${docsPath('codex/master')}`,
            )
        },

        copy                    : {
            script: series(
                rimraf(path('public/vendor')),
                `cp -r ${themePath('app/dist/vendor')} ${path('public/vendor')}`
            )
        },
        'link:theme:public:dist': _link('dist'),
        'link:theme:public'     : _link('dev'),
        'copy:theme:assets:dist': _copy('dist'),
        'copy:theme:assets'     : _copy('dev'),
        'copy:license'          : {
            script: series(
                `cp -f ${licensePath} ${path('codex/core/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/algolia-search/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/auth/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/blog/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/comments/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/filesystems/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/git/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/packagist/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/phpdoc/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/sitemap/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('resources/docs/codex/master/LICENSE.md')}`,
            )
        }
    }
};
