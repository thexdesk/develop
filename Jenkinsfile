#!groovy


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
        sh 'composer update --no-scripts'
    }
}
