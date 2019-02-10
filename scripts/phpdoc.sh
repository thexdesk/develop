#!/usr/bin/env bash

rm -rf phpdoc


#phpdoc -t phpdoc \
#    -d vendor/laravel/framework/src \
#    --template=xml



./phpDocumentor.phar \
    -t phpdoc --template=xml \
    -d codex/composer-plugin/src \
    -d codex/core/src \
    -d codex/phpdoc/src \
    -d codex/git/src \
    -d codex/semver/src \
    -d vendor/laradic/dependency-sorter \
    -d vendor/laradic/service-provider \
    -d vendor/laradic/support \
    -d vendor/laravel/framework/src/Illuminate/Foundation \
    -d vendor/laravel/framework/src/Illuminate/Container \
    -d vendor/laravel/framework/src/Illuminate/Console \
    -d vendor/laravel/framework/src/Illuminate/Bus \
    -d vendor/laravel/framework/src/Illuminate/Filesystem \
    -d vendor/laravel/framework/src/Illuminate/Routing \
    -d vendor/laravel/framework/src/Illuminate/Http \
    -d vendor/laravel/framework/src/Illuminate/Support \
    -i vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php \
    -i vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/InteractsWithExceptionHandling.php \
    -i vendor/laravel/framework/src/Illuminate/Http/Resources/Json/Resource.php


#./phpDocumentor.phar \
#    -t phpdoc --template=xml \
#    -f codex/core/src/Codex.php


cp phpdoc/structure.xml resources/docs/codex/master/structure.xml -f

rm -rf phpdoc
