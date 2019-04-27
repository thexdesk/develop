#!/usr/bin/env groovy

import nl.radic.Radic

def HOST="192.168.178.59"
def PORT=34567

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
                    .setDotEnv("http://${HOST}:${PORT}")
                    .enableAddons()

                sh 'rm -rf vendor/public vendor/storage'
                backend.artisan('vendor:publish --force --tag=public')
                backend.artisan('storage:link')
            }

            parallel 'Create PHPDoc Manifests': {
                backend.artisan('codex:phpdoc:generate --all')
            }, 'Optimize': {
                backend.artisan('optimize')
            }

            stage('Run Checks') {
                backend.composer('checks')
            }

            stage('Serve') {
                backend.artisan("serve --host=${HOST} --port=${PORT}")
            }
        }

    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
