<?php
/**
 * Single case template.
 *
 * @package alfa
 */

get_header();

$img = get_stylesheet_directory_uri() . '/assets/images';

while ( have_posts() ) :
	the_post();
	$tags = get_the_tags();
	?>

	<section class="case-hero">
		<div class="container">
			<div class="case-hero__tags">
				<?php if ( $tags ) : ?>
					<?php foreach ( $tags as $tag ) : ?>
						<span class="chip">#<?php echo esc_html( $tag->name ); ?></span>
					<?php endforeach; ?>
				<?php endif; ?>
				<span class="chip chip--muted"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
			</div>

			<h1 class="case-hero__title"><?php the_title(); ?></h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="case-hero__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<div class="case-hero__actions">
				<a class="btn btn--primary" href="#callback">Написать эксперту</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/keysy/' ) ); ?>">Все кейсы</a>
			</div>
		</div>
	</section>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container case-cover">
			<?php the_post_thumbnail( 'full', array( 'loading' => 'eager' ) ); ?>
		</div>
	<?php endif; ?>

	<section class="case-body">
		<div class="container case-body__inner">
			<div class="case-body__content">
				<?php the_content(); ?>
			</div>

			<aside class="case-body__aside">
				<div class="case-card-panel">
					<h2 class="case-card-panel__title">О клиенте</h2>
					<p class="case-card-panel__text">Ниша, задача и сроки — расскажем на созвоне. Оставьте заявку, и Роман перезвонит в течение рабочего дня.</p>
					<a class="btn btn--primary btn--sm" href="#callback">Записаться на встречу</a>
				</div>
			</aside>
		</div>
	</section>

	<?php
endwhile;
?>

<?php get_template_part( 'template-parts/case-steps', null, array( 'post_id' => get_the_ID() ) ); ?>

<?php get_template_part( 'template-parts/meetings' ); ?>

<section class="promo" id="promo">
	<div class="container">
		<h2 class="promo__title">#Промо видео <span>сокращённый вариант до 1 минуты</span></h2>
		<div class="promo__grid">
			<?php
			$promo_items = array(
				array( 'image' => 'f-2018-8643.png', 'title' => 'Разбор проекта в видео' ),
				array( 'image' => 'f-2018-8656.png', 'title' => 'Результаты в цифрах' ),
			);
			foreach ( $promo_items as $item ) :
				?>
				<article class="promo-card">
					<button class="promo-card__media" type="button" data-video-open aria-label="Смотреть: <?php echo esc_attr( $item['title'] ); ?>">
						<img src="<?php echo esc_url( alfa_image( $item['image'], 'f-2018-8658.png' ) ); ?>" alt="" loading="lazy">
						<span class="review-card__play"><?php echo alfa_icon( 'play' ); ?></span>
					</button>
					<h3 class="promo-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<div class="promo-card__actions">
						<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$related_page = isset( $_GET['related_page'] ) ? max( 1, absint( $_GET['related_page'] ) ) : 1;
$related = new WP_Query(
	array(
		'post_type'      => 'alfa_case',
		'posts_per_page' => 2,
		'paged'          => $related_page,
		'post__not_in'   => array( get_the_ID() ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

if ( $related->have_posts() ) :
	?>
	<section class="related-cases" id="related-cases">
		<div class="container">
			<h2 class="h2 related-cases__title">Другие наши кейсы</h2>
			<div class="cases__grid cases__grid--three">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					?>
					<article class="case-card">
						<a class="case-card__media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( alfa_image( 'f-2018-8635.png' ) ); ?>" alt="" loading="lazy">
							<?php endif; ?>
						</a>
						<div class="case-card__body">
							<h3 class="case-card__title"><?php the_title(); ?></h3>
							<div class="case-card__actions">
								<a class="btn btn--ghost btn--sm" href="<?php the_permalink(); ?>">Подробнее о кейсе</a>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
endif;

get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
