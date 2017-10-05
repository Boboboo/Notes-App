<?php
$link = mysqli_connect("localhost", "mynotest_notes", "iT]3y;TwxH*1", "mynotest_onlinenotes");
//$link = mysqli_connect("localhost", "cdwccdwc_notes", "bobo1989..", "cdwccdwc_onlinenotes");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
?>