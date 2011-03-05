<?php
/*
Plugin Name: Hello World
Plugin URI: http://lonewolf-online.net/
Description: Sample Hello World Plugin
Author: Tim Trott
Version: 1
Author URI: http://lonewolf-online.net/
*/
 
function widget_myHelloWorld($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Venture Details<?php echo $after_title;
  print_r(field_get_meta('offices',false));
  echo $after_widget;
}
 
function myHelloWorld_init()
{
  register_sidebar_widget(__('Hello World'), 'widget_myHelloWorld');
}
add_action("plugins_loaded", "myHelloWorld_init");
?>
