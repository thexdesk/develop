#!/usr/bin/env groovy
import nl.radic.Radic

//noinspection GroovyAssignabilityCheck
node {
    try {
        def radic = new Radic(this)
        def php = radic.php
        def codex = radic.codex()
        def backend = codex.backend

        codex.useEnv {
            stage('checkout') {
                radic.git.checkout()
                php.pdepend(['src'] as String[])
            }

            stage('install') {
                backend
                    .unlockComposer()
                    .install(true, false)
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
                    radic.git.setRemote("${codex.remoteSshUrl}/develop.git")
                    radic.git.mergeInto('master')
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
