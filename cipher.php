<!DOCTYPE HTML>
<?php
require_once(".private/function.php");
require_once(".private/mysqli.php");
require_once(".private/session.php");

$clientIp = verify_client_ip(get_client_ip());
if($clientIp === false) {
$clientIp = "";
}
if($clientIp === "::1") {
$clientIp = "127.0.0.1";
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
header("Location: ./index.php");
} else {
  if(password_verify($clientIp, $_SESSION['token'])) {
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width">
  <meta name="description" content="Spies never get caught">
  <meta name="keywords" content="Spy, cipher, image steganograpghy,audio steganograpghy">
  <meta name="author" content="Harry,Divian">
  <title>Spycraft Toolkit | Ciphers</title>
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
          <li><a href="index.php">Home</a></li>
          <li><a href="steganography.php">Image Steganograpghy</a></li>
          <li class="current"><a href="cipher.php">Ciphers</a></li>
          <li><a href="dashboard.php">Manage Account</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

    </div>
  </header>
  <section id="ciphers">

    <h1>Ciphers</h1>

    <div class="containerCiphersCV">
      <!-- Caesar Cipher -->
      <div class="titleCaesar">Caesar Cipher
        <div class="input">
          <form id="form-Caesar">
            Message:
            <input type="text" id="plaintextMessage" />
            Shift Amount:
            <input type="number" value="1" id="shift" />
            Encrypted Message:
            <input type="text" id="encryptedMessage" />
          </form>
        </div>
      </div>
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src="js/CaesarCipher.js"></script>
    </div>

    <!-- Vigenère Cipher -->
    <div class="containerCiphersCV">
      <div class="titleCaesar">Vigenère Cipher
        <div class="input">
          <form id="form-Vig">
            Message:
            <input type="text" id="plaintext" />
            Key:
            <input type="text" id="key" value="abc" />
            Encrypted Message:
            <input type="text" id="encryptedText">
            <br>
            <br>
            <button id="btn-encrypt" type="button">Encrypt</button>
            <button id="btn-decrypt" type="button">Decrypt</button>
          </form>
        </div>
      </div>
    </div>
    <script src="js/VigCipher.js"></script>

    <!-- My Cipher -->
    <div class="containerCiphersCV">
      <div class="titleCaesar">My Cipher
      <div class="input">
        <form id="form-Mine">
          Message:
          <input type="text" id="plaintextMes">
          Key:
          <input type="text" id="cipherKey">
          Encrypted Message:
          <textarea id="encryptedOutput" rows="9" cols="78"></textarea>
          <br>
          <br>
          <button id="encrypt-mine" type="button">Encrypt</button>
          <button id="decrypt-mine" type="button">Decrypt</button>
        </form>
      </div>
    </div>
    <script src="js/MyCipher.js"></script>
  </div>

    <!-- Message Retrieval -->
    <div class="containerCiphersCV">
      <div class="titleCaesar">Message Retrieval
      <div class="input">
        <input type="number" id="key1">
        <input type="number" id="key2">
        <input type="number" id="key3">
        <textarea id="inputText" placeholder="" rows="9" cols="78"></textarea>
        <input id="go" class="btn-retrieve" type="submit" value="Retrieve Hidden Message">
      </div>
    </div>
    <script src="js/MessageRet.js"></script>
    </div>

  </div>





  </section>


  <footer>
    <p>Spycraft Toolkit, Copyright &copy; 2019</p>
  </footer>
</body>

</html>
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
