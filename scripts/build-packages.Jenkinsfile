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
                radic.git.checkout()
            }

            stage('copy theme to packages') {
                backend.copyThemeToPackages()
            }

            stage('copy docs to packages') {
                backend.copyDocsToPackages()
            }

            if (env.DEPLOY_PACKAGES) {
                stage('commit changes') {
                    backend.commitToPackages()
                }

                stage('deploy packages') {
//                    def buildJob = radic.build('packages.radic.ninja/deploy')
                }
            }

        }

    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
