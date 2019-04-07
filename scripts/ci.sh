#!/usr/bin/env bash

# https://www.tldp.org/LDP/abs/html/options.html
# exit on first error
set -e



MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)

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

    cd $ROOT_DIR/theme
    pwd
    yarn

    cd $ROOT_DIR/theme/app/build
    pwd
    $ROOT_DIR/node_modules/.bin/tsc -p tsconfig.json
}

frontend-build(){
    cd $ROOT_DIR
    pwd
    yarn theme api build
    yarn theme app prod:build
}

$*
