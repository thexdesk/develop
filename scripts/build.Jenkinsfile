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


        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
