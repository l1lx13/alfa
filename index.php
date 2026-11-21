<?php
/**
 * Fallback template: blog index / archive.
 *
 * @package alfa
 */

get_header();
?>

<div class="page-shell">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<h1 class="page-shell__title"><?php echo esc_html( is_search() ? 'Результаты поиска' : ( is_archive() ? get_the_archive_title() : 'База знаний' ) ); ?></h1>

			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="post-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="post-card__media" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							</a>
						<?php endif; ?>
						<time class="post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="post-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'prev_text' => 'Назад',
					'next_text' => 'Вперёд',
				)
			);
			?>
		<?php else : ?>
			<h1 class="page-shell__title">Пока пусто</h1>
			<p class="page-shell__text">Материалы появятся совсем скоро. А пока — <a href="<?php echo esc_url( home_url( '/' ) ); ?>">на главную</a>.</p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
