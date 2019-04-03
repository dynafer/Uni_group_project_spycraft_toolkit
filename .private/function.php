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
  // Check whether the input is validated as IP address format.
  if(filter_var($ip, FILTER_VALIDATE_IP)) {
    return $ip;
  } else {
    return false;
  }
}
?>
