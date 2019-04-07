#!/usr/bin/env groovy
node {
    stage('SCM') {
        checkout scm
        sh 'git submodule update --init --remote --force'
    }

    stage('backend: install'){
        sh 'scripts/ci.sh backend-install'
    }

    stage('frontend: install'){
        sh 'scripts/ci.sh frontend-install'
    }

    stage('frontend: build'){
        sh 'scripts/ci.sh frontend-build'
    }

    stage('frontend: post-build'){
        sh 'echo "done"'
        stage('publish bundle-analyzer'){
            sh 'echo "done"'
        }
    }

}
