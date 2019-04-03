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
  if(isset($_POST['password'])) {
    $pass = sanitize($_POST['password']);
    $chpass = sanitize($_POST['updatePass']);
    $chpass_check = sanitize($_POST['updatePasscheck']);
    $check_upass = $mli->prepare("SELECT password FROM accounts WHERE ip=?");
    $check_upass->bind_param('s', $_SESSION['ZpZnCNKp0kG']);
    $check_upass->execute();
    $check_upass->store_result();
    $check_num = $check_upass->num_rows;
    $check_upass->bind_result($password);
    $check_upass->fetch();
    if(password_verify($pass, $password)) {
      if($check_num === 1) {
        if((strlen($chpass) <= 60 AND strlen($chpass) >= 8) AND (strlen($chpass_check) <= 60 AND strlen($chpass_check) >= 8)) {
          if($chpass === $chpass_check) {
            $hashed_password = password_hash($chpass, PASSWORD_DEFAULT, ["cost"=>10]);
            $update_user = $mli->prepare("UPDATE accounts SET password=? WHERE ip=?");
            $update_user->bind_param('ss', $hashed_password, $_SESSION['ZpZnCNKp0kG']);
            $update_user->execute();
            $update_user->close();
            $data['success'] = true;
          } else {
            $data['success'] = false;
            $data['error'] = 3;
          }
        } else {
          $data['success'] = false;
          $data['error'] = 2;
        }
      } else {
        $data['success'] = false;
        $data['error'] = 1;
      }
    } else {
      $data['success'] = false;
      $data['error'] = 0;
    }
  }
  echo json_encode($data);
} else {
  echo "You accessed in a wrong way.";
}
?>
