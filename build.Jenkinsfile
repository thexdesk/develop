#!/usr/bin/env groovy

//noinspection GroovyAssignabilityCheck
node {
    try {
        def common = load "${WORKSPACE}@script/scripts/common.groovy"
        common._withCredentials {
            common._withEnv {
                stage('checkout') {
                    def scmVars = common._checkout
                    currentBuild.displayName = "build(${env.BUILD_NUMBER}) branch(${scmVars.GIT_BRANCH}) ref(${scmVars.GIT_COMMIT})"
                }

                stage('install') {
                    common.installDependencies()
                    common.setDotEnv()
                    common.enableAddons()
                }

                stage('build') {
                    common.copyThemeToPackages()
                }

                stage('commit') {
                    sh 'git add -A'
                    sh 'git commit -m "copy new assets"'
                    sh 'git push --all'
                    sh 'scripts/split.sh'
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}
