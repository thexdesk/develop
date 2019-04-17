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

            stage('copy theme assets') {
                backend.copyThemeToPackages()
            }

            if (env.DEPLOY_PACKAGES) {
                stage('commit changes') {
                    backend.commitThemeToPackages()
                }

                stage('deploy packages') {
                    def buildJob = radic.build('packages.radic.ninja/deploy')
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        telegramSend "${currentBuild.baseName} ${currentBuild.result}"

    }
}
