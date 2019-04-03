<?php
function session_start_better($lifetime = 0, $path = '/', $domain = null, $secure = true, $httponly = true) {
    // Set the initial options of session
    ini_set('session.hash_function', 1);
    ini_set('session.use_cookies', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);
    if (defined('PHP_OS') && !strncmp(PHP_OS, 'Linux', 5))
    {
        ini_set('session.entropy_file', '/dev/urandom');
        ini_set('session.entropy_length', 20);
    }

    // Atually start session
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();

    // If it's HTTPS, check the security cookie
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    {
        // The first to issue a security cookie
        if (!isset($_SESSION['SSLSESSID']))
        {
            $_SESSION['SSLSESSID'] = sha1(pack('V*', rand(), rand(), rand(), mt_rand(), mt_rand()));
            setcookie('SSLSESSID', $_SESSION['SSLSESSID'], $lifetime, $path, $domain, true, true);
            if (isset($_COOKIE[session_name()])) session_regenerate_id();
        }
        // If the security cookie is issued and the cookie doesn't return correctly, the client is considered an attacker.
        elseif (!isset($_COOKIE['SSLSESSID']) || $_COOKIE['SSLSESSID'] !== $_SESSION['SSLSESSID'])
        {
            $_SESSION = array();
            $sp = session_get_cookie_params();
            setcookie(session_name(), '', 0, $sp['path'], $sp['domain'], $sp['secure'], $sp['httponly']);
            setcookie('SSLSESSID', '', 0, $sp['path'], $sp['domain'], true, true);
            session_destroy();
        }
    }
    // 3 minutes after issued the cookie, regenerate and issue a session id.
    $clientIp = get_client_ip();
    if($clientIp === "::1") {
      $clientIp = "127.0.0.1";
    }

    if (isset($_SESSION['AUTOREFRESH'])) {
      if(password_verify($clientIp, $_SESSION['token'])) {
        if ($_SESSION['AUTOREFRESH'] < time() - 180) {
          $_SESSION['AUTOREFRESH'] = time();
          $_SESSION['token'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
          session_regenerate_id();
        }
      }
    } else {
        $_SESSION['AUTOREFRESH'] = time();
        $_SESSION['token'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
    }
    if (isset($_SESSION["LASTACTIVITY"]) && (time() - $_SESSION["LASTACTIVITY"] > 1800)) {
      header("Location: ./logout.php");
    } else {
      if(password_verify($clientIp, $_SESSION['token'])) {
        $_SESSION['LASTACTIVITY'] = time();
      }
      if (isset($_SESSION['AUTOREFRESH'])) {
        if(password_verify($clientIp, $_SESSION['token'])) {
          if ($_SESSION['AUTOREFRESH'] < time() - 180) {
            $_SESSION['AUTOREFRESH'] = time();
            $_SESSION['token'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
            session_regenerate_id();
          }
        }
      } else {
          $_SESSION['AUTOREFRESH'] = time();
          $_SESSION['token'] = password_hash($clientIp, PASSWORD_DEFAULT, ["cost"=>5]);
      }
    }
}
session_start_better();
?>
