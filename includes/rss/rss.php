<?php

function load_rss_feed($args){
	
	// set defaults
	$source = "";
	$cache = ""; 		// name of cache file
	$timeout = 60*60*4;	//cache timeout - default 4 day
	$type = "";
	
	// set inputted values
	if(array_key_exists("source",$args))	$source	= $args["source"];
	if(array_key_exists("cache",$args))	$cache = $args["cache"];
	if(array_key_exists("timeout",$args))	$timeout = $args["timeout"];
	if(array_key_exists("type",$args))	$timeout = $args["type"];
	
	// check for required arguments
	if(strlen($source) < 1){ echo "<p>Feed source not provided.</p>"; return; }
	
	// content of feed - either from cache or curl
	$feedContent = "";
	
	// check cache if provided - if valid, echo and return
	if(strlen($cache) > 0){
		
		$cache = $_SERVER['DOCUMENT_ROOT'] . "/_cache/" . $cache;
		
		if(file_exists($cache)){
			
			$modified = filemtime($cache);
			
			if((time() - $timeout) < $modified){
				
				$feedContent = file_get_contents($cache);
				
			} 
		
		}
	
	}
	
	// create curl object and set options
	// set useragent for if facebook feed - This is basically a hack
	
	if(strlen($feedContent) < 1){
	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$source);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
		
		if($type === "facebook") 
			curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			
		// load xml object from curl execution
		$feedContent = curl_exec($curl);
		curl_close($curl);
		
		// if cache filename provided - save feed to cache.
		if(strlen($cache) > 0){
			$file = fopen($cache,"w");
			fwrite($file,$feedContent);
			fclose($file);
		}
		
	} 
	
	if($feedContent == false || strstr($feedContent,"<title>WordPress &rsaquo; Error</title>")){
		
		return false;
		
	} else {
	
		// load curl content into simplexml
		$feedObj = simplexml_load_string($feedContent);
		return $feedObj;
		
	}	
}