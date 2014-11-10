<?php

$theme = get_option('ncstate_theme');

$layout = $theme['opt-layout'];

$fluid="";
if($layout=="left") {
	$fluid = "-fluid";
}

$brick="2x1";
if($theme['opt-brick']=='2x2') {
	$brick="2x2";
}

// Default Bootstrap Breakpoints
// Used for <picture> elements
$lg_breakpoint = "1200px";
$md_breakpoint = "992px";
$sm_breakpoint = "768px";
$xs_breakpoint = "480px";