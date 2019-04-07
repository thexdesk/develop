#!/usr/bin/env bash

# https://www.tldp.org/LDP/abs/html/options.html
# exit on first error
set -e



MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)
THEME_DIR="$ROOT_DIR/theme"

git-submodule-update(){
    cd $ROOT_DIR
    pwd
    git submodule update --init --remote --force
}

backend-install (){
    cd $ROOT_DIR
    pwd
    rm -rf ./vendor ./codex-addons
    composer install --no-scripts
    cp -f .env.jenkins .env
    composer update
    yarn
}


frontend-install() {
    git-submodule-update

    cd $THEME_DIR
    pwd
    yarn

    cd $THEME_DIR/app/build
    pwd
    $THEME_DIR/node_modules/.bin/tsc -p tsconfig.json
}

frontend-build(){
    cd $THEME_DIR
    pwd
    yarn api build
    yarn app prod:build
}

$*
