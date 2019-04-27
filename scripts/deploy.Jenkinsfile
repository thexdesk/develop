#!/usr/bin/env groovy
import jenkins.model.Jenkins
import nl.radic.Radic

def HOST = "192.168.178.59"
def PORT = 34567
def URL = "http://${HOST}:${PORT}"

//noinspection GroovyAssignabilityCheck
node {
    try {
        print(this)
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
            }

            parallel 'link docs': {
                backend.yarn('nps docs:link')
            }, 'link storage': {
                backend.artisan('storage:link')
            }, 'generate codex phpdoc cache': {
                backend.artisan('codex:phpdoc:generate --all')
            }, 'publish public vendor files': {
                backend.artisan('vendor:publish --force --tag=public')
            }


            stage('Serve') {
                radic.interruptPreviousBuilds()
                radic.currentBuild.description = "Serves dev example at <a href='${URL}' target='_blank'>${URL}</a>"
                radic.currentBuild.result = "SUCCESS"
                backend.artisan("serve --host=${HOST} --port=${PORT}")
            }
        }

    } catch (e) {
        throw e
    } finally {
        echo 'done'
    }
}
