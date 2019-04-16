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
            }

            stage('copy theme assets') {
                backend.copyThemeToPackages()
            }

            if (codex.inCommitMessage('[ci:deploy-packages]')) {
                stage('commit changes') {
                    backend.commitThemeToPackages()
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
