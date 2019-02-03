const {rimraf, series, copy} = require('nps-utils');
const {resolve} = require('path');

const _themePath = resolve(__dirname, '../theme');
const themePath = (...parts) => resolve(_themePath, ...parts);
const path = (...parts) => resolve(__dirname, ...parts);

module.exports = {

    scripts: {
        copy: {
            script: series(
                rimraf(path('public/vendor')),
                `cp -r ${themePath('app/dist/vendor')} ${path('public/vendor')}`
            )
        },
        link: {
            script: series(
                rimraf(path('public/vendor')),
                `ln -s ${themePath('app/dist/vendor')} ${path('public/vendor')}`
            )
        }
    }
};
