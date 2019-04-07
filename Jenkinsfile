#!/usr/bin/env groovy

// https://wiki.jenkins.io/display/JENKINS/Building+a+software+project
//// BUILD_NUMBER                The current build number, such as "153"
//// BUILD_ID                    The current build id, such as "2005-08-22_23-59-59" (YYYY-MM-DD_hh-mm-ss, defunct since version 1.597)
//// BUILD_URL                   The URL where the results of this build can be found (e.g. http://buildserver/jenkins/job/MyJobName/666/)
//// NODE_NAME                   The name of the node the current build is running on. Equals 'master' for master node.
//// JOB_NAME                    Name of the project of this build. This is the name you gave your job when you first set it up. It's the third column of the Jenkins Dashboard main page.
//// BUILD_TAG                   String of jenkins-${JOB_NAME}-${BUILD_NUMBER}. Convenient to put into a resource file, a jar file, etc for easier identification.
//// JENKINS_URL                 Set to the URL of the Jenkins master that's running the build. This value is used by Jenkins CLI for example
//// EXECUTOR_NUMBER             The unique number that identifies the current executor (among executors of the same machine) that's carrying out this build. This is the number you see in the "build executor status", except that the number starts from 0, not 1.
//// JAVA_HOME                   If your job is configured to use a specific JDK, this variable is set to the JAVA_HOME of the specified JDK. When this variable is set, PATH is also updated to have $JAVA_HOME/bin.
//// WORKSPACE                   The absolute path of the workspace.
//// SVN_REVISION                For Subversion-based projects, this variable contains the revision number of the module. If you have more than one module specified, this won't be set.
//// CVS_BRANCH                  For CVS-based projects, this variable contains the branch of the module. If CVS is configured to check out the trunk, this environment variable will not be set.
//// GIT_COMMIT                  For Git-based projects, this variable contains the Git hash of the commit checked out for the build (like ce9a3c1404e8c91be604088670e93434c4253f03) (all the GIT_* variables require git plugin)
//// GIT_URL                     For Git-based projects, this variable contains the Git url (like git@github.com:user/repo.git or [https://github.com/user/repo.git])
//// GIT_BRANCH                  For Git-based projects, this variable contains the Git branch that was checked out for the build (normally origin/master)


node {
    try {
        withEnv([
            'BACKEND_PORT=39967',
            'IS_JENKINS=1'
        ]) {
            stage('SCM') {
                checkout([
                    $class           : 'GitSCM',
                    branches         : scm.branches,
                    extensions       : scm.extensions + [[$class: 'WipeWorkspace']],
                    userRemoteConfigs: scm.userRemoteConfigs,
                ])
                sh 'git submodule update --init --remote --force'
            }

            sh 'mkdir -p html_reports'

            stage('prepare') {
                parallel backend: {
                    stage('install dependencies') {
                        sh 'scripts/ci.sh backend-install'
                    }
                }, frontend: {
                    dir('theme') {
                        sh 'yarn'
                    }
                    dir('theme/app/build') {
                        sh '../../node_modules/.bin/tsc -p tsconfig.json'
                    }
                    dir('theme') {
                        sh 'yarn api build'
                        sh 'yarn app prod:build'
                    }

                }
            }

            stage('merge front/back-end') {
                sh '''
# Clean addons documentation   
rm -f resources/docs/codex/master/addons/algolia-search.md
rm -f resources/docs/codex/master/addons/auth.md
rm -f resources/docs/codex/master/addons/blog.md
rm -f resources/docs/codex/master/addons/comments.md
rm -f resources/docs/codex/master/addons/filesystems.md
rm -f resources/docs/codex/master/addons/git.md
rm -f resources/docs/codex/master/addons/packagist.md
rm -f resources/docs/codex/master/addons/phpdoc.md
rm -f resources/docs/codex/master/addons/sitemap.md

# Copy addon README's to docs
cp -f codex/algolia-search/README.md    resources/docs/codex/master/addons/algolia-search.md
cp -f codex/auth/README.md              resources/docs/codex/master/addons/auth.md
cp -f codex/blog/README.md              resources/docs/codex/master/addons/blog.md
cp -f codex/comments/README.md          resources/docs/codex/master/addons/comments.md
cp -f codex/filesystems/README.md       resources/docs/codex/master/addons/filesystems.md
cp -f codex/git/README.md               resources/docs/codex/master/addons/git.md
cp -f codex/packagist/README.md         resources/docs/codex/master/addons/packagist.md
cp -f codex/phpdoc/README.md            resources/docs/codex/master/addons/phpdoc.md
cp -f codex/sitemap/README.md           resources/docs/codex/master/addons/sitemap.md

# Copy the license to every addon folder and docs
cp -f LICENSE.md                        codex/core/LICENSE.md
cp -f LICENSE.md                        codex/algolia-search/LICENSE.md
cp -f LICENSE.md                        codex/auth/LICENSE.md
cp -f LICENSE.md                        codex/blog/LICENSE.md
cp -f LICENSE.md                        codex/comments/LICENSE.md
cp -f LICENSE.md                        codex/filesystems/LICENSE.md
cp -f LICENSE.md                        codex/git/LICENSE.md
cp -f LICENSE.md                        codex/packagist/LICENSE.md
cp -f LICENSE.md                        codex/phpdoc/LICENSE.md
cp -f LICENSE.md                        codex/sitemap/LICENSE.md
cp -f LICENSE.md                        resources/docs/codex/master/LICENSE.md

# Clean addon assets
rm -rf  codex/core/resources/assets
rm -rf  codex/comments/resources/assets
rm -rf  codex/phpdoc/resources/assets

# Copy the new prod build assets to addons
cp -r  theme/app/dist/vendor/codex_core        codex/core/resources/assets
cp -r  theme/app/dist/vendor/codex_comments    codex/comments/resources/assets
cp -r  theme/app/dist/vendor/codex_phpdoc      codex/phpdoc/resources/assets
'''
            }

            stage('install addons') {
                sh '''
# php artisan codex:addon:enable codex/algolia-search
php artisan codex:addon:enable codex/auth
# php artisan codex:addon:enable codex/blog
php artisan codex:addon:enable codex/comments
php artisan codex:addon:enable codex/filesystems
php artisan codex:addon:enable codex/git
php artisan codex:addon:enable codex/packagist
php artisan codex:addon:enable codex/phpdoc
# php artisan codex:addon:enable codex/sitemap
'''
            }

            parallel 'serve': {
                timeout(time: 10, unit: 'MINUTES') {
                    currentBuild.result = "SUCCESS"
                    sh 'scripts/ci.sh backend-serve'
                }
            }, 'background tasks': {
                stage('background tasks') {
                    parallel 'publish assets': {
                        sh 'rm -rf public/vendor'
                        sh 'php artisan vendor:publish --tag=public'
                    }, 'generate phpdoc': {
                        sh 'scripts/phpdoc.sh'
                        sh 'php artisan codex:phpdoc:generate codex/master -f'
                        sh 'php artisan codex:phpdoc:generate --all'
                    }, 'git sync': {
                        sh 'php artisan codex:git:sync blade-extensions-github -f'
                    }
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        cleanWs cleanWhenFailure: true
    }
}



