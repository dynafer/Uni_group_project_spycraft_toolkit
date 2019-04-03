<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  require_once("./.private/function.php");
  require_once("./.private/mysqli.php");
  require_once("./.private/session.php");
  if(isset($_POST['desired_username']) && isset($_POST['desired_password']) && isset($_POST['desired_password_check'])) {
    function sanitize($text) {
      $text = preg_replace("/[\r\n\s\t\'\;\"\=\-\-\#\/*]+/","", htmlspecialchars(stripslashes(trim($text))));
      return $text;
    }
    $desired_username = sanitize($_POST['desired_username']);
    $desired_password = sanitize($_POST['desired_password']);
    $desired_password_check = sanitize($_POST['desired_password_check']);
    if($desired_username != "" AND $desired_password != "" AND $desired_password_check != "") {
      $num_username = $mli->prepare("SELECT username FROM accounts WHERE username=?");
      $num_username->bind_param('s', $desired_username);
      $num_username->execute();
      $num_username->store_result();
      $num_record = $num_username->num_rows;
      $num_username->close();
      if($desired_username != $desired_password) {
        if($num_record <= 0) {
          if((strlen($desired_password) <= 60 AND strlen($desired_password) >= 8) AND (strlen($desired_password_check) <= 60 AND strlen($desired_password_check) >= 8)) {
            if($desired_password === $desired_password_check) {
              $clientIp = get_client_ip();
              if($clientIp === "::1") {
                $clientIp = "127.0.0.1";
              }
              $hashing_password = password_hash($desired_password, PASSWORD_DEFAULT, ["cost"=>10]);
              $iphash = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
              if($register = $mli->prepare("INSERT INTO accounts (username, password, ip) VALUES (?, ?, ?)")) {
                $register->bind_param("sss", $desired_username, $hashing_password, $iphash);
                $register->execute();
                $register->close();
                $data['success'] = true;
              } else {
                $data['success'] = false;
                $data['error'] = 6;
              }
            } else {
              $data['success'] = false;
              $data['error'] = 5;
            }
          } else {
            $data['success'] = false;
            $data['error'] = 4;
          }
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
  }
  echo json_encode($data);
} else {
  echo "You accessed in a wrong way.";
}
?>
