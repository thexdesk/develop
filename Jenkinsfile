#!/usr/bin/env groovy
node {
    stage('SCM') {
        checkout scm
        sh 'git submodule update --init --remote --force'
    }

    stage('Install'){
        sh 'scripts/ci.sh install'
    }

}
