<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
session_start();
$provider = new \League\OAuth2\Client\Provider\GenericProvider([
	'scopes' 				  => $SCOPES,
    'clientId'                => $CLIENT_ID,    // The client ID assigned to you by the provider
    'clientSecret'            => $CLIENT_SECRET,    // The client password assigned to you by the provider
    'redirectUri'             => $REDIRECT_URI, // 'https://' . $_SERVER['HTTP_HOST'],
    'urlAuthorize'            => $URL_AUTHORIZE, //'https://example.onelogin.com/oidc/2/auth',
    'urlAccessToken'          => $URL_ACCESS_TOKEN, //'https://example.onelogin.com/oidc/2/token',
    'urlResourceOwnerDetails' => $URL_RESOURCE_OWNER_DETAILS //'https://example.onelogin.com/oidc/2/me'
]);
//Logout
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['UserID']);
  unset($_SESSION['Username']);
  header('location: '.$URL_LOGOUT.'?post_logout_redirect_uri='.$REDIRECT_URI.'&id_token_hint='.$_SESSION["id_token"]);
  exit;
}
// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    
	echo 'If we don have an authorization code then get one ';
	echo "<a href='".$authUrl."'>Login</a>";
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

	  $authUrl = $provider->getAuthorizationUrl();
      $_SESSION['oauth2state'] = $provider->getState();
	  echo 'If we don have an authorization code then get one';
      header('Location: '.$authUrl);
      exit('Invalid state, make sure HTTP sessions are enabled.');

} else {
       try {

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";
		echo 'Id Token: ' . $accessToken->getvalues()['id_token'] . "<br>";
		$_SESSION["id_token"] = $accessToken->getvalues()['id_token'];
        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $provider->getResourceOwner($accessToken);
		$rsw = $resourceOwner->toArray();
        $_SESSION["UserID"] = $rsw['sub'];
		$_SESSION["Username"] = $rsw['preferred_username'];
		echo "<br>";
		echo " userid : ".$_SESSION["UserID"];
    	echo "<br>";
    	echo " name : ".$_SESSION["Username"];
    	echo "<br>";
    	echo "<a href='/?logout'>Logout</a>";
		exit;
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        // Failed to get the access token or user details.
        exit($e->getMessage());
    }

}

?>