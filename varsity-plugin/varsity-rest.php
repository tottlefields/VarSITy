<?php

add_action('init', 'add_variant_feed');

function add_variant_feed(){
	add_feed('calendar', 'export_events');
}

?>