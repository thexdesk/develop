#!/usr/bin/env groovy
import nl.radic.Radic
import nl.radic.semver.SemanticVersion
import nl.radic.semver.VersionList

//noinspection GroovyAssignabilityCheck
node {
    try {
        def radic = new Radic(this)
        def codex = radic.codex()
        def backend = codex.backend

        codex.useEnv {
            stage('checkout') {
                radic.git.checkout()
            }
            telegramSend "start ${currentBuild.getFullProjectName()} ${currentBuild.result}"

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

            if (radic.git.getScmBranch().endsWith('develop')) {
                stage('merge master') {
                    radic.git.setRemote('develop')
                    radic.git.mergeInto('master')
                }
            }
            telegramSend "${currentBuild.getFullProjectName()} ${currentBuild.result}"

        }

    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
