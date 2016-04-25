#!groovy
def ant(stage){
  sh "/bin/ant $stage"
}

node('web'){
    checkout changelog: false, poll: false, scm:
        [
            $class: 'GitSCM',
            branches: [[name: 'master']],
            doGenerateSubmoduleConfigurations: false,
            extensions: [[$class: 'RelativeTargetDirectory', relativeTargetDir: '../lunr-coding-standard']],
            submoduleCfg: [],
            userRemoteConfigs: [[url: 'https://github.com/M2Mobi/lunr-coding-standard.git']]
        ]


    stage 'Checkout'
    checkout scm

    stage 'Clean'
    ant('clean')
    ant('setup')
    ant('pdepend')
    ant('l10n')

    stage 'Code inspection'
    parallel (
        md: {
            ant('phpmd-ci')
        },
        cpd: {
            ant('phpcpd')
        },
        cs: {
            ant('phpcs-ci')
        },
        loc: {
            ant('phploc')
        },
        doc: {
            ant('phpdoc')
        },
    )

    try {
        stage 'Unit tests'
        ant('phpunit')
        stage 'Publishing Report'
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
                        cloverReportFileName: 'clover.xml'
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
        stage 'Deploying build'
        if(env.deploy){
            sh "salt-connect library project=lunr branch=master env=m2mobi"
        }
    } catch (err) {
        stage 'Reporting to users'
        echo "Caught: ${err}"
        currentBuild.result = 'FAILURE'
        /* mail (to: '${env.LUNR_MAILINGLIST}', subject: "Job '${env.BUILD_DISPLAY_NAME}' failed", body: "Please go to ${env.BUILD_URL} to see the error."); */
    } finally {
        /* mail (to: '${env.CHANGE_AUTHOR_EMAIL}', subject: "Job '${env.BUILD_DISPLAY_NAME}' finished", body: "Please go to ${env.BUILD_URL} to see the result."); */
    }
}
