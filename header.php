<?php ?>
<!doctype html>
<html <?php language_attributes() ?>>
<head>
    <title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link rel="icon" type="image/png" href="--><?php //echo ARK_THEME_URL . 'inc/img/Logo.svg' ?><!--">-->
    <meta name="theme-color" content="#25bdad">
    <?php wp_head() ?>

</head>
<body <?php body_class(); ?>>