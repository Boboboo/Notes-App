<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQL_ASSOC); 
    $username = $row['username'];
    $email = $row['email']; 
}else{
    echo "There was an error retrieving the username and email from the database";   
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Quicksand|Roboto" rel="stylesheet" type='text/css'>
      <style>
        #container{
            margin-top:120px;
            background-color: rgb(132, 175, 207); 
            border-radius: 20px;
            height:auto;
        }

        #notePad, #allNotes, #done{
            display: none;   
        }

        .buttons{
            margin-bottom: 20px;   
        }

        h3{
           margin-bottom: 30px;   
          
        }  
    
        .tablecontent{
            background-color:#ffffff;
        }
          
        tr{
            cursor: pointer;    
        }
      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
            
              <div class="navbar-header">
              
                  <a class="navbar-brand">Online Notes</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="home.php">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="mainpageloggedin.php">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><b><?php echo $username; ?></b></a></li>
                      <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              
              </div>
          </div>
      
      </nav>
    
<!--Container-->
      <div class="container" id="container">
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <h3>My Profile</h3>
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed table-bordered">
                          <tr data-target="#updateusername" data-toggle="modal">
                              <td class="blue">Username</td>
                              <td class="tablecontent"><?php echo $username; ?></td>
                          </tr>
                          <tr data-target="#updateemail" data-toggle="modal">
                              <td class="blue">Email</td>
                              <td class="tablecontent"><?php echo $email ?></td>
                          </tr>
                          <tr data-target="#updatepassword" data-toggle="modal">
                              <td class="blue">Password</td>
                              <td class="tablecontent">hidden</td>
                          </tr>
                      </table>
                  </div>
              
              </div>
          </div>
      </div>

    <!--Update username-->    
      <form method="post" id="updateusernameform">
         <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">&times;</button>
                  <h4 id="myModalLabel">Edit Username</h4>
                </div>
                
                <div class="modal-body">
                  <!--update username message from PHP file-->
                  <div id="updateusernamemessage"></div>
                  <div class="form-group">
<!--                      <label for="username" >Username</label>-->
                      <input class="form-control" type="text" name="username" id="username" maxlength="30" value="<?php echo $username; ?>">
                  </div>   
                </div>
                
                <div class="modal-footer">
                  <input class="btn blue" name="updateusername" type="submit" value="Submit">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
                </div>
              </div>
            </div>
         </div>
      </form>

    <!--Update email-->    
      <form method="post" id="updateemailform">
        <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">&times;</button>
                  <h4 id="myModalLabel">Enter New Email </h4>
                </div>
                
                <div class="modal-body">
                  <!--Update email message from PHP file-->
                  <div id="updateemailmessage"></div>
                  <div class="form-group">
<!--                      <label for="email" >Email</label>-->
                      <input class="form-control" type="email" name="email" id="email" maxlength="50" value="<?php echo $email ?>">
                  </div> 
                </div>
                
                <div class="modal-footer">
                  <input class="btn blue" name="updateusername" type="submit" value="Submit">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
                </div>
               </div>
             </div>
         </div>
      </form>
      
    <!--Update password-->    
      <form method="post" id="updatepasswordform">
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal"> &times;</button>
                  <h4 id="myModalLabel">Enter Current and New Password</h4>
                </div>
                
                <div class="modal-body">
                  <!--Update password message from PHP file-->
                  <div id="updatepasswordmessage"></div>
                  <div class="form-group">
                      <label for="currentpassword" class="sr-only" >Current Password</label>
                      <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30" placeholder="Current Password">
                  </div>
                  <div class="form-group">
                      <label for="password" class="sr-only" >New Password</label>
                      <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="New Password">
                  </div>
                  <div class="form-group">
                      <label for="password2" class="sr-only" >Confirm Password</label>
                      <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm Password">
                  </div>  
                </div> 
                
                <div class="modal-footer">
                  <input class="btn blue" name="updateusername" type="submit" value="Submit">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
                </div>
               </div>
            </div>
         </div>
      </form>
      
    <!-- Footer-->
      <div class="footer">
          <div class="container">
              <p>Bo Copyright &copy; 2017-<?php $today = date("Y"); echo $today?>.</p>
          </div>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="profile.js"></script>
  </body>
</html>