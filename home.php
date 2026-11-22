<?php
/**
 * Blog index (posts page) — «База знаний».
 *
 * @package alfa
 */

get_header();

$img = get_stylesheet_directory_uri() . '/assets/images';
?>

<section class="page-hero page-hero--blog">
	<div class="container">
		<h1 class="page-hero__display page-hero__display--md">База знаний</h1>
		<p class="page-hero__text">Статьи, разборы и инструкции по системному маркетингу для строительного бизнеса, ремонта и мебели.</p>
	</div>
</section>

<section class="blog-list">
	<div class="container">
		<h2 class="h2 blog-list__title">Примеры наших работ с подвязкой на результат</h2>

		<div class="art-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<article class="art-card">
						<a class="art-card__media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( alfa_image( 'f-2018-8658.png' ) ); ?>" alt="" loading="lazy">
							<?php endif; ?>
						</a>
						<div class="art-card__meta">
							<span class="chip chip--muted"><?php echo esc_html( get_the_date() ); ?></span>
						</div>
						<h2 class="art-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="art-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						<a class="art-card__more" href="<?php the_permalink(); ?>">Читать статью <?php echo alfa_icon( 'arrow' ); ?></a>
					</article>
				<?php
				endwhile;
			else :
				?>
				<p class="blog-list__empty">Пока нет статей — но они уже в работе.</p>
			<?php endif; ?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'prev_text' => 'Назад',
				'next_text' => 'Вперёд',
			)
		);
		?>
	</div>
</section>

<?php
get_template_part( 'template-parts/reviews' );
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
