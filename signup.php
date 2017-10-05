<?php
//<!--Start session-->
session_start();
include('connection.php'); 

//<!--Check user inputs-->
//    <!--Define error messages-->
$missingUsername = '<p><strong>Please enter a username.</strong></p>';
$missingEmail = '<p><strong>Please enter your email address.</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address.</strong></p>';
$missingPassword = '<p><strong>Please enter a password.</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number.</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match.</strong></p>';

//    <!--Get username, email, password, password2-->
//Get username
if(empty($_POST["username"])){
    $errors .= $missingUsername;
}else{
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);   
}
//Get email
if(empty($_POST["email"])){
    $errors .= $missingEmail;   
}else{
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);        //净化过滤器，可能消除不符合规定的字符等
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){                     //验证过滤器不会改变数据本身，只会判断数据是否是一个有效的email
        $errors .= $invalidEmail;   
    }
}
//Get passwords
if(empty($_POST["password"])){
    $errors .= $missingPassword; 
}elseif(!(strlen($_POST["password"])>6
         and preg_match('/[A-Z]/',$_POST["password"])
         and preg_match('/[0-9]/',$_POST["password"])
        )
       ){
    $errors .= $invalidPassword; 
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    }else{                                                         
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password !== $password2){                                  //password2就不用验证是不是valid了
            $errors .= $differentPassword;                             //因为要与password比较，如果两者相等，自然说明password2是valid的
        }
    }
}

//If there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-warning">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}
//no errors

//Prepare variables for the queries
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
//$password = md5($password);
$password = hash('sha256', $password);  //sha函数对字符串进行单项加密
//128 bits -> 32 characters
//256 bits -> 64 characters             //sha256就是64位，比md5算法更不容易产生相同的hash值

//If username exists in the users table print error
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if(!$result){                           //如果mysql执行出现错误
    echo '<div class="alert alert-warning">Error running the query.</div>';      //只知道有错误
//  echo '<div class="alert alert-warning">' . mysqli_error($link) . '</div>';   //知道错误的具体信息
    exit;
}
$results = mysqli_num_rows($result);                                             //取得结果集中行的数目
if($results){                           //mysql执行正确，但是username已经注册过，也就是$results不等于0
    echo '<div class="alert alert-warning">The username is already registered. </div>'; 
    exit;
}

//If email exists in the users table print error
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-warning">Error running the query.</div>'; exit;
}
$results = mysqli_num_rows($result);
if($results){                           //查看是不是0，如果是0就是false，不是0的话，echo出提示
    echo '<div class="alert alert-warning">The email is already registered. </div>';  exit;
}

//Create a unique  activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    //byte: unit of data = 8 bits
    //bit: 0 or 1
    //16 bytes = 16*8 = 128 bits
    //(2*2*2*2)*2*2*2*2*...*2
    //16*16*...*16
    //32 characters

//Insert user details and activation code in the users table
$sql = "INSERT INTO users (`username`, `email`, `password`, `activation`) VALUES ('$username', '$email', '$password', '$activationKey')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-warning">There was an error inserting the users details in the database.</div>'; 
    exit;
}

//Send the user an email with a link to activate.php with their email and activation code
$message = "Please click on this link to activate your account:\n\n";
$message .= "http://mynotes.thecompletewebhosting.com/activate.php?email=" . urlencode($email) . "&key=$activationKey";

if(mail($email, 'Confirm your Registration', $message, 'From:'.'boofcourse@gmail.com')){     //（邮箱收到邮件的显示）
       echo "<div class='alert alert-success'>Thanks for your registring. A confirmation email has been sent to $email.  
       Please click on the activation link to activate your account.</div>";                 //如果发送成功，signup module上的显示echo
}
        
?>