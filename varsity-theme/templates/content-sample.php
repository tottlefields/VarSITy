<?php
/**
 * The template part for displaying general content.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	/**
	 * Fires inside the `article` element, before the content.
	 *
	 * @hooked primer_wc_shop_messages - 10
	 *
	 * @since 1.0.0
	 */
	//do_action( 'primer_before_post_content' );

	?>

	<?php

	/**
	 * Fires after templates/parts/loop/post template
	 *
	 * @hooked primer_add_post_meta - 10
	 *
	 * @since 1.0.0
	 */
	//do_action( 'primer_after_post_title_template' );

	?>
	
	<?php get_template_part( 'templates/parts/sample', 'igv' ); ?>
	<?php get_template_part( 'templates/parts/sample', 'analysis' ); ?>

	<?php //get_template_part( 'templates/parts/loop/post', 'content' ); ?>
	
	<a href="javascript:igv.browser.search('3:40808242')">chr3:40808242</a>

</article><!-- #post-## -->
