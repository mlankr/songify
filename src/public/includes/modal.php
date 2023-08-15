<?php

?>

<div class="modalContainer">
    <div class="modalOverlay" data-backdrop="1"></div>
    <div id="modal" class="modal">
        <div class="modalContent">
            <div class="modalHeader">
                <span class="modalTitle">Please provide a name</span>
                <span class="close">&times;</span>
            </div>
            <div class="modalBody">
                <input id='inputField' class="inputField" type="text" placeholder="Enter name...">
                <label for="inputField"></label>
                <p class="inputError"></p>
            </div>
            <div class="modalFooter">
                <button class="button dismissButton">NO</button>
                <button class="button confirmButton">YES</button>
            </div>
        </div>
    </div>
</div>