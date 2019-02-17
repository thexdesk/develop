const {rimraf, series, copy, mkdirp} = require('nps-utils');
const {resolve} = require('path');

const _themePath = resolve(__dirname, '../theme');
const themePath = (...parts) => resolve(_themePath, ...parts);
const path = (...parts) => resolve(__dirname, ...parts);
const licensePath = path('LICENSE.md');

module.exports = {

    scripts: {
        copy               : {

            script: series(
                rimraf(path('public/vendor')),
                `cp -r ${themePath('app/dist/vendor')} ${path('public/vendor')}`
            )
        },
        link               : {
            script: series(
                mkdirp(path('public/vendor')),
                rimraf(path('public/vendor/codex_core')),
                rimraf(path('public/vendor/codex_phpdoc')),
                rimraf(path('public/vendor/codex_auth')),
                `ln -s ${themePath('app/dist/vendor/codex_core')} ${path('public/vendor/codex_core')}`,
                `ln -s ${themePath('app/dist/vendor/codex_phpdoc')} ${path('public/vendor/codex_phpdoc')}`,
                `ln -s ${themePath('app/dist/vendor/codex_auth')} ${path('public/vendor/codex_auth')}`
            )
        },
        'copy:assets'      : {
            script: series(
                rimraf(path('codex/core/resources/assets')),
                rimraf(path('codex/phpdoc/resources/assets')),
                // mkdirp(path('codex/core/resources/assets')),
                // mkdirp(path('codex/phpdoc/resources/assets')),
                `cp -r ${themePath('app/dist/vendor/codex_core')} ${path('codex/core/resources/assets')}`,
                `cp -r ${themePath('app/dist/vendor/codex_phpdoc')} ${path('codex/phpdoc/resources/assets')}`,

                rimraf(path('public/vendor')),
                `php artisan vendor:publish --tag=public`
            )
        },
        'copy:docs:plugins': {
            script: series(
                rimraf(path('resources/docs/codex/master/addons/algolia-search.md')),
                rimraf(path('resources/docs/codex/master/addons/auth.md')),
                rimraf(path('resources/docs/codex/master/addons/phpdoc.md')),
                rimraf(path('resources/docs/codex/master/addons/sitemap.md')),
                rimraf(path('resources/docs/codex/master/addons/filesystems.md')),
                rimraf(path('resources/docs/codex/master/addons/git.md')),
                `cp -f ${path('codex/algolia-search/README.md')} ${path('resources/docs/codex/master/addons/algolia-search.md')}`,
                `cp -f ${path('codex/auth/README.md')} ${path('resources/docs/codex/master/addons/auth.md')}`,
                `cp -f ${path('codex/phpdoc/README.md')} ${path('resources/docs/codex/master/addons/phpdoc.md')}`,
                `cp -f ${path('codex/sitemap/README.md')} ${path('resources/docs/codex/master/addons/sitemap.md')}`,
                `cp -f ${path('codex/filesystems/README.md')} ${path('resources/docs/codex/master/addons/filesystems.md')}`,
                `cp -f ${path('codex/git/README.md')} ${path('resources/docs/codex/master/addons/git.md')}`
            )
        },
        'copy:license': {
            script: series(
                `cp -f ${licensePath} ${path('codex/core/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/algolia-search/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/auth/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/phpdoc/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/sitemap/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/filesystems/LICENSE.md')}`,
                `cp -f ${licensePath} ${path('codex/git/LICENSE.md')}`,
            )
        }
    }
};
