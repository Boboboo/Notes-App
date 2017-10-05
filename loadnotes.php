<?php
session_start();
include('connection.php');

//get the user_id
$user_id = $_SESSION['user_id'];
//run a query to delete empty notes
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-warning">An error occured!</div>';
    exit;
}
//run a query to look for notes corresponding to user_id
$sql = "SELECT * FROM notes WHERE user_id ='$user_id' ORDER BY time DESC";

//shows notes or alert message
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            $time = date("j/m/Y, h:i:s A", $time);
            
            echo "
            <div class='note'>
                <div class='col-xs-5 col-sm-3 delete'>
                    <button type='button' class='btn blue' style='background-color:white;margin:5px -7px'>Delete</button>
                </div>

                <div class='noteheader' id='$note_id'>
                    <div class='text'>$note</div>      
                    <div class='timetext'>$time</div>    
                </div>              
            </div>";     //整个note包括左面的Delete button和右边的noteheader, noteheader里包括了的所有记录的内容，包括时间
        }
    }else{
        echo '<div class="alert alert-warning">You have not created any notes yet!</div>'; 
        exit;
    }
    
}else{
    echo '<div class="alert alert-warning">An error occured!</div>'; exit;
  //echo "ERROR: Unable to excecute: $sql." . mysqli_error($link);   这样debug比较方便
}

?>