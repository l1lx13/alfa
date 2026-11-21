<?php
/**
 * Single post (article) template.
 *
 * @package alfa
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article class="article">
		<header class="article__head">
			<div class="container">
				<div class="article__meta">
					<span class="chip chip--muted"><?php echo esc_html( get_the_date() ); ?></span>
					<?php
					$cats = get_the_category();
					if ( $cats ) :
						?>
						<span class="chip">#<?php echo esc_html( $cats[0]->name ); ?></span>
					<?php endif; ?>
				</div>
				<h1 class="article__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="article__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="container article__cover">
				<?php the_post_thumbnail( 'full', array( 'loading' => 'eager' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="container article__body">
			<?php the_content(); ?>
		</div>
	</article>

	<?php
endwhile;

get_template_part( 'template-parts/coop' );
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
