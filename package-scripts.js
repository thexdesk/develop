const {rimraf, series, copy, mkdirp} = require('nps-utils');
const {resolve} = require('path');

const _themePath = resolve(__dirname, '../theme');
const themePath = (...parts) => resolve(_themePath, ...parts);
const path = (...parts) => resolve(__dirname, ...parts);

module.exports = {

    scripts: {
        copy       : {

            script: series(
                rimraf(path('public/vendor')),
                `cp -r ${themePath('app/dist/vendor')} ${path('public/vendor')}`
            )
        },
        link       : {
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
        'copy:assets': {
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
        }
    }
};
