#!groovy


node {
    stage('checkout') {
        checkout scm
    }
    stage('Print data') {
        sh 'pwd'
    }
    stage('Prepare Installation') {
        sh 'rm -rf vendor composer.lock'

        // php -r "if (hash_file('SHA384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
        sh '''php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');"
php composer-setup.php
php -r "unlink(\'composer-setup.php\');"'''

        sh 'php composer.phar global config minimum-stability dev'
        sh 'php composer.phar global config prefer-stable true'
    }
    stage('Install Dependencies') {
        sh 'php composer.phar install'
    }
}
