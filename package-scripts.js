const {rimraf, series, copy, mkdirp} = require('nps-utils');
const {resolve} = require('path');

const _themePath = resolve(__dirname, '../theme');
const themePath = (...parts) => resolve(_themePath, ...parts);
const path = (...parts) => resolve(__dirname, ...parts);
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

        // rimraf(path('public/vendor')),
        // `php artisan vendor:publish --tag=public`
    )
});

module.exports = {

    scripts: {
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
        'copy:docs:addons'     : {
            script: series(
                rimraf(path('resources/docs/codex/master/addons/algolia-search.md')),
                rimraf(path('resources/docs/codex/master/addons/auth.md')),
                rimraf(path('resources/docs/codex/master/addons/blog.md')),
                rimraf(path('resources/docs/codex/master/addons/comments.md')),
                rimraf(path('resources/docs/codex/master/addons/phpdoc.md')),
                rimraf(path('resources/docs/codex/master/addons/sitemap.md')),
                rimraf(path('resources/docs/codex/master/addons/filesystems.md')),
                rimraf(path('resources/docs/codex/master/addons/git.md')),
                `cp -f ${path('codex/algolia-search/README.md')} ${path('resources/docs/codex/master/addons/algolia-search.md')}`,
                `cp -f ${path('codex/auth/README.md')} ${path('resources/docs/codex/master/addons/auth.md')}`,
                `cp -f ${path('codex/blog/README.md')} ${path('resources/docs/codex/master/addons/blog.md')}`,
                `cp -f ${path('codex/comments/README.md')} ${path('resources/docs/codex/master/addons/comments.md')}`,
                `cp -f ${path('codex/phpdoc/README.md')} ${path('resources/docs/codex/master/addons/phpdoc.md')}`,
                `cp -f ${path('codex/sitemap/README.md')} ${path('resources/docs/codex/master/addons/sitemap.md')}`,
                `cp -f ${path('codex/filesystems/README.md')} ${path('resources/docs/codex/master/addons/filesystems.md')}`,
                `cp -f ${path('codex/git/README.md')} ${path('resources/docs/codex/master/addons/git.md')}`
            )
        },
        'copy:license'          : {
            script: series(
                `cp -f ${licensePath} ${path('codex/core/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/algolia-search/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/auth/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/blog/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/comments/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/phpdoc/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/sitemap/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/filesystems/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/git/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('resources/docs/codex/master/LICENSE.md')}`,
            )
        }
    }
};
