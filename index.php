<?php
require_once(".private/function.php");
require_once(".private/session.php");
require_once(".private/mysqli.php");
?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width">
  <meta name="description" content="Spies never get caught">
  <meta name="keywords" content="Spy, cipher, image steganograpghy,audio steganograpghy">
  <meta name="author" content="Harry,Divian">
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <title>Spycraft Toolkit | Welcome</title>
<?php
$clientIp = verify_client_ip(get_client_ip());
if($clientIp === false) {
  $clientIp = "";
}
if($stmt = $mli->prepare("SELECT username, password, ip FROM accounts WHERE ip=?")) {
  $stmt->bind_param("s", $_SESSION['ZpZnCNKp0kG']);
  $stmt->execute();
  $stmt->store_result();
  $num_record = $stmt->num_rows;
  $stmt->bind_result($uname, $password, $chip);
  $stmt->fetch();
} else {
  $num_record = 0;
}
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
    echo '<div class="error_msg">You tried to change sessions.</div>';
  }
?>
  <link href="CSS/login.css" type="text/css" rel="stylesheet" />
</head>
<div class="form">
  <div class="forceColor"></div>
  <div class="topbar">
    <div class="spanColor"></div>
    <input type="text" class="input" id="username" placeholder="Username"/>
    <div class="spanColor"></div>
    <input type="password" class="input" id="password" placeholder="Password"/>
  </div>
  <div class="middle"><a href="./register_form.php">Create an account</a></div>
  <button class="submit" id="submit" >Login</button>
</div>

<script src="js/index.js"></script>

<?php
} else {
  if(password_verify($clientIp, $_SESSION['token'])) {
?>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>

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
  <header>
    <div class="container">
      <div id="branding">
        <img src="./img/spycraftlog.png">
      </div>
      <nav>
        <ul>
          <li class="current"><a href="index.php">Home</a></li>
          <li><a href="steganography.php">Image Steganograpghy</a></li>
          <li><a href="cipher.php">Ciphers</a></li>
          <li><a href="dashboard.php">Manage Account</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

    </div>
  </header>
  <section id="showcase">
    <div class="container">
      <h1>Spycraft Toolkit</h1>
      <p>This toolkit will help a spy who wants to communicate secretly with out getting caught. </p>
    </div>
  </section>
  <section id="spynews">
    <div class="container">
      <h1>Subscribe To Spy News</h1>
      <form>
        <input type="email" placeholder="Enter Email...">
        <button type="submit" class="button_1">Subscribe</button>
      </form>
      <div>
  </section>

  <section id="boxes">
    <div class="container">
      <div class="box">
        <img src="./img/steganography.jpg">
        <h3>Image Steganograpghy</h3>
        <p3>Image steganography is concealing a message within a image file in a hidden way.</p3>
      </div>

      <div class="box">
        <img src="./img/audio.png">
        <h3>Ciphers</h3>
        <p3>A cipher is an algorithim that enrytpts messages and can decrypt messages.</p3>
      </div>
      <div class="box">
        <img src="./img/cipher.png">
        <h3>Audio steganograpghy</h3>
        <p3>Audio steganograpghy is a technique used to transimt informtation by modfying audio signal in a impercetible
          manner.</p3>
      </div>
    </div>

  </section>
  <footer>
    <p>Spycraft Toolkit, Copyright &copy; 2019</p>
  </footer>
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
    echo '<div class="error_msg">Access denied</div>';
  }
} ?>
</body>

</html>
