#!/usr/bin/env groovy

def backendInstallDependencies() {
    stage('install dependencies') {
        sh '''
rm -rf ./vendor ./codex-addons
composer install --no-scripts
composer dump-autoload
yarn
'''
    }
}

def backendSetEnv() {
    stage('set env') {
        sh '''
IPADDR=$(node_modules/.bin/internal-ip --ipv4)
cp -f .env.jenkins .env
php artisan key:generate
php artisan dotenv:set-key APP_URL $IPADDR
php artisan dotenv:set-key BACKEND_HOST $IPADDR
php artisan dotenv:set-key BACKEND_PORT $BACKEND_PORT
php artisan dotenv:set-key BACKEND_URL "http://$IPADDR:$BACKEND_PORT"
php artisan dotenv:set-key CODEX_GIT_GITHUB_TOKEN $GITHUB_TOKEN
php artisan dotenv:set-key CODEX_GIT_GITHUB_SECRET $GITHUB_TOKEN_SECRET
php artisan dotenv:set-key CODEX_GIT_BITBUCKET_KEY $BITBUCKET_KEY
php artisan dotenv:set-key CODEX_GIT_BITBUCKET_SECRET $BITBUCKET_KEY_SECRET

php artisan dotenv:set-key CODEX_AUTH_GITHUB_ID $GITHUB_AUTH_ID
php artisan dotenv:set-key CODEX_AUTH_GITHUB_SECRET $GITHUB_AUTH_SECRET
php artisan dotenv:set-key CODEX_AUTH_BITBUCKET_ID $BITBUCKET_AUTH_ID
php artisan dotenv:set-key CODEX_AUTH_BITBUCKET_SECRET $BITBUCKET_AUTH_SECRET
'''
    }
}


