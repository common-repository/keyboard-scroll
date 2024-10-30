<?php

$pagechange = ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ? '1':'0';


$options = array(
    'animationspeed' => 200,
    'css_class' => 'post',
    'pagechange' => $pagechange
);
update_option('keyboard-scroll', $options);
