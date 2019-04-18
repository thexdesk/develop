#!/usr/bin/env bash
#git tag -d auth/0.1.0
#git tag -d auth/0.2.0
#git tag -d blog/0.1.0
#git tag -d comments/0.1.0
#git tag -d composer-plugin/1.0.0
#git tag -d filesystems/0.1.0
#git tag -d git/1.0.0
#git tag -d packagist/0.1.0
#git tag -d phpdoc/0.1.0
#git tag -d sitemap/0.1.0

#git push --delete auth 0.1.0
#git push --delete auth 0.2.0
#git push --delete blog 0.1.0
#git push --delete comments 0.1.0
#git push --delete composer-plugin 1.0.0
#git push --delete filesystems 0.1.0
#git push --delete git 1.0.0
#git push --delete packagist 0.1.0
#git push --delete phpdoc 0.1.0
#git push --delete sitemap 0.1.0

git remote remove algolia-search || true
git remote remove auth || true
git remote remove blog || true
git remote remove comments || true
git remote remove composer-plugin || true
git remote remove core || true
git remote remove filesystems || true
git remote remove git || true
git remote remove packagist || true
git remote remove phpdoc || true
git remote remove sitemap || true

git remote add algolia-search github.com:codex-project/algolia-search || true
git remote add auth github.com:codex-project/auth || true
git remote add blog github.com:codex-project/blog || true
git remote add comments github.com:codex-project/comments || true
git remote add composer-plugin github.com:codex-project/composer-plugin || true
git remote add core github.com:codex-project/core || true
git remote add filesystems github.com:codex-project/filesystems || true
git remote add git github.com:codex-project/git || true
git remote add packagist github.com:codex-project/packagist || true
git remote add phpdoc github.com:codex-project/phpdoc || true
git remote add sitemap github.com:codex-project/sitemap || true



git push --delete algolia-search "master}"
git push --delete auth "master}"
git push --delete blog "master}"
git push --delete comments "master}"
git push --delete composer-plugin "master}"
git push --delete core "master}"
git push --delete filesystems "master}"
git push --delete git "master}"
git push --delete packagist "master}"
git push --delete phpdoc "master}"
git push --delete sitemap "master}"
