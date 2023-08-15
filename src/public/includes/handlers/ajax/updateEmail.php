<?php

    include_once("../../config.php");

    if (isset($_POST['username']) && isset($_POST['email'])) {
        $username = strip_tags(trim($_POST['username']));
        $email = strip_tags(trim($_POST['email']));


        if (empty($username) || empty($email)) {
            echo json_encode(array('error' => 'Invalid Data! Please try again later'));
            exit();
        }


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('error' => 'Email is invalid!'));
            exit();
        }


        $sameEmailCheck = "SELECT email FROM users WHERE username='$username'";
        $sameEmailCheckPrepareQuery = $pdo->prepare($sameEmailCheck);
        $sameEmailCheckPrepareQuery->execute();
        $oldEmail = $sameEmailCheckPrepareQuery->fetch(PDO::FETCH_ASSOC);
        $isSameEmail = $oldEmail['email'] === $email;

        if ($isSameEmail) {
            echo json_encode(array('error' => 'Current email is same as the new one!'));
            exit();
        }

        $emailTakenCheck = "SELECT email FROM users WHERE email='$email' AND username!='$username'";
        $emailTakenCheckPrepareQuery = $pdo->prepare($emailTakenCheck);
        $emailTakenCheckPrepareQuery->execute();
        $isEmailUsed = $emailTakenCheckPrepareQuery->rowCount() > 0;

        if ($isEmailUsed) {
            echo json_encode(array('error' => 'Email is already taken!'));
            exit();
        }

        $emailUpdate = "Update users SET email='$email' WHERE username='$username'";
        $emailUpdatePrepareQuery = $pdo->prepare($emailUpdate);
        $wasSuccessful = $emailUpdatePrepareQuery->execute();

        if ($wasSuccessful) {
            echo json_encode(array('success' => 'Email updated successfully!'));
            exit();
        }
    } else {
        echo json_encode(array('error' => 'Something went wrong! Please try again later'));
        exit();
    }