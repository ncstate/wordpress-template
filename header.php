<?php
	require 'includes/layout.php';
?>
<!DOCTYPE html>
<html>
	<head>		
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<title><?php wp_title(' :: ', true, 'right'); bloginfo('name'); ?></title>
		<link rel="shortcut icon" href="http://www.ncsu.edu/favicon.ico" />

		<!-- NC State Bootstrap CSS -->
		<link href="https://cdn.ncsu.edu/brand-assets/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen" type="text/css" />
		<!-- Wordpress Theme Style -->
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style.css" />
		<link rel="stylesheet" type="text/css" href="http://cdn.ncsu.edu/brand-assets/wordpress-themes/lite/1.1.0/style.css" />
		
		<!-- picture element polyfill -->
		<script>
			// Picture element HTML5 shiv
			document.createElement( "picture" );
		</script>
		<script src="<?php bloginfo('template_url'); ?>/js/picturefill.min.js" async></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

	    <!-- NC State Utility Bar -->
		<?php if(ot_get_option('cse_id')): ?>
	    	<script src="https://cdn.ncsu.edu/brand-assets/utility-bar/ub.php?googleCustomSearchCode=<?php echo ot_get_option('cse_id'); ?>&placeholder=Search"></script>
		<?php else: ?>
			<script src="https://cdn.ncsu.edu/brand-assets/utility-bar/ub.php"></script>
		<?php endif; ?>
		
		<?php wp_head(); ?> 
	</head>
	
	<body>
		
		<div id="ncstate-utility-bar"></div>
		<header>
			<div class='container<?php echo $fluid; ?>'>
				<div class='site-title'>
					<button type="button">
				       <span class="sr-only">Toggle navigation</span>
				       <span class="glyphicon glyphicon-menu" id="menu-toggle"></span>
				    </button>
					<?php $brick = (ot_get_option('brick') ? ot_get_option('brick') : '2x1'); ?>
				    <a href="<?php echo home_url(); ?>">
						<img src='<?php bloginfo('template_directory'); ?>/img/ncstate-brick-<?php echo $brick; ?>-red.png' alt="NC State"/>
						<?php
						if(is_front_page()) {
							echo "<h1 class='brick-" . $brick . "'>" . get_bloginfo('name') . "</h1>";
						} else {
							echo "<h6 class='brick-" . $brick . "'>" . get_bloginfo('name') . "</h6>";
						}
						?>
					</a>
				</div>
				
				<nav id="global-nav">
					
					<?php 
						$args = array(
							'container' => false,
							'menu_class' => 'nav',
							'title_li' => false,
							'theme_location' => 'primary-menu',
							'depth' => 2
							);
						
						wp_nav_menu($args);
					?>
				</nav> <!--#global-nav-->

			</div>
		</header>
		