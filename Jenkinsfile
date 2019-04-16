#!/usr/bin/env groovy
import nl.radic.Codex

print(this)
//noinspection GroovyAssignabilityCheck
node {
    try {
        def codex = new Codex(this)
        print(codex)

        codex.useEnv {
            stage('checkout') {
                def s = codex.checkout()
                print(s)
            }

            stage('install') {
                codex.backend
                    .install()
                    .setDotEnv()
                    .enableAddons()
            }

            stage('test') {
                codex.backend.runTests()
            }

            stage('report') {
                codex.backend.reportTests()
            }

            if(codex.inCommitMessage('[ci:build]')) {
                stage('build') {
                    codex.backend.copyThemeToPackages()
                }

                stage('commit') {
                    codex.backend.commitThemeToPackages()
                }
            }


        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
