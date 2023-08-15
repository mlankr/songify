<?php
    include_once("includes/includedFiles.php");
?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1 class="alignCenter"><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
            <img class="profilePicture" src="assets/images/profile-pics/user.png" alt="Profile picture">
        </div>
    </div>

    <div class="buttonItems">
        <button id="userDetails" class="button blockButton button-main-animate userDetails">USER DETAILS</button>
        <button id="logout" class="button blockButton button-main-animate logout">LOGOUT</button>
    </div>
</div>
