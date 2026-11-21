<?php
/**
 * Cases grid with category filter — данные из CPT «Кейсы» (ACF-поля).
 *
 * @package alfa
 *
 * @var array $args { title: string, pagination: bool }
 */

$title = isset( $args['title'] ) ? $args['title'] : alfa_field( 'cases_title', 'Примеры наших работ с подвязкой на результат' );
$pag   = ! empty( $args['pagination'] );

$query = new WP_Query(
	array(
		'post_type'      => 'alfa_case',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);

$fallback = 'f-2018-8641.png';
?>
<section class="cases" id="cases">
	<div class="container">
		<h2 class="h2 cases__title"><?php echo esc_html( $title ); ?></h2>

		<div class="tabs" data-tabs>
			<div class="tabs__list" role="group" aria-label="Фильтр кейсов по отрасли">
				<button class="tabs__item is-active" aria-pressed="true" data-filter="all">#Все кейсы</button>
				<button class="tabs__item" aria-pressed="false" data-filter="stroy">#Строительство</button>
				<button class="tabs__item" aria-pressed="false" data-filter="remont">#Ремонт</button>
				<button class="tabs__item" aria-pressed="false" data-filter="mebel">#Мебель</button>
				<button class="tabs__item" aria-pressed="false" data-filter="kino">#Кинологические центры</button>
				<button class="tabs__item" aria-pressed="false" data-filter="odezhda">#Одежда</button>
			</div>
		</div>

		<div class="cases__grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$cover = alfa_field( 'case_cover', '', 'post', get_the_ID() );
					if ( is_array( $cover ) && isset( $cover['url'] ) ) {
						$cover = $cover['url'];
					}
					if ( ! $cover ) {
						$cover = alfa_image( $fallback );
					} elseif ( 0 !== strpos( $cover, 'http' ) ) {
						$cover = alfa_image( $cover, $fallback );
					}
					$tag = alfa_field( 'case_tag', 'Строительство', 'post', get_the_ID() );
					?>
					<article class="case-card" data-tag="<?php echo esc_attr( $tag ); ?>">
						<a class="case-card__media" href="<?php the_permalink(); ?>">
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
						</a>
						<div class="case-card__body">
							<h3 class="case-card__title"><?php the_title(); ?></h3>
							<div class="case-card__actions">
								<a class="btn btn--case case-card__btn-quick" href="<?php the_permalink(); ?>">Быстрый просмотр</a>
								<a class="btn btn--case" href="<?php the_permalink(); ?>">Подробнее о кейсе</a>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="cases__empty">Кейсы скоро появятся.</p>
			<?php endif; ?>
		</div>

		<?php if ( $pag ) : ?>
			<nav class="pagination" aria-label="Страницы кейсов">
				<a class="pagination__arrow" href="#cases" aria-label="Назад">&#8249;</a>
				<a class="pagination__item is-active" href="#cases">1</a>
				<span class="pagination__dots">···</span>
				<a class="pagination__arrow" href="#cases" aria-label="Вперёд">&#8250;</a>
			</nav>
		<?php endif; ?>
	</div>
</section>
