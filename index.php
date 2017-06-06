<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with google</title>
  </head>
  <body>
        <title>Login with Google Account</title>
<?php

// autoload classes
require_once __DIR__.'/vendor/autoload.php';

// get OAuth library
require 'oauth-params.inc';

session_start();

// create instance of Google_Client class
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');

$plus = new Google_Service_Plus($client);

// logout user
if (isset($_REQUEST['logout'])) {
   session_unset();
}

// redirect user to secure page on our site after login
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

// get data about user if all is ok with access token
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $me = $plus->people->get('me');

  // Get User data
  $id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];

} else {
  // get the login url   
  $authUrl = $client->createAuthUrl();
}


?>

<div>
    <?php
    /*
     * If login url is there then display login button
     * else print the retieved data
    */
    if (isset($authUrl)) {
        echo "<a class='login' href='" . $authUrl . "'><img src='signin_button.png' height='50px'/></a>";
    } else {
        print "ID: {$id} <br>";
        print "Name: {$name} <br>";
        print "Email: {$email } <br>";
        print "<img src='{$profile_image_url}'> <br>";
        print "Cover  :{$cover_image_url} <br>";
        print "Url: {$profile_url} <br><br>";
        echo "<a class='logout' href='?logout'><button>Logout</button></a>";
    }
    ?>
</div>
</body>
</html>
