<!DOCTYPE html>
<html lang="en" >
<?php
require_once("./.private/function.php");
require_once("./.private/mysqli.php");
require_once("./.private/session.php");
?>
<head>
  <meta charset="UTF-8">

<link href='https://fonts.googleapis.com/css?family=Raleway:300,200' rel='stylesheet' type='text/css'>


      <link rel="stylesheet" href="css/style.css">


</head>

<body>
<?php

$clientIp = verify_client_ip(get_client_ip());
if($clientIp === false) {
  $clientIp = "";
}
if($clientIp === "::1") {
  $clientIp = "127.0.0.1";
}
$stmt = $mli->prepare("SELECT username, password, ip FROM accounts WHERE password=?");
$stmt->bind_param("s", $_SESSION['ZpZnCNKp0kG']);
$stmt->execute();
$stmt->store_result();
$num_record = $stmt->num_rows;
$stmt->bind_result($uname, $password, $chip);
$stmt->fetch();
if($num_record <= 0) {
  if($_SESSION['ZpZnCNKp0kG']) {
    if(!$_SESSION['token2']) {
      $log_m = "Tried to change a session id.";
      $logs = $mli->prepare("INSERT INTO logs (posted, ip) VALUES (?, ?)");
      $logs->bind_param("ss", $log_m, $clientIp);
      $logs->execute();
      $logs->close();
      $_SESSION['token2'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
    }
    echo '<div class="error_msg">You tried to change sessions.</div>';   // needs to type a css code for error_msg class
  }
?>
<title>Register form</title>
<div class="form">
  <div class="forceColor"></div>
  <div class="topbar">
    <div class="spanColor"></div>
    <input type="text" class="input" id="username" placeholder="Username"/>
    <div class="spanColor1"></div>
    <input type="password" class="input1" id="password" placeholder="Password"/>
    <div class="spanColor2"></div>
    <input type="password" class="input2" id="password_check" placeholder="Confirm Password"/>
  </div>
  <div class="middle" id="status">&nbsp;</div>
  <button class="submit" id="submit" >Register</button>
</div>
<?php
} else {
  if(password_verify($clientIp, $_SESSION['token'])) {
    echo "Error!";
  } else {
    if(!$_SESSION['token2']) {
      $log_m = "Tried to hijack a session.";
      $logs = $mli->prepare("INSERT INTO logs (posted, ip) VALUES (?, ?)");
      $logs->bind_param("ss", $log_m, $clientIp);
      $logs->execute();
      $logs->close();
      $_SESSION['token2'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
    }
    echo '<div class="error_msg">Access denied</div>';   // needs to type a css code for error_msg class
  }
} ?>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>



    <script  src="js/register.js"></script>



</body>

</html>
