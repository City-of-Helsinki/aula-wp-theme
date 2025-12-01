<?php

/**
 * The main Header template
 *
 * @package Oppijaportaali
 */

?>

<!doctype html>
<html class="no-js" data-user-school-rest="<?php echo esc_attr(Utils()->get_user_data_meta_no_aakkoset()); ?>" data-user-school="<?php echo esc_attr(Utils()->get_user_data_meta()); ?>" data-language-user="<?php echo esc_attr(Utils()->user_lang_data()); ?>" <?php language_attributes(); ?>>
<head>

	<meta charset="<?php echo get_bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<!-- ============================================================ -->
	<?php wp_head(); ?>
	<!-- ============================================================ -->

</head>

<body <?php body_class(); ?>>
<div class="aula-content" style="background-image: url(<?php echo esc_url( Bing_wallpaper::get_bg_url() ); ?>)">
	<a href="#content-start" class="skip-to-content">
		<?php pll_esc_html_e( 'Hyppää sisältöön' ); ?>
	</a>
	<?php do_action( 'oppijaportaali_after_body' ); ?>
	<?php get_template_part( 'partials/components/main-nav' ); ?>
	<main class="center-aligner" id="content-start" role="main">
