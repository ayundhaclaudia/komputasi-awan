pipeline {
    agent any

    stages {
        stage('Checkout SCM') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                bat 'docker build -t komputasi-image .'
            }
        }

        stage('Run Tests (Optional)') {
            steps {
                bat 'echo Testing application...'
            }
        }

        stage('Deploy') {
            steps {
                bat 'echo Deploy step here'
            }
        }
    }
}
