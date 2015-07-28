<?php

require "ncstate-social-sdk.php";

// Facebook example
echo "<h2>Facebook</h2>";
$fb = getFacebook('ncstate', 1);

foreach($fb as $post) {
  echo "<strong>" . date('M d, y', $post['time']) . "</strong><br/>";
  echo $post['message'] . "<br/>";
  echo "<a href=" . $post['url'] . ">" . $post['url'] . "</a><br/><br/>";
}

// Twitter Example
echo "<br/><br/><br/><br/><h2>Twitter</h2>";
$twitter = getTwitter("ncstate", 2);

foreach($twitter as $tweet) {
  $output = "<p><strong>" . date('M d, y', $tweet['time']) . "</strong><br/>" . $tweet['description'];
  if ($tweet['media'][0]->media_url) {
    $output .= "<br/><img src='" . $tweet['media'][0]->media_url . "' />";
  }
  $output .= "</p>";
  echo $output;
}

// Instagram Example
echo "<br/><br/><h2>Instagram</h2>";
$instagram = getInstagram("ncstate", 10, 'thinkanddo');

foreach($instagram as $one_gram) {
  if($one_gram['url'] != null){
      echo '<a href="' . $one_gram['url'] . '"><img width="200" src="' . $one_gram['img'] . '" alt="' . $one_gram['img'] . '"></a>';
  }
}