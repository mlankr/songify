<?php

    class Account {
        private $pdo;
        private $errorArray;

        public function __construct($pdo) {
            $this->pdo = $pdo;
            $this->errorArray = array();
        }

        public function login($un, $pw) {
            $encryptedPw = md5($pw);

            $loginQuery = "SELECT * FROM users WHERE username=? AND password=?";
            $preparedStatement = $this->pdo->prepare($loginQuery);
            $preparedStatement->execute(array($un, $encryptedPw));

            if ($preparedStatement->fetchColumn() > 0) {
                return true;
            }
            $this->errorArray[] = Constants::$loginFailed;
            return false;
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
            $this->validateUsername($un);
            $this->validateFirstname($fn);
            $this->validateLastname($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if (empty($this->errorArray)) {
                // Insert into db
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            } else {
                return false;
            }
        }

        public function getError($error) {
            if (!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetails($un, $fn, $ln, $em, $pw) {
            $encryptedPw = md5($pw);
            $profilePic = "assets/images/profile-pics/head.png";
            $date = date("Y-m-d");

            $insertQuery = "INSERT INTO users(username, firstName, lastName, email, password, signUpDate, profilePic) VALUES (?,?,?,?,?,?,?)";
            $preparedStatement = $this->pdo->prepare($insertQuery);
            return $preparedStatement->execute(array($un, $fn, $ln, $em, $encryptedPw, $date, $profilePic));
        }

        private function validateUsername($un) {
            if (strlen($un) > 25 || strlen($un) < 5) {
                $this->errorArray[] = Constants::$usernameCharacters;
                return;
            }

            $checkUsernameQuery = "SELECT username FROM users WHERE username=?";
            $preparedStatement = $this->pdo->prepare($checkUsernameQuery);
            $preparedStatement->execute(array($un));

            if ($preparedStatement->rowCount() > 0) {
                $this->errorArray[] = Constants::$usernameTaken;
            }
        }

        private function validateFirstname($fn) {
            if (strlen($fn) > 25 || strlen($fn) < 2) {
                $this->errorArray[] = Constants::$firstNameCharacters;
            }
        }

        private function validateLastname($ln) {
            if (strlen($ln) > 25 || strlen($ln) < 2) {
                $this->errorArray[] = Constants::$lastNameCharacters;
            }
        }

        private function validateEmails($em, $em2) {
            if ($em != $em2) {
                $this->errorArray[] = Constants::$emailsDoNotMatch;
                return;
            }
            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                $this->errorArray[] = Constants::$emailInvalid;
                return;
            }

            $checkEmailQuery = "SELECT email FROM users WHERE email=?";
            $preparedStatement = $this->pdo->prepare($checkEmailQuery);
            $preparedStatement->execute(array($em));

            if ($preparedStatement->rowCount() > 0) {
                $this->errorArray[] = Constants::$emailTaken;
            }
        }

        private function validatePasswords($pw, $pw2) {
            if ($pw !== $pw2) {
                $this->errorArray[] = Constants::$passwordsDoNotMatch;
                return;
            }
            if (preg_match('/[^A-Za-z0-9]/', $pw)) {
                $this->errorArray[] = Constants::$passwordNotAlphaNumeric;
                return;
            }
            if (strlen($pw) > 30 || strlen($pw) < 5) {
                $this->errorArray[] = Constants::$passwordCharacters;
            }
        }
    }
