#!groovy


node {
    stage('checkout') {
        checkout scm
    }
    stage('Prepare') {
        sh 'pwd'
        sh 'rm -rf vendor'
    }
    stage('Install Dependencies') {
        sh 'composer install'
    }
}
