//@Grapes(
//    @Grab(group='org.jenkins-ci.plugins', module='docker-workflow', version='1.17')
//)
//import org.jenkins-ci.plugins.docker.workflow;



node('fdsaf') {
    agent any
    stage "asdfdsf"

    stages {

        stage('Checkout Sources') {
            steps {
                checkout scm

            }
        }
        stage('Prepare Installation') {
            steps {
                sh 'rm -rf vendor composer.lock'
            }
            steps {
                sh '''php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');"
php -r "if (hash_file(\'SHA384\', \'composer-setup.php\') === \'544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061\') { echo \'Installer verified\'; } else { echo \'Installer corrupt\'; unlink(\'composer-setup.php\'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink(\'composer-setup.php\');"'''
            }
            steps {
                sh 'php composer.phar global config minimum-stability dev'
                sh 'php composer.phar global config prefer-stable true'
            }
        }
        stage('Install Dependencies') {
            steps {
                sh 'php composer.phar install'
            }
        }
        stage('Unit Tests') {
            steps {
                sh 'php vendor/bin/phpunit'
            }
        }
//        stage('Scan Code Quality') {
//            steps {
//                tool 'sonar-scanner'
//                script {
//                    def scannerHome = tool('sonar-scanner')
//                    withSonarQubeEnv('radic-sonar') {
//                        sh "${scannerHome}/bin/sonar-scanner"
//                    }
//                }
//
//            }
//        }
//        stage('Check Quality') {
//            steps {
//                script {
//
//                    timeout(time: 10, unit: 'MINUTES') { // Just in case something goes wrong, pipeline will be killed after a timeout
//                        def qg = waitForQualityGate() // Reuse taskId previously collected by withSonarQubeEnv
//                        if (qg.status != 'OK') {
//                            error "Pipeline aborted due to quality gate failure: ${qg.status}"
//                        }
//                    }
//                }
//
//            }
//        }
    }
}
