<?php     //这个小部分是接logout的，如果logout，从浏览器点返回上一个页面，还是退出到lougout之前，因此要加这个，使logout后回到主页
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <style>
        #container{
            margin-top:120px;   
        }

        #notePad, #allNotes, #done, .delete{
            display: none;   
        }

        .buttons{
            margin-bottom: 20px; 
            color: white;
        }
        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 15px;
            line-height: 1.5em;
            border-left-width: 25px;
            border-radius: 8px;
            border-color: rgba(44,54,88,0.8);
            color: rgba(44,54,88,0.8);
            background-color: rgb(255, 255, 255, 0.7);
            padding: 10px;
              
        }
        
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
          
        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
          
        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .notes{
            margin-bottom: 100px;
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
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li class="active"><a href="#">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="profile.php"><b><?php echo $_SESSION['username']?></b></a></li>
                      <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              </div>
          </div>   
      </nav>
    
      <!--Container-->
      <div class="container" id="container">
          <!--Alert Message-->
          <div id="alert" class="alert alert-warning collapse">
              <a class="close" data-dismiss="alert">&times;</a>
              <p id="alertContent"></p>
          </div>
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <div class="buttons">
                      <button id="addNote" type="button" class="btn blue">Add Note</button>
                      <button id="edit" type="button" class="btn blue pull-right">Edit</button>
                      <button id="done" type="button" class="btn blue pull-right">Done</button>
                      <button id="allNotes" type="button" class="btn blue">All Notes</button>
                      <!--<button id="save" type="button" class="btn blue pull-right">Save</button>-->
                  </div>
                  
                  <div id="notePad">
                      <textarea rows="10"></textarea>
                  </div>
                  
                  <div id="notes" class="notes">
                  <!-- Ajax call to a php file -->
                  </div>
              
              </div>
          </div>
      </div>

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
    <script src="mynotes.js"></script>  
  </body>
</html>