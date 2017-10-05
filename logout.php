<?php

//如果用户登陆了 & logout值是自己设置的，在mainpageloggedin.php
if(isset($_SESSION['user_id']) && $_GET['logout'] === 1){
    session_destroy();
    setcookie("rememberme", "", time()-3600);    
}

?>