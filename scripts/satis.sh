#!/usr/bin/env bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
ROOT_DIR=$(dirname $MYDIR)
SATIS_DIR="$ROOT_DIR/.tmp/satis"


PORT=8999

function s(){
    php "${SATIS_DIR}/bin/satis" $*
}

function install(){
    cd $(dirname "${SATIS_DIR}")
    rm -rf $SATIS_DIR
    composer create-project composer/satis:dev-master
}

function build(){
    rm -rf "${SATIS_DIR}/public"
    rm -rf "${SATIS_DIR}/cache"
    s build --stats -vvv
}

function serve(){
    cd $SATIS_DIR/public
    php -S localhost:${PORT} -t $SATIS_DIR/public
}

$*
