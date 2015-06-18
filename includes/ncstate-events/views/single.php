<?php get_header(); ?>

<body>
	
<?php include get_template_directory() . '/masthead.php'; ?>


<div id="main-content">
	<div id="event" class="container" role="main">
	<section class="text-mod no-components">
		
		<div class="section-txt">

		<?php
			$event = get_post_custom();
		?>

		<div class="row">
			<div class="col-md-12">
				<h1 class="section-head"><?php echo get_the_title(); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<?php $date = $event['start_time'][0]; ?>
				<?php if(date('g:i a', $date)=="12:00 am"): ?>
					<p class="date"><?php echo date("M j, Y",$date); ?></p>
				<?php else: ?>
					<p class="date"><?php echo date("M j, Y | g:i A",$date); ?></p>
				<?php endif; ?>
				<p class="location"><?php echo $event['location'][0]; ?></p>
				<p class="description"><?php echo $event['description'][0]; ?></p>
	
				<?php if($event['external_urls'][0]>0): ?>
					<h3>More Information</h3>
					<ul class="additional_links">
						<?php for($i=0; $i<$event['external_urls'][0]; $i++): ?>
							<li><a href="<?php echo $event['external_urls_' . $i . '_url'][0] ?>"><?php echo $event['external_urls_' . $i . '_url_text'][0] ?></a></li>
						<?php endfor; ?>
					</ul>
				<?php endif; ?>
			</div>
	
		<?php if($event['image'][0]!=null): ?>
			<aside class="col-md-4">
				<?php $img_url = wp_get_attachment_image_src($event['image'][0], array(300,300)); ?>
				<?php $img_alt = get_post_meta($event['image'][0], '_wp_attachment_image_alt', true); ?>
				<img src="<?php echo $img_url[0]; ?>" alt="<?php echo $img_alt; ?>" class="img-responsive" />
			</aside>
		<?php endif; ?>
		<?php if($event['location_map'][0]!=null): ?>
			<div class="col-md-12">
				<p class="map-title">Event Map</p>
				<div id="map-canvas">
		
				</div>
			</div>
		<?php endif; ?>
	</div>	
	</section>
</div>
	
</div>

	<?php $map = get_post_meta(get_the_ID(), 'location_map', true); ?>
	
	<script>
	  function initialize() {
		  var myLatlng = new google.maps.LatLng(<?php  echo $map['lat']; ?>, <?php echo $map['lng']; ?>);
	      var mapCanvas = document.getElementById('map-canvas');
	      var mapOptions = {
	        center: myLatlng,
	        zoom: 17,
	        mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
		  }
		  var map = new google.maps.Map(mapCanvas, mapOptions);
		  
		  var marker = new google.maps.Marker({
		      position: myLatlng,
		      map: map,
		      title:"<?php echo $event['title'][0]; ?>"
		  });
		
		  var infowindow = new google.maps.InfoWindow({
			content: "<?php echo $map['address']; ?>"
		  });

	  google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
          });
	  }
	  
	  google.maps.event.addDomListener(window, 'load', initialize);
	</script>
 
<?php get_footer(); ?>
