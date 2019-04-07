#!/usr/bin/env bash

# https://www.tldp.org/LDP/abs/html/options.html
# exit on first error
set -e



MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)
THEME_DIR="$ROOT_DIR/theme"

alias lv=php "$ROOT_DIR/artisan"


function _load-dotenv {
    source $ROOT_DIR/.env
}
function _getip {
    $ROOT_DIR/node_modules/.bin/internal-ip --ipv4
}
function _git-submodule-update {
    cd $ROOT_DIR
    pwd
    git submodule update --init --remote --force
}
function _backend-install-codex {

    lv codex:addon:enable codex/auth
    lv codex:addon:enable codex/comments
    lv codex:addon:enable codex/filesystems
    lv codex:addon:enable codex/git
    lv codex:addon:enable codex/packagist
    lv codex:addon:enable codex/phpdoc
    lv codex:addon:enable codex/sitemap
    
}
function _backend-install-env {
    local IP=$(getip)
    cp -f $ROOT_DIR/.env.jenkins $ROOT_DIR/.env
    lv dotenv:set-key APP_URL $IP
    lv dotenv:set-key BACKEND_HOST $IP
    lv dotenv:set-key BACKEND_PORT $BACKEND_PORT
    lv dotenv:set-key BACKEND_URL $IP:$BACKEND_PORT
    lv key:generate
}


#############

backend-install (){
    cd $ROOT_DIR
    rm -rf ./vendor ./codex-addons
    composer install --no-scripts
    composer update
    yarn
    _backend-install-env
    _backend-install-codex
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
    lv serve --host=$BACKEND_HOST --port=$BACKEND_PORT
}

$*
