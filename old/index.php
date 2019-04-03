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
    echo '<div class="error_msg">You tried to change sessions.</div>';   // needs to type a css code for error_msg class
  }
?>
<title>Login form</title>
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
<?php
} else {
  if(password_verify($clientIp, $_SESSION['token'])) {
?>
<title>Steganography</title>
<article class="article active">
<h4>Login Successful&nbsp;&nbsp;&nbsp;&nbsp;<a href="/Ciphers/index.html">Ciphers</a>&nbsp;&nbsp;<a href="./dashboard.php">Manage Account</a>&nbsp;&nbsp;<a href="./logout.php">Logout</a></h4>

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

  <div id="main">
		  <h3>SpyCraft Toolkit v0.9</h3>
		  <div id="left">
    <h2>Image: <input id="file" type="file"/></h2>
				<h2>Message:
			    <textarea id="text" placeholder="Encode/Decode Message"></textarea></h2>

				<div class="btns"><span id="hide" class="btn">Encode</span> <span id="read" class="btn">Decode</span></div>
			</div>
			<div id="right">
				<div id="original" class="half">
				  <h2>Target Image:</h2>
				  <img id="img"/>
				</div>
				<div id="stego" class="half">
					<h2>Encoded Image:</h2>
					<img id="cover" src=""/>				</div>
				<div id="messageArea" class="invisible">
					<h2>Message:</h2>
					<div id="message"></div>
				</div>
			</div>
			<div class="clear"></div>
</div>

 <script type="text/javascript" src="steganography.js"></script>

		<script type="text/javascript">

		function handleFileSelect(evt) {
			var original = document.getElementById("original"),
				stego = document.getElementById("stego"),
				img = document.getElementById("img"),
				cover = document.getElementById("cover"),
				message = document.getElementById("message");
			if(!original || !stego) return;

			var files = evt.target.files; // FileList object

			// Loop through the FileList and render image files as thumbnails.
			for (var i = 0, f; f = files[i]; i++) {

				// Only process image files.
				if (!f.type.match('image.*')) {
					continue;
				}

				var reader = new FileReader();

				// Closure to capture the file information.
				reader.onload = (function(theFile) {
					return function(e) {
						img.src = e.target.result;
						img.title = escape(theFile.name);
						stego.className = "half invisible";
						cover.src = "";
						message.innerHTML="";
						message.parentNode.className="invisible";
						updateCapacity();
					};
				})(f);

				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			}
		}

		function hide() {
			var stego = document.getElementById("stego"),
				img = document.getElementById("img"),
				cover = document.getElementById("cover"),
				message = document.getElementById("message"),
				textarea = document.getElementById("text"),
				download = document.getElementById("download");
			if(img && textarea) {
				cover.src = steg.encode(textarea.value, img);
				stego.className = "half";
				message.innerHTML="";
				message.parentNode.className="invisible";
				download.href=cover.src.replace("image/png", "image/octet-stream");
			}
		}

		function read() {
			var img = document.getElementById("img"),
				cover = document.getElementById("cover"),
				message = document.getElementById("message"),
				textarea = document.getElementById("text");
			if(img && textarea) {
				message.innerHTML = steg.decode(img);
				if(message.innerHTML !== "") {
					message.parentNode.className="";
					textarea.value = message.innerHTML;
					updateCapacity();
				}
			}
		}

		function updateCapacity() {
			var img = document.getElementById('img'),
				textarea = document.getElementById('text');
			if(img && text)
				document.getElementById('capacity').innerHTML='('+textarea.value.length + '/' + steg.getHidingCapacity(img) +' chars)';
		}

		window.onload = function(){
			document.getElementById('file').addEventListener('change', handleFileSelect, false);
			document.getElementById('hide').addEventListener('click', hide, false);
			document.getElementById('read').addEventListener('click', read, false);
			hide();
			updateCapacity();
		};
		</script>

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
} ?>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>



    <script  src="js/index.js"></script>



</body>

</html>
