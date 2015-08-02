<?php

// Convert OptionTree options to default WP options
$options = get_option('option_tree');
update_option('facebook_app_id', $options['FACEBOOK_APP_ID']);
update_option('facebook_secret', $options['FACEBOOK_SECRET']);
update_option('instagram_app_key', $options['INSTAGRAM_APP_KEY']);
update_option('twitter_consumer_key', $options['TWITTER_CONSUMER_KEY']);
update_option('twitter_consumer_secret', $options['TWITTER_CONSUMER_SECRET']);
update_option('oauth_token', $options['OAUTH_TOKEN']);
update_option('oauth_token_secret', $options['OAUTH_TOKEN_SECRET']);