#!/usr/bin/env bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
#splitsh-lite


CURRENT_BRANCH="develop"

function remote(){
    local PREFIX=bitbucket.org:codex-project
    git remote add $1 "${PREFIX}/$1" || true
}

git pull origin $CURRENT_BRANCH

remote algolia-search
remote auth
remote blog
remote comments
remote composer-plugin
remote core
remote filesystems
remote git
remote packagist
remote phpdoc
remote sitemap
