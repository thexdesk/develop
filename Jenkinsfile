#!/usr/bin/env groovy
import nl.radic.Radic

//noinspection GroovyAssignabilityCheck
node {
    try {
        def r = new Radic()
        print(r)

        checkout scm
//        def common = load "${pwd()}/scripts/common.groovy"

        common._withCredentials {
            common._withEnv {
                stage('checkout') {
                    def scmVars = common._checkout()
                    currentBuild.displayName = "build(${env.BUILD_NUMBER}) branch(${scmVars.GIT_BRANCH}) ref(${scmVars.GIT_COMMIT})"
                }

                stage('install') {
                    common.installDependencies()
                    common.setDotEnv()
                    common.laravelEnableAddons()
                }

                stage('test') {
                    common.runTests()
                }

                stage('report') {
                    common.reportTests()
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
