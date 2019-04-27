#!/usr/bin/env groovy

import nl.radic.Radic

def HOST = "192.168.178.59"
def PORT = 34567
def URL = "http://${HOST}:${PORT}"

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
                    .composerInstall(true, false)
                    .composerUpdate(true, true)
                    .yarn()
                    .setDotEnv(URL)
                    .enableAddons()

                sh 'rm -rf public/vendor public/storage'
                backend.artisan('vendor:publish --force --tag=public')
                backend.artisan('storage:link')
            }

            parallel 'Create PHPDoc Manifests': {
                backend.artisan('codex:phpdoc:generate --all')
            }, 'Optimize': {
                backend.artisan('optimize')
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
