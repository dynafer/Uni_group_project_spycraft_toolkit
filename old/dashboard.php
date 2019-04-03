<?php
require_once(".private/function.php");
require_once(".private/mysqli.php");
require_once(".private/session.php");
?>
<!DOCTYPE html>
<html lang="en" >
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
$stmt = $mli->prepare("SELECT username, password, ip FROM accounts WHERE ip=?");
$stmt->bind_param("s", $_SESSION['ZpZnCNKp0kG']);
$stmt->execute();
$stmt->store_result();
$num_record = $stmt->num_rows;
$stmt->bind_result($uname, $password, $chip);
$stmt->fetch();
if($num_record <= 0) {
  header("Location: ./logout.php");
} else {
  if(password_verify($clientIp, $_SESSION['token'])) {
?>
<title>Dashboard</title>
<article class="article active">

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v3.2'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="2214860708728424"
  theme_color="#000000"
  logged_in_greeting="Hi, we are the Spycraft Toolkit admins. How may we help you?"
  logged_out_greeting="Hi, we are the Spycraft Toolkit admins. How may we help you?">
</div>

<h4>Dashboard&nbsp;&nbsp;&nbsp;&nbsp;<a href="./index.php">Main</a>&nbsp;&nbsp;<a href="./logout.php">Logout</a></h4>
  <div id="main">
    <h3>Change password</h3>
    <div id="right">
      <table>
        <tr>
          <td>
            <h2>Current Password:</h2>
          </td>
          <td>
            <input type="password" id="current_password">
          </td>
        </tr>
        <tr>
          <td>
            <h2>Change Password:</h2>
          </td>
          <td>
            <input type="password" id="change_password">
          </td>
        </tr>
        <tr>
          <td>
            <h2>Confirm Password:</h2>
          </td>
          <td>
            <input type="password" id="change_password_check">
          </td>
        </tr>
      </table>
      <h3 id="status_update"></h3>
      <button id="submit">Update</button>
    </div>
    <div class="clear"></div>
  </div>
</article>
<?php
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
}
?>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/dashboard.js"></script>

  </body>

</html>
