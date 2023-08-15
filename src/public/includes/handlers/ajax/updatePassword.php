<?php

    include_once("../../config.php");

    if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword']) && isset($_POST['username'])) {
        $oldPassword = strip_tags(trim($_POST['oldPassword']));
        $newPassword = strip_tags(trim($_POST['newPassword']));
        $confirmPassword = strip_tags(trim($_POST['confirmPassword']));
        $username = strip_tags(trim($_POST['username']));


        if (empty($username) || empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo json_encode(array('error' => 'Invalid Data! Please try again later'));
            exit();
        }


        if ($newPassword !== $confirmPassword) {
            echo json_encode(array('error' => Constants::$passwordsDoNotMatch));
            exit();
        }

        if (preg_match('/[^A-Za-z0-9]/', $newPassword)) {
            echo json_encode(array('error' => Constants::$passwordNotAlphaNumeric));
            exit();
        }

        if (strlen($newPassword) > 30 || strlen($confirmPassword) < 5) {
            echo json_encode(array('error' => Constants::$passwordCharacters));
            exit();
        }

        $encryptedOldPassword = md5($oldPassword);

        $oldPasswordCheck = "SELECT password FROM users WHERE username='$username' AND password=$encryptedOldPassword";
        $oldPasswordCheckPrepareQuery = $pdo->prepare($oldPasswordCheck);
        $oldPasswordCheckPrepareQuery->execute();
        $oldPasswordData = $oldPasswordCheckPrepareQuery->fetch(PDO::FETCH_ASSOC);
        $isOldPasswordMatched = $oldPasswordData['password'] === $encryptedOldPassword;

        if (!$isOldPasswordMatched) {
            echo json_encode(array('error' => 'Old password is not matched! Please try again'));
            exit();
        } else {
            $encryptedPassword = md5($newPassword);
            $passwordUpdate = "Update users SET password='$encryptedPassword' WHERE username='$username'";
            $passwordUpdatePrepareQuery = $pdo->prepare($passwordUpdate);
            $wasSuccessful = $passwordUpdatePrepareQuery->execute();

            if ($wasSuccessful) {
                echo json_encode(array('success' => 'Password updated successfully!'));
                exit();
            }
        }
    } else {
        echo json_encode(array('error' => 'Something went wrong! Please try again later'));
        exit();
    }