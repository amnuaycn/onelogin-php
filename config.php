<?php
// ONELOGIN //
$SUBDOMAIN = 'YOUR_SUBDOMAIN';
$SCOPES = 'openid email profile';
$CLIENT_ID = 'YOUR_CLIENTID';
$CLIENT_SECRET = 'YOUR_CLIENT_SECRET';
$REDIRECT_URI = 'http://localhost:8000';//'YOUR_HOST_URL';
$URL_AUTHORIZE = 'https://'.$SUBDOMAIN.'.onelogin.com/oidc/2/auth';
$URL_ACCESS_TOKEN = 'https://'.$SUBDOMAIN.'.onelogin.com/oidc/2/token';
$URL_RESOURCE_OWNER_DETAILS = 'https://'.$SUBDOMAIN.'.onelogin.com/oidc/2/me';
$URL_LOGOUT = 'https://'.$SUBDOMAIN.'.onelogin.com/oidc/2/logout';
?>
