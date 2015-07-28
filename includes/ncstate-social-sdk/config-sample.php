<?php

/*** 
    Ideally your server configuration will have the correct default timezone
    setting. If not, uncomment the following line and set it appropriately.
    http://php.net/manual/en/timezones.php
*/
// date_default_timezone_set('America/New_York');

// Define which API's to load. To exclude an API, change value to false.
$load_apis = array(
                'facebook' => true,
                'twitter' => true,
                'instagram' => true
              );


if($load_apis['facebook']) {

// Facebook Config
define('FACEBOOK_APP_ID', 'your_app_id');
define('FACEBOOK_SECRET', 'your_app_secret');

}

if($load_apis['twitter']) {

// Twitter Config
define('CONSUMER_KEY', 'your_consumer_key');
define('CONSUMER_SECRET', 'your_consumer_secret');
define('OAUTH_TOKEN', 'your_oauth_token');
define('OAUTH_TOKEN_SECRET', 'your_token_secret');

}

if($load_apis['instagram']) {

// Instagram Config
define('INSTAGRAM_APP_KEY', 'your_instagram_app_key');

}