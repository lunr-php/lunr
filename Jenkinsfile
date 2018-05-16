#!groovy
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
                        userRemoteConfigs: [[url: 'https://github.com/M2Mobi/lunr-coding-standard.git']]
                    ]
                checkout scm
            }
        }

        stage('Clean'){
            steps{
                ant_sh('clean')
                dependencies(env.dependency_tool)
                ant_sh('pdepend')
                ant_sh('l10n')
            }
        }

        stage('Code inspection'){
            steps{
                parallel (
                    md: { ant_sh('phpmd-ci') },
                    cpd: { ant_sh('phpcpd') },
                    cs: { ant_sh('phpcs') },
                    loc: { ant_sh('phploc') },
                    doc: { ant_sh('phpdoc') }
                )
            }
        }

        stage('Unit tests'){
            steps{
                ant_sh('phpunit')
            }
            post {
                success {
                    junit 'build/logs/junit.xml'
                }
            }
        }

        stage('SonarQube Analysis'){
            when {
                branch 'master'
            }
            steps{
                withSonarQubeEnv('M2mobi') {
                    sh "sonar-scanner -Dsonar.projectKey=php:lunr -Dsonar.sources=src/ -Dsonar.php.tests.reportPath=build/logs/junit.xml -Dsonar.php.coverage.reportPaths=build/logs/clover.xml"
                }
            }
        }

        stage('Publishing Report'){
            steps{
                parallel (
                    pdepend: {
                        publishHTML(
                            target: [
                                reportName: 'PDepend Reports',
                                reportDir: 'build/pdepend',
                                reportFiles: '',
                                keepAll: true
                            ]
                        )
                    },
                    phpdoc: {
                        publishHTML(
                            target: [
                                reportName: 'PHPDoc Reports',
                                reportDir: 'build/api',
                                reportFiles: 'index.html',
                                keepAll: true
                            ]
                        )
                    },
                    clover:{
                        step(
                            [
                                $class: 'CloverPublisher',
                                cloverReportDir: 'build/logs',
                                cloverReportFileName: 'clover.xml',
                                healthyTarget: [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80],
                                unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 60, statementCoverage: 60],
                                failingTarget: [methodCoverage: 30, conditionalCoverage: 40, statementCoverage: 40]
                            ]
                        )
                        publishHTML(
                            target: [
                                reportName: 'Coverage Reports',
                                reportDir: 'build/coverage',
                                reportFiles: 'index.html',
                                alwaysLinkToLastBuild: true,
                                keepAll: true
                            ]
                        )
                    },
                    pmd: {
                        step(
                            [
                                $class: 'PmdPublisher',
                                canComputeNew: false,
                                defaultEncoding: '',
                                pattern: 'build/logs/pmd.xml',
                                alwaysLinkToLastBuild: true,
                                healthy: '',
                                unHealthy: ''
                            ]
                        )
                    },
                    pmdcpd: {
                        step(
                            [
                                $class: 'DryPublisher',
                                canComputeNew: false,
                                defaultEncoding: '',
                                pattern: 'build/logs/pmd-cpd.xml',
                                alwaysLinkToLastBuild: true,
                                healthy: '',
                                unHealthy: ''
                            ]
                        )
                    },
                    checkstyle: {
                        step(
                            [
                                $class: 'CheckStylePublisher',
                                pattern: 'build/logs/checkstyle.xml',
                                unstableTotalAll: '999',
                                alwaysLinkToLastBuild: true,
                                usePreviousBuildAsReference: false
                            ]
                        )
                    }
                )
            }
            post {
                success {
                    deploy()
                }
            }
        }
    }

    post {
        failure {
            emailext body: 'Please go to $BUILD_URL to see the result.',
                     recipientProviders: [[$class: 'RequesterRecipientProvider'], [$class: 'CulpritsRecipientProvider']],
                     subject: '$JOB_NAME ($GIT_BRANCH): Build $BUILD_DISPLAY_NAME: FAILED',
                     to: '${ENV,var="LUNR_MAILINGLIST"}'
        }
    }

}
