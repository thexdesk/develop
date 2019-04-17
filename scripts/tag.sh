#!/usr/bin/env bash

set -e

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
BRANCH_NAME=$(git symbolic-ref -q HEAD)
BRANCH_NAME=${BRANCH_NAME##refs/heads/}
BRANCH_NAME=${BRANCH_NAME:-HEAD}


CURRENT_BRANCH=${BRANCH_NAME}


function tag-package(){
    local REPO="${1}"
    local TAG="${2}"

    TMP_DIR="/tmp/codex-tag-${REPO}"
    REMOTE_URL="git@bitbucket.org:codex-project/${REPO}.git"

    rm -rf $TMP_DIR;
    mkdir $TMP_DIR;

    git pull origin $CURRENT_BRANCH

    cd $TMP_DIR;

    git clone $REMOTE_URL .
    git checkout "$CURRENT_BRANCH";

    git tag $TAG
    git push origin --tags
}


$*
