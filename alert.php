<?php
    if ($showalert) {
    echo '
    <div class="success">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Success!</strong> Successfully register 
    </div>';
    }
    if ($showerror) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> Password is not match
    </div>';
    }
    if ($Err) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> '.$Err.'
    </div>';
    }
    if ($emailErr) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> '.$emailErr.'
    </div>';
    }
    if ($message) {
    echo '
    <div class="warning">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Warning!</strong> Account already exist 
    </div>';
    }
    ?>