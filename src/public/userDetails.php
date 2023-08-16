<?php
    include_once("includes/includedFiles.php");
?>

<div class="userDetails">
    <div class="container borderBottom">
        <h2 class="alignCenter">EMAIL</h2>
        <label for="email"></label>
        <input type="text" id="email" class="email" name="email" placeholder="Email address..."
               value="<?php echo $userLoggedIn->getEmailAddress(); ?>">
        <span class="message emailMessage"></span>
        <button class="button button-green blockButton saveEmailButton">SAVE</button>
    </div>

    <div class="container borderBottom passwordsInputContainer">
        <h2 class="alignCenter">PASSWORD</h2>
        <label for="oldPassword"></label>
        <input type="password" id="oldPassword" class="oldPassword" name="oldPassword"
               placeholder="Current password...">
        <label for="newPassword1"></label>
        <input type="password" id="newPassword1" class="newPassword1" name="newPassword" placeholder="New password...">
        <label for="newPassword2"></label>
        <input type="password" id="newPassword2" class="newPassword2" name="newPassword2"
               placeholder="Confirm password...">
        <span class="message passwordMessage"></span>
        <button class="button button-green blockButton savePasswordButton">SAVE</button>
    </div>
</div>
