#!/usr/bin/env groovy


node {
    stage('checkout') {
        checkout scm
    }
    stage('Prepare') {
        sh 'pwd'
        sh 'rm -rf ./vendor ./codex-addons'
    }
    stage('Install Dependencies') {
        sh 'composer install --no-scripts'
    }
    stage('Configuring Application') {
        sh 'cp -f .env.jenkins .env'
    }
    stage('Update Dependencies') {
        sh 'composer update'
    }
}
