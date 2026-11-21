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

$fallback_poster = alfa_image( 'f-2018-9024.png' );
?>
<section class="reviews" id="reviews">
	<div class="container">
		<h2 class="h2 reviews__title"><span class="accent">Видео-отзывы</span> от наших довольных клиентов</h2>
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
						$poster = $fallback_poster;
					} elseif ( 0 !== strpos( $poster, 'http' ) ) {
						$poster = alfa_image( $poster, 'f-2018-9024.png' );
					}
					?>
					<article class="review-card">
						<button class="review-card__media" type="button" data-video-open aria-label="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url( $poster ); ?>" alt="" loading="lazy">
							<span class="review-card__chip"><?php echo esc_html( alfa_field( 'review_title', 'Натяжные потолки', 'post', get_the_ID() ) ); ?></span>
							<span class="review-card__overlay">
								<span class="review-card__big"><?php echo esc_html( alfa_field( 'review_title', 'Натяжные потолки', 'post', get_the_ID() ) ); ?></span>
								<span class="review-card__sub"><?php echo esc_html( alfa_field( 'review_sub', 'Таргетированная реклама', 'post', get_the_ID() ) ); ?></span>
							</span>
							<span class="review-card__play"><?php echo alfa_icon( 'play' ); ?></span>
							<span class="review-card__watermark"><?php echo esc_html( alfa_field( 'review_name', '', 'post', get_the_ID() ) ); ?></span>
						</button>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<button class="reviews__arrow reviews__arrow--prev" type="button" data-slider-prev aria-label="Предыдущий отзыв">&#8249;</button>
		<button class="reviews__arrow reviews__arrow--next" type="button" data-slider-next aria-label="Следующий отзыв">&#8250;</button>
	</div>

	<div class="container">
		<div class="reviews__foot">
			<a class="reviews__more" href="#reviews">Смотреть больше отзывов</a>
		</div>
	</div>
</section>
