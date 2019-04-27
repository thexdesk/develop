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

            stage('install') {
                backend
                    .unlockComposer()
                    .install(true, false)
                    .setDotEnv('http://192.168.178.59:34567')
                    .enableAddons()

                sh 'rm -rf vendor/public vendor/storage'
                backend.artisan('vendor:publish --force --tag=public')
                backend.artisan('storage:link')
            }

            parallel 'Create PHPDoc Manifests': {
                backend.artisan('codex:phpdoc:generate --all')
            }, 'Optimize': {
                backend.composer('optimize')
            }

            stage('Run Checks') {
                backend.composer('checks')
            }

            stage('Serve') {
                backend.artisan('serve')
            }
        }

    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
