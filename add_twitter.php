<?php

require('config.php');
require('TwitterAPIExchange.php');


echo '<form id="form1" name="form1" method="post" action="add_twitter.php">
<label for="display_name">Tweet: </label>
<input type="text" id="q" name="q" />
<br /><br />
<input name="submit" type="submit" id="submit" value="Tweet" />
<input type="hidden" name="submitted" value="TRUE" />
</form>';

if (isset($_POST['submitted'])) {
	
	$twit = htmlspecialchars($_POST['q'], ENT_QUOTES, 'UTF-8');
	
	if(empty($twit)) {
		echo '<div class="alert alert-danger">Please add something.</div>';
	} else {
		
		$settings = array(
		'oauth_access_token' => $oauth_access_token,
		'oauth_access_token_secret' => $oauth_access_token_secret,
		'consumer_key' => $consumer_key,
		'consumer_secret' => $consumer_secret
		);
	
		$connection = new TwitterAPIExchange($settings);
		$url = 'https://api.twitter.com/1.1/statuses/update.json';
		
		$requestMethod = "POST";
		$user = $twitter_user;
		
		$postfields = array(
			'screen_name' => $user,
			'status' => $twit ); 
		
		$connection->buildOauth($url, $requestMethod)
					 ->setPostfields($postfields)
					 ->performRequest();

	}
}

?>	