#!groovy

/*
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: CC0-1.0
 */

def ant_sh(String stage){
    sh "/bin/ant ${stage}"
}
def deploy(){
    if(env.deploy){
        sh "salt-connect library project=lunr branch=master env=m2mobi"
    }
}
def dependencies(String dependency_tool){
  try {
      sh "${dependency_tool}  install"
  } catch(error){
      echo "WARNING: Couldn't setup dependencies!"
  }
}
pipeline {
    agent {
        label "web"
    }


    stages {
        stage('Checkout'){
            steps{
                checkout changelog: false, poll: false, scm:
                    [
                        $class: 'GitSCM',
                        branches: [[name: 'master']],
                        doGenerateSubmoduleConfigurations: false,
                        extensions: [[$class: 'RelativeTargetDirectory', relativeTargetDir: '../lunr-coding-standard']],
                        submoduleCfg: [],
                        userRemoteConfigs: [[url: 'https://github.com/lunr-php/lunr-coding-standard.git']]
                    ]
                checkout scm
            }
        }

        stage('Clean'){
            steps{
                ant_sh('clean')
                dependencies(env.dependency_tool)
                ant_sh('pdepend')
            }
            post {
                success {
                    publishHTML([
                        reportName: 'PDepend Reports',
                        reportDir: 'build/pdepend',
                        reportFiles: '',
                        alwaysLinkToLastBuild: true,
                        keepAll: true,
                        allowMissing: false
                    ])
                }
            }
        }

        stage('Code inspection'){
            steps{
                parallel (
                    cpd: { ant_sh('phpcpd') },
                    cs: { ant_sh('phpcs') },
                    stan: { ant_sh('phpstan-ci') },
                    loc: { ant_sh('phploc') }
                )
            }
            post {
                always {
                    recordIssues enabledForFailure: true, tool: cpd(pattern: 'build/logs/pmd-cpd.xml')
                    recordIssues enabledForFailure: true, tool: phpStan(pattern: 'build/logs/phpstan.xml')
                    recordIssues enabledForFailure: true, tool: checkStyle(pattern: 'build/logs/checkstyle.xml'),
                                                          qualityGates: [[threshold: 999, type: 'TOTAL', unstable: true]]
                }
            }
        }

        stage('Unit tests'){
            steps{
                ant_sh('phpunit')
            }
            post {
                success {
                    junit 'build/logs/junit.xml'
                    recordIssues enabledForFailure: true, tool: junitParser(pattern: 'build/logs/junit.xml')
                    step([
                        $class: 'CloverPublisher',
                        cloverReportDir: 'build/logs',
                        cloverReportFileName: 'clover.xml',
                        healthyTarget: [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80],
                        unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 60, statementCoverage: 60],
                        failingTarget: [methodCoverage: 30, conditionalCoverage: 40, statementCoverage: 40]
                    ])
                    publishHTML([
                        reportName: 'Coverage Reports',
                        reportDir: 'build/coverage',
                        reportFiles: 'index.html',
                        alwaysLinkToLastBuild: true,
                        keepAll: true,
                        allowMissing: false
                    ])
                }
            }
        }

        stage('SonarQube Analysis'){
            when {
                branch 'master'
            }
            environment {
                ACCOUNT_KEY = null
                PROJECT_SLUG = null
            }
            steps{
                script {
                    ACCOUNT_KEY = GIT_URL.tokenize('/')[2]
                    PROJECT_SLUG_W_GIT = GIT_URL.tokenize('/')[3]
                    PROJECT_SLUG = PROJECT_SLUG_W_GIT.substring(0, PROJECT_SLUG_W_GIT.lastIndexOf('.'))
                }
                withSonarQubeEnv('M2mobi') {
                    sh """sonar-scanner \\
                            -Dsonar.projectKey=${ACCOUNT_KEY}:backend:${PROJECT_SLUG} \\
                            -Dsonar.projectName=Lunr \\
                            -Dsonar.sources=src/ \\
                            -Dsonar.php.tests.reportPath=build/logs/junit.xml \\
                            -Dsonar.php.coverage.reportPaths=build/logs/clover.xml"""
                    sh "./tests/get-sonar-report.sh ${ACCOUNT_KEY}:backend:${PROJECT_SLUG}"
                }
            }
            post {
                always {
                    recordIssues enabledForFailure: true, tool: sonarQube(pattern: 'build/logs/sonar-report.json')
                }
            }
        }
    }

    post {
        success {
            deploy()
        }
        failure {
            emailext body: 'Please go to $BUILD_URL to see the result.',
                     recipientProviders: [[$class: 'RequesterRecipientProvider'], [$class: 'CulpritsRecipientProvider']],
                     subject: '$JOB_NAME ($JOB_BASE_NAME): Build $BUILD_DISPLAY_NAME: FAILED',
                     to: '${ENV,var="LUNR_MAILINGLIST"}'
        }
    }

}
