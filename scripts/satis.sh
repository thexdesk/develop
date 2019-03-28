#!/usr/bin/env bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)
SATIS_DIR="$ROOT_DIR/.tmp/satis"


PORT=8999

function s(){
    php "${SATIS_DIR}/bin/satis" $*
}
function _add(){
    s add bitbucket.org:codex-project/$1
}
function add-packages(){
    _add algolia-search
    _add auth
    _add blog
    _add comments
    _add composer-plugin
    _add core
    _add filesystems
    _add git
    _add packagist
    _add phpdoc
    _add sitemap
}

function install(){
    cd $(dirname "${SATIS_DIR}")
    rm -rf $SATIS_DIR
    composer create-project composer/satis:dev-master
}

function build(){
    rm -rf "${SATIS_DIR}/public"
    s build --stats -vvv
}

function serve(){
    cd $SATIS_DIR/public
    php -S localhost:${PORT} -t $SATIS_DIR/public
}

$*
