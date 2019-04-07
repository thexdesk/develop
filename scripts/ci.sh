#!/usr/bin/env bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)


backend-install (){
    cd $ROOT_DIR
    pwd
    rm -rf ./vendor ./codex-addons
    composer install --no-scripts
    cp -f .env.jenkins .env
    composer update
}


frontend-install() {
    cd $ROOT_DIR
    pwd
    git submodule update --init --remote --force
    cd $ROOT_DIR/theme
    pwd
    yarn
    yarn app prod:build
}

install(){
    backend-install
    frontend-install
}

$*
