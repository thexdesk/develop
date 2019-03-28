#!/usr/bin/env bash
git tag -d auth/0.1.0
git tag -d auth/0.2.0
git tag -d blog/0.1.0
git tag -d comments/0.1.0
git tag -d composer-plugin/1.0.0
git tag -d filesystems/0.1.0
git tag -d git/1.0.0
git tag -d packagist/0.1.0
git tag -d phpdoc/0.1.0
git tag -d sitemap/0.1.0

git push --delete auth 0.1.0
git push --delete auth 0.2.0
git push --delete blog 0.1.0
git push --delete comments 0.1.0
git push --delete composer-plugin 1.0.0
git push --delete filesystems 0.1.0
git push --delete git 1.0.0
git push --delete packagist 0.1.0
git push --delete phpdoc 0.1.0
git push --delete sitemap 0.1.0
