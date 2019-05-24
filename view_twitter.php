<?php

require('config.php');
require('TwitterAPIExchange.php');


$settings = array(
'oauth_access_token' => $oauth_access_token,
'oauth_access_token_secret' => $oauth_access_token_secret,
'consumer_key' => $consumer_key,
'consumer_secret' => $consumer_secret
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";

if (isset($_GET['user'])) 
{
	$user = $_GET['user'];
} else {
	$user = $twitter_user;
}

if (isset($_GET['count'])) 
{
	$count = $_GET['count'];
} else {
	$count = 20;

}

$getfield = "?screen_name=$user&count=$count";

$twitter = new TwitterAPIExchange($settings);

$tweets = json_decode($twitter->setGetfield($getfield)
							  ->buildOauth($url, $requestMethod)
							  ->performRequest(),$assoc = TRUE);

if(array_key_exists("errors", $tweets)) {
	echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$tweets[errors][0]["message"]."</em></p>";
	exit();
}


foreach($tweets as $twit)
{
	
	$id = $twit['id'];
	$tweet = $twit['text'];
	$by = $twit['user']['name'];
	$created = $twit['created_at'];
		
	echo "Time and Date of Tweet: <b>".$created."</b><br />";
	echo "Tweet: <b>". $tweet."</b><br />";
	echo "Tweeted by: <b>". $by."</b>";
	echo "Tweet ID: <b>". $id."</b>";
	
}
	
?>	