def mergeFrontendToBackend() {
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
cp -r  theme/vendor/codex_core        codex/core/resources/assets
cp -r  theme/vendor/codex_comments    codex/comments/resources/assets
cp -r  theme/vendor/codex_phpdoc      codex/phpdoc/resources/assets
'''
    }
}

def backendGeneratePhpdocStructure() {
    stage('phpdoc structure') {
        sh '''
wget http://phpdoc.org/phpDocumentor.phar

rm -rf phpdoc
php phpDocumentor.phar \
    -t phpdoc --template=xml \
    -d codex/composer-plugin/src \
    -d codex/core/src \
    -d codex/phpdoc/src \
    -d codex/git/src \
    -d codex/semver/src \
    -d vendor/laradic/dependency-sorter \
    -d vendor/laradic/service-provider \
    -d vendor/laradic/support \
    -d vendor/laravel/framework/src/Illuminate/Foundation \
    -d vendor/laravel/framework/src/Illuminate/Container \
    -d vendor/laravel/framework/src/Illuminate/Console \
    -d vendor/laravel/framework/src/Illuminate/Bus \
    -d vendor/laravel/framework/src/Illuminate/Filesystem \
    -d vendor/laravel/framework/src/Illuminate/Routing \
    -d vendor/laravel/framework/src/Illuminate/Http \
    -d vendor/laravel/framework/src/Illuminate/Support \
    -i vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php \
    -i vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/InteractsWithExceptionHandling.php \
    -i vendor/laravel/framework/src/Illuminate/Http/Resources/Json/Resource.php

cp phpdoc/structure.xml resources/docs/codex/master/structure.xml -f
rm -rf phpdoc
'''
    }
}

def backendGeneratePhpdocCache(String packageName = null) {
    if (packageName) {
        stage("phpdoc cache ${packageName}") {
            sh "php artisan codex:phpdoc:generate ${packageName} --force"
        }
    } else {
        stage('phpdoc cache all') {
            sh 'php artisan codex:phpdoc:generate --all'
        }
    }
}


def backendInstallAddons() {
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
}

def backendPublishAssets() {
    stage('publish assets') {
        sh 'rm -rf public/vendor'
        sh 'php artisan vendor:publish --tag=public'
    }
}


def askStartPreviewServer() {
    timeout(time: 10, unit: 'MINUTES') {
        def INPUT_PARAMS = input([
            id        : 'StartPreviewServer',
            message   : 'Start preview server?',
            ok        : 'Start',
            parameters: [
                booleanParam(defaultValue: false, description: '', name: 'START'),
                string(defaultValue: '20', description: 'Timeout in minutes', name: 'TIMEOUT', trim: true)
            ]
        ])
        echo "START: ${INPUT_PARAMS.START}"
        echo "TIMEOUT: ${INPUT_PARAMS.TIMEOUT}"
        return INPUT_PARAMS
    }
}

//noinspection GroovyAssignabilityCheck
node {
    try {
        //noinspection GroovyAssignabilityCheck
        withCredentials([
            usernamePassword(credentialsId: 'github-secret-token', passwordVariable: 'githubTokenSecret', usernameVariable: 'githubToken'),
            usernamePassword(credentialsId: 'bitbucket-key-secret', passwordVariable: 'bitbucketKeySecret', usernameVariable: 'bitbucketKey'),
            usernamePassword(credentialsId: 'auth-github-id-secret', passwordVariable: 'githubAuthSecret', usernameVariable: 'githubAuthId'),
            usernamePassword(credentialsId: 'auth-bitbucket-id-secret', passwordVariable: 'bitbucketAuthSecret', usernameVariable: 'bitbucketAuthId')
        ]) {
            //noinspection GroovyAssignabilityCheck
            withEnv([
                "BACKEND_PORT=39967",
                "IS_JENKINS=1",
                "GITHUB_TOKEN=${githubToken}",
                "GITHUB_TOKEN_SECRET=${githubTokenSecret}",
                "BITBUCKET_KEY=${bitbucketKey}",
                "BITBUCKET_KEY_SECRET=${bitbucketKeySecret}",

                "GITHUB_AUTH_ID=${githubAuthId}",
                "GITHUB_AUTH_SECRET=${githubAuthSecret}",
                "BITBUCKET_AUTH_ID=${bitbucketAuthId}",
                "BITBUCKET_AUTH_SECRET=${bitbucketAuthSecret}",
            ]) {
                stage('checkout') {
                    checkout([
                        $class: 'GitSCM',
                        branches: scm.branches,
                        extensions: scm.extensions + [[$class: 'WipeWorkspace']],
                        userRemoteConfigs: scm.userRemoteConfigs,
                    ])
                }

                stage('install') {
                    sh 'rm -rf ./vendor ./codex-addons'
                    sh 'composer install --no-scripts'
                    sh 'composer dump-autoload'
                    sh 'yarn'
                    backendSetEnv()
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

                stage('test') {
                    sh 'vendor/bin/phpunit'
                }

                stage('split') {
                    sh 'git remote set-url origin bitbucket.org:codex-project/develop'
                    sh 'scripts/split.sh'
                }

                stage('report') {
                    publishHTML([
                        allowMissing         : false,
                        alwaysLinkToLastBuild: false,
                        keepAll              : true,
                        reportDir            : '.codeCoverage/html',
                        reportFiles          : 'index.html',
                        reportName           : 'Code Coverage',
                        reportTitles         : ''
                    ])
                    step([
                        $class              : 'CloverPublisher',
                        cloverReportDir     : '.codeCoverage',
                        cloverReportFileName: 'coverage-clover.xml',
                        healthyTarget       : [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80], // optional, default is: method=70, conditional=80, statement=80
                        unhealthyTarget     : [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50], // optional, default is none
                        failingTarget       : [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]     // optional, default is none
                    ])
                    junit('.codeCoverage/junit.xml')
                }
            }
        }
    } catch (e) {
        throw e
    } finally {
        echo "done"
    }
}


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
