#!/usr/bin/env groovy


node {
    stage('SCM: checkout') {
        checkout scm
    }
    stage('SCM: update submodule') {
        sh "git submodule update --init --remote --recursive --force"
    }
    stage('Prepare: clean') {
        sh 'pwd'
        sh 'rm -rf ./vendor ./codex-addons'
    }
    stage('Prepare: install dependencies') {
        sh 'composer install --no-scripts'
    }
    stage('Prepare: configuring application') {
        sh 'cp -f .env.jenkins .env'
    }
    stage('Prepare: update dependencies') {
        sh 'composer update'
    }
    stage('Tests') {
//        sh 'composer run test:core -vvv'

        sh 'echo "done"'
    }
}
