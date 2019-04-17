#!/usr/bin/env groovy
import nl.radic.Radic

//noinspection GroovyAssignabilityCheck
node {
    try {
        def radic = new Radic(this)
        def codex = radic.codex()
        def backend = codex.backend

        codex.useEnv {
            stage('checkout') {
                codex.checkout()
                echo codex.scmVars.GIT_BRANCH.toString()
                echo codex.scmVars.GIT_BRANCH.toString().endsWith('develop').toString()
            }



            stage('install') {
                backend
                    .install()
                    .setDotEnv()
                    .enableAddons()
            }

            stage('test') {
                backend.runTests()
            }

            stage('report') {
                backend.reportTests()
            }

            if(codex.scmVars.GIT_BRANCH.toString().endsWith('develop')){
                stage('merge master'){
                    sh 'git fetch origin master'
                    sh 'git pull origin master'
                    sh 'git merge master'
                    sh 'git checkout master'
                    sh 'git merge develop'
                    sh 'git push origin master'
                }
            }
        }

    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
