<?php
/**
 * Video reviews slider — данные из CPT «Видео-отзывы» (ACF-поля).
 *
 * @package alfa
 */

$query = new WP_Query(
	array(
		'post_type'      => 'alfa_review',
		'posts_per_page' => 8,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);

$fallback_poster = 'review-poster.png';
?>
<section class="reviews" id="reviews">
	<div class="container">
		<h2 class="h2 reviews__title">
			<span class="accent">Видео-отзывы</span> от наших довольных клиентов
		</h2>
	</div>

	<div class="reviews__slider" data-slider>
		<div class="reviews__track" data-slider-track>
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();

					$poster = alfa_field( 'review_poster', '', 'post', get_the_ID() );
					if ( is_array( $poster ) && isset( $poster['url'] ) ) {
						$poster = $poster['url'];
					}
					if ( ! $poster ) {
						$poster = alfa_image( $fallback_poster );
					} elseif ( 0 !== strpos( $poster, 'http' ) ) {
						$poster = alfa_image( $poster, $fallback_poster );
					}

					$title = alfa_field( 'review_title', 'Натяжные потолки', 'post', get_the_ID() );
					$name  = alfa_field( 'review_name', '', 'post', get_the_ID() );

					$label = $title;
					if ( $name ) {
						$label .= ', ' . $name;
					}
					?>
					<article class="review-card">
						<button class="review-card__trigger" type="button" data-video-open aria-label="Смотреть видео-отзыв: <?php echo esc_attr( $label ); ?>">
							<img class="review-card__poster" src="<?php echo esc_url( $poster ); ?>" alt="" width="636" height="398" loading="lazy">

							<?php if ( $title ) : ?>
								<span class="review-card__badge"><?php echo esc_html( $title ); ?></span>
							<?php endif; ?>

							<span class="review-card__play" aria-hidden="true">
								<svg width="52" height="60" viewBox="0 0 52.205 60.28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M52.205 30.14L0 60.28L0 0L52.205 30.14Z" fill="white"/>
								</svg>
							</span>
						</button>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<button class="reviews__arrow reviews__arrow--prev" type="button" data-slider-prev aria-label="Предыдущий отзыв"></button>
		<button class="reviews__arrow reviews__arrow--next" type="button" data-slider-next aria-label="Следующий отзыв"></button>
	</div>

	<div class="container">
		<div class="reviews__foot">
			<a class="reviews__more" href="#reviews">Смотреть больше отзывов</a>
		</div>
	</div>
</section>
