<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  exit;
} else {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-3600);
            setcookie($name, '', time()-3600, '/');
            setcookie($name, '', time()-3600, '/', '.reddico.co.uk');
            setcookie($name, '', time()-3600, '/wp-admin');
            setcookie($name, '', time()-3600, '/wp-content/plugins');
        }
    }
    header("Location: http://google.co.uk");
}
?>