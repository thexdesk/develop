#!/usr/bin/env bash

# https://www.tldp.org/LDP/abs/html/options.html
# exit on first error
set -e



MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)
THEME_DIR="$ROOT_DIR/theme"



function _load-dotenv {
    source $ROOT_DIR/.env
}
function _lv {
    php $ROOT_DIR/artisan $*
}
function _getip {
    $ROOT_DIR/node_modules/.bin/internal-ip --ipv4
}
function _git-submodule-update {
    cd $ROOT_DIR
    pwd
    git submodule update --init --remote --force
}
function _backend-install-codex{
    _lv codex:addon:enable codex/auth
    _lv codex:addon:enable codex/comments
    _lv codex:addon:enable codex/filesystems
    _lv codex:addon:enable codex/git
    _lv codex:addon:enable codex/packagist
    _lv codex:addon:enable codex/phpdoc
    _lv codex:addon:enable codex/sitemap
}
function _backend-install-env {
    local IP=$(getip)
    cp -f $ROOT_DIR/.env.jenkins $ROOT_DIR/.env
    _lv dotenv:set-key APP_URL $IP
    _lv dotenv:set-key BACKEND_HOST $IP
    _lv dotenv:set-key BACKEND_PORT $BACKEND_PORT
    _lv dotenv:set-key BACKEND_URL $IP:$BACKEND_PORT
    _lv key:generate
}


#############

backend-install (){
    cd $ROOT_DIR
    rm -rf ./vendor ./codex-addons
    composer install --no-scripts
    _backend-install-env
    composer update
    yarn
}


frontend-install() {
    _git-submodule-update
    cd $THEME_DIR
    yarn
    cd $THEME_DIR/app/build
    $THEME_DIR/node_modules/.bin/tsc -p tsconfig.json
}

frontend-build(){
    cd $THEME_DIR
    yarn api build
    yarn app prod:build
}

backend-serve(){
    _load-dotenv
    _lv serve --host=$BACKEND_HOST --port=$BACKEND_PORT
}

$*
