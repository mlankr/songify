<?php
    function sanitizeFormPassword($inputText) {
        return strip_tags($inputText);
    }

    function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        return str_replace(" ", "", $inputText);
    }

    function sanitizeFormString($inputText) {
        $inputText = sanitizeFormUsername($inputText);
        return ucfirst(strtolower($inputText));
    }

    if (isset($_POST['registerButton'])) {
        // Register button was pressed
        $username = sanitizeFormUsername($_POST['username']);
        $firstName = sanitizeFormString($_POST['firstName']);
        $lastName = sanitizeFormString($_POST['lastName']);
        $email = sanitizeFormString($_POST['email']);
        $email2 = sanitizeFormString($_POST['email2']);
        $password = sanitizeFormPassword($_POST['password']);
        $password2 = sanitizeFormPassword($_POST['password2']);

        $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

        if ($wasSuccessful) {
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }
    }