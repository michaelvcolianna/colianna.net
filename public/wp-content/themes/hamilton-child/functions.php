<?php

add_action( 'wp_enqueue_scripts', 'hamilton_child_enqueue_styles' );
function hamilton_child_enqueue_styles()
{
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'render-block', get_stylesheet_directory_uri() . '/render-block.js', ['jquery']  );
}

add_action( 'init', 'remove_hamilton_has_js' );
function remove_hamilton_has_js()
{
    remove_action( 'wp_head', 'hamilton_has_js' );
}
