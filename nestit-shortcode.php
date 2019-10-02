<?php

/*
Plugin Name: TinySlider
Plugin URI: https://learnwith.yusuf.com
Description: Nestit shortcode form any wordpress post 
Version: 1.0
Author: yusuf
Author URI: https://www.facebook.com/
License: GPLv2 or later
Text Domain: tinyslider
Domain Path: /languages/
*/
// funtion wordcount_activation_hook(){}
// register_activation_hook(__FILE__,"wordcount_activation_hook");
// funtion wordcount_deactivation_hook(){}
// register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");*/
function tinys_load_textdomain(){
  load_plugin_textdomain('tinyslider',false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","tinys_load_textdomain");

//image sizeing
function tinys_init(){
	add_image_size('tiny-slider',800,600,true);
}
add_action('init','tinys_init');

//assets loaded

function tinys_assets(){
	wp_enqueue_style('tinyslider-css','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css',null,'1.0');
	wp_enqueue_script('tinyslider-js','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js',array('jquery'),'1.0',true);
	wp_enqueue_script('tinyslider-main-js',plugin_dir_url(__FILE__)."/assets/js/main.js",array('jquery'),'1.0',true);

	 
}

add_action('wp_enqueue_scripts','tinys_assets');


function tinys_shordcode_tslider($arguments,$content){
	$defaults = array(
		'width'=>800,
		'height'=>600, 
		'id'=>''

	);

		$attributes = shortcode_atts($defaults,$arguments);
		$content = do_shortcode($content);

		$shortcode_output = <<<EOD
		<div id="{$attributes['id']}" style="width:{$attributes['width']};height:{$attributes['height']}">
						<div class="slider">
							{$content};
						</div>
					</div>
EOD;
		 return $shortcode_output;

} 

add_shortcode('tslider','tinys_shordcode_tslider'); 

function tinys_shordcode_tslide($arguments){
		$defaults = array(
		'caption'=>'', 
		'id'=>'',
		'size'=>'tiny-slider'

		);
		$attributes = shortcode_atts($defaults,$arguments);

		$image_src = wp_get_attachment_image_src($attributes['id'],$attributes['size']);

		 $shortcode_output =<<<EOD
		 <div class='slide'>
			<p><img src="{$image_src[0]}" alt="{$attributes['caption']}"></p>
			<p>{$attributes['caption']}</p>

		 </div>
EOD;
		 return $shortcode_output; 

}

add_shortcode('tslide','tinys_shordcode_tslide');

