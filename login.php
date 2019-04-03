<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  require_once(".private/function.php");
  require_once(".private/mysqli.php");
  require_once(".private/session.php");
  $data = array();
  $data['success'] = false;
  $data['checkLog'] = false;
  $clientIp = get_client_ip();
  $iphash = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
  $denied = false;
  if($gets = $mli->prepare("SELECT triedLog, endTime FROM triedlogs WHERE ip=?")) {
    $gets->bind_param('s', $clientIp);
    $gets->execute();
    $gets->store_result();
    $gets_num_record = $gets->num_rows;
    if($gets_num_record <= 0) {
      $trylogged = 1;
      $nothing = "";
      $triedlogged = $mli->prepare("INSERT INTO triedlogs (triedLog, ip, endTime) VALUES (?, ?, ?)");
      $triedlogged->bind_param('iss', $trylogged, $clientIp, $nothing);
      $status = $triedlogged->execute();
      $data['ips'] = $status;
      $triedlogged->close();
    } else {
      $gets->bind_result($tried, $endTime);
      $gets->fetch();
      $currentT = date("Y-m-d H:i:s");
      if($tried >= 3) {    // AND $currentT < $endTime) {
        $data['success'] = false;
        $data['checkLog'] = false;
        $data['error'] = "denied";
        $denied = true;
      } else {
        $failed = $tried+1;
        $endts = '';
        $logged = $mli->prepare("UPDATE triedlogs SET triedLog=?, endTime=? WHERE ip=?");
        $logged->bind_param('iss', $failed, $endts, $clientIp);
        $logged->execute();
        $logged->close();
      }
    }
    $gets->close();
    if($denied === false) {
      $log_m = "Tried Login";
      $logs = $mli->prepare("INSERT INTO logs (posted, ip) VALUES (?, ?)");
      $logs->bind_param("ss", $log_m, $clientIp);
      $logs->execute();
      $logs->close();
      $replaced_uname = preg_replace("/[\r\n\s\t\'\;\"\=\-\-\#\/*]+/","", htmlspecialchars(stripslashes($_POST['username'])));
      $replaced_pass = preg_replace("/[\r\n\s\t\'\;\"\=\-\-\#\/*]+/","", htmlspecialchars(stripslashes($_POST['password'])));      // Replace special characters to empty
      if($stmt = $mli->prepare("SELECT username, password, ip FROM accounts")) {
        $stmt->execute();
        $stmt->bind_result($uname, $password, $chip);
        $data['success'] = false;
        $data['checkLog'] = false;
        $data['error'] = "error";
        while($stmt->fetch()) {
          if($replaced_uname === $uname AND password_verify($replaced_pass, $password) === true) {
            $_SESSION['ZpZnCNKp0kG'] = $iphash;
            $stmt->close();
            $rehashed = password_hash($replaced_pass, PASSWORD_DEFAULT, ["cost"=>10]);
            $update_user = $mli->prepare("UPDATE accounts SET password=?, ip=? WHERE username=?");
            $update_user->bind_param('sss', $rehashed, $iphash, $uname);
            $update_user->execute();
            $update_user->close();
            $_SESSION['ZpZnCNKp0kG'] = $iphash;
            $failed = 0;
            $endts = '';
            $logged = $mli->prepare("UPDATE triedlogs SET triedLog=?, endTime=? WHERE ip=?");
            $logged->bind_param('iss', $failed, $endts, $clientIp);
            $logged->execute();
            $logged->close();
            $data['success'] = true;
            $data['checkLog'] = true;
            $data['error'] = false;
            break;
          }
        }
      }
    }
  }
  echo json_encode($data);
} else {
  echo "You accessed in a wrong way.";
}
?>
