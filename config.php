<?php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Setup the OAuth 2.0 
$google_client->setClientId('469600781897-2aks9ec7sg033f5fm2fgl0ftamoo0r14.apps.googleusercontent.com');
$google_client->setClientSecret('uEWskd5uJZO8RMQldhOTgsBl');
$google_client->setRedirectUri('http://localhost/myqnumber/login.php');

// to get the email and profile 
$google_client->addScope('email');
$google_client->addScope('profile');

//start session on web page
session_start();

?> 