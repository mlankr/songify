<?php

    class User {
        private $pdo;
        private $username;

        public function __construct($pdo, $username) {
            $this->pdo = $pdo;
            $this->username = $username;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getFirstAndLastName() {
            $userQuery = "SELECT concat(firstName, ' ', lastName) as 'fullName' FROM users WHERE username='$this->username'";
            $userPrepareQuery = $this->pdo->prepare($userQuery);
            $userPrepareQuery->execute();
            $userData = $userPrepareQuery->fetch(PDO::FETCH_ASSOC);
            return $userData['fullName'];
        }

        public function getEmailAddress() {
            $userQuery = "SELECT email FROM users WHERE username='$this->username'";
            $userPrepareQuery = $this->pdo->prepare($userQuery);
            $userPrepareQuery->execute();
            $userData = $userPrepareQuery->fetch(PDO::FETCH_ASSOC);
            return $userData['email'];
        }
    }