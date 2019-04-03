<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  require_once(".private/function.php");
  require_once(".private/mysqli.php");
  require_once(".private/session.php");
  $data['success'] = false;
  function sanitize($text) {
    $text = preg_replace("/[\r\n\s\t\'\;\"\=\-\-\#\/*]+/","", htmlspecialchars(stripslashes(trim($text))));
    return $text;
  }
  if(isset($_POST['username'])) {
    $username = sanitize($_POST['username']);
    $check_uname = $mli->prepare("SELECT username, password, ip FROM accounts WHERE username=?");
    $check_uname->bind_param('s', $username);
    $check_uname->execute();
    $check_uname->store_result();
    $num_record = $check_uname->num_rows;
    if($num_record <= 0) {
      $data['success'] = true;
    } else {
      $data['success'] = false;
    }
  }
  echo json_encode($data);
} else {
  echo "You accessed in a wrong way.";
}
?>
