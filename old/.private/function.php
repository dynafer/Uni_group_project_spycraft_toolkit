<?php
function get_client_ip()
{
    if (!isset($_SERVER['REMOTE_ADDR'])) {
        return NULL;
    }
    $proxy_header = "HTTP_X_FORWARDED_FOR";
    $trusted_proxies = array("2001:db8::1", "127.0.0.1");

    if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {

        // Get IP of the client behind trusted proxy
        if (array_key_exists($proxy_header, $_SERVER)) {

            // Header can contain multiple IP-s of proxies that are passed through.
            // Only the IP added by the last proxy (last IP in the list) can be trusted.
            $client_ip = trim(end(explode(",", $_SERVER[$proxy_header])));

            // Validate just in case
            if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                return $client_ip;
            } else {
                return false;
            }
        }
    }

    // In all other cases, REMOTE_ADDR is the ONLY IP we can trust.
    return $_SERVER['REMOTE_ADDR'];
}

function verify_client_ip($ip) {
  if(filter_var($ip, FILTER_VALIDATE_IP)) {
    return $ip;
  } else {
    return false;
  }
}

/*
function hash_password($plaintext) {
    $tempHash = password_hash($plaintext, PASSWORD_DEFAULT, ["cost"=>10]);
    $tempRand = array("random" => [rand(10,34), rand(35, 60)]);
    $tempFakeHash = hash('sha3-512', substr($tempHash, $tempRand["random"][0], $tempRand["random"][1]));
    $tempDivided = array("pH"=>array(), "fH"=>array(), "pHKey"=>substr($tempHash, 0, 7));
    $visited = [substr($tempHash, 7), $tempFakeHash];
    $visitedLen = [strlen($visited[0]), strlen($tempFakeHash)];
    for($i=0; $i < (($visitedLen[0]+1)/3); $i++) {
      array_push($tempDivided["pH"], substr($visited[0], 0, 3));
      $visited[0] = substr($visited[0], 3, strlen($visited[0]));
    }
    for($i=0; $i < (($visitedLen[1]-2)/7); $i++) {
      array_push($tempDivided["fH"], substr($visited[1], 0, 7));
      $visited[1] = substr($visited[1], 7, strlen($visited[1]));
    }
    $completed = $tempDivided["pHKey"];
    for($i=0; $i < count($tempDivided["pH"]); $i++) {
      $completed .= $tempDivided["pH"][$i].$tempDivided["fH"][$i];
    }
    return $completed;
}

function verify_password($plaintext, $hashedtext) {
  $tempText = "";
  $tempKey = substr($hashedtext, 0, 7);
  $tempSubT = substr($hashedtext, 7);
  for($i=0; $i < 18; $i++) {
    $tempText .= substr($tempSubT, 0, 3);
    $tempSubT = substr($tempSubT, 10, strlen($tempSubT));
  }
  $tempText = substr($tempText, 0, strlen($tempText)-1);
  $tempText = $tempKey.$tempText;
  $return = 0;
  if(password_verify($plaintext, $tempText)) {
    $return = 1;
  } else {
    $return = 0;
  }
  return $return;
}

function need_rehash_password($hashedtext) {
  $tempText = "";
  $tempKey = substr($hashedtext, 0, 7);
  $tempSubT = substr($hashedtext, 7);
  for($i=0; $i < 18; $i++) {
    $tempText .= substr($tempSubT, 0, 3);
    $tempSubT = substr($tempSubT, 10, strlen($tempSubT));
  }
  $tempText = substr($tempText, 0, strlen($tempText)-1);
  $tempText = $tempKey.$tempText;
  $return = 0;
  if(password_needs_rehash($tempText, PASSWORD_DEFAULT, ["cost"=>10])) {
    $return = 1;
  } else {
    $return = 0;
  }
  return $return;
}*/
?>
