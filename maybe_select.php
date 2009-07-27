<?php
/*
$from => array with data
$fselector => what to select (ie: array('parent','child'))
$to => array you want data in
$tselector => where to put data
*/
function maybe_select($from, $fselector, &$to, $tselector, $append=false) {
	if(!is_array($from)) return NULL;
	$a = $from;
	foreach((array)$fselector as $sel) {
		if(!$a[$sel]) return NULL;
		$a = $a[$sel];
	}
	$b = &$to;
	$tselector = (array)$tselector;
	$lastsel = array_pop($tselector);
	foreach((array)$tselector as $sel) {
		if(!$b[$sel]) $b[$sel] = array();
		$b = &$b[$sel];
	}
	if($append && $b[$lastsel]) {
		$b[$lastsel] = array_merge((array)$a, (array)$b[$lastsel]);
	} else if ($append == 'force') {
		$b[$lastsel] = (array)$a;
	} else {
		$b[$lastsel] = $a;
	}
}

?>
