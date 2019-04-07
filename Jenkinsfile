#!/usr/bin/env groovy

stage('Prepare') {
    stage('SCM: checkout') {
        checkout scm
        sh "git submodule update --init --remote --force"
    }

    parallel {
        stage('Backend') {
            node('Backend node') {
                stage('clean') {
                    sh 'pwd'
                    sh 'rm -rf ./vendor ./codex-addons'
                }
                stage('install dependencies') {
                    sh 'composer install --no-scripts'
                }
                stage('configuring application') {
                    sh 'cp -f .env.jenkins .env'
                }
                stage('update dependencies') {
                    sh 'composer update'
                }
                stage('Tests') {
                    sh 'echo "done"'
                }
            }
        }
        stage('Frontend') {
            node('Frontend node') {
                dir('theme') {
                    stage('clean') {
                        sh 'pwd'
                    }
                    stage('install dependencies') {
                        sh 'yarn'
                    }
                    stage('build distribution') {
                        sh 'yarn app prod:build'
                    }
                    stage('Tests') {
                        sh 'echo "done"'
                    }
                }
            }
        }

    }
}

