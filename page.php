<?php
/**
 * Static page template.
 *
 * @package alfa
 */

get_header();
?>

<div class="page-shell">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<h1 class="page-shell__title"><?php the_title(); ?></h1>
			<div class="page-shell__content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</div>

<?php
get_footer();
