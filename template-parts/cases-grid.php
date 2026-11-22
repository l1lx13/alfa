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

$per_page    = 6;
$tag_filter  = isset( $args['tag'] ) && '' !== $args['tag'] ? sanitize_text_field( $args['tag'] ) : ( isset( $_GET['case_tag'] ) ? sanitize_text_field( wp_unslash( $_GET['case_tag'] ) ) : '' );
$current_page = isset( $args['page'] ) && $args['page'] > 1 ? (int) $args['page'] : ( isset( $_GET['case_page'] ) ? max( 1, (int) $_GET['case_page'] ) : 1 );

$query_args = array(
	'post_type'      => 'alfa_case',
	'posts_per_page' => $per_page,
	'paged'          => $current_page,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
);

if ( $tag_filter ) {
	$query_args['meta_query'] = array(
		array(
			'key'     => 'case_tag',
			'value'   => $tag_filter,
			'compare' => 'LIKE',
		),
	);
}

$query = new WP_Query( $query_args );

$base = get_permalink() ? get_permalink() : home_url( '/' );

$case_link = static function ( $page, $tag = '' ) use ( $base ) {
	$args = array();
	if ( $tag ) {
		$args['case_tag'] = $tag;
	}
	if ( $page > 1 ) {
		$args['case_page'] = $page;
	}
	return $args ? add_query_arg( $args, $base ) . '#cases' : $base . '#cases';
};

$tags = array(
	''                => '#Все кейсы',
	'Строительство'   => '#Строительство',
	'Ремонт'          => '#Ремонт',
	'Мебель'          => '#Мебель',
	'Кинологические центры' => '#Кинологические центры',
	'Одежда'          => '#Одежда',
);

$fallback = 'case-cover.png';
?>
<section class="cases" id="cases" data-cases data-tag="<?php echo esc_attr( $tag_filter ); ?>" data-page="<?php echo (int) $current_page; ?>">
	<div class="container">
		<h2 class="h2 cases__title"><?php echo esc_html( $title ); ?></h2>

		<div class="tabs" data-tabs>
			<div class="tabs__list" role="group" aria-label="Фильтр кейсов по отрасли">
				<?php foreach ( $tags as $tag_value => $tag_label ) : ?>
					<a
						class="tabs__item<?php echo $tag_value === $tag_filter ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( $case_link( 1, $tag_value ) ); ?>"
						data-tag="<?php echo esc_attr( $tag_value ); ?>"
						<?php echo $tag_value === $tag_filter ? 'aria-current="true"' : ''; ?>
					><?php echo esc_html( $tag_label ); ?></a>
				<?php endforeach; ?>
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

		<?php
		$total_pages = (int) $query->max_num_pages;

		if ( $pag && $total_pages > 1 ) :
			$pages_to_show = array( 1, 2, 3 );
			if ( $total_pages > 3 ) {
				$pages_to_show[] = $total_pages;
			}
			?>
			<nav class="pagination" aria-label="Страницы кейсов">
				<?php if ( $current_page > 1 ) : ?>
					<a class="pagination__arrow" href="<?php echo esc_url( $case_link( $current_page - 1, $tag_filter ) ); ?>" data-page="<?php echo (int) ( $current_page - 1 ); ?>" aria-label="Назад">&#8249;</a>
				<?php endif; ?>

				<?php
				$prev = 0;
				foreach ( $pages_to_show as $page_num ) :
					if ( $page_num > $total_pages ) {
						continue;
					}
					if ( $page_num - $prev > 1 ) :
						?>
						<span class="pagination__dots">···</span>
						<?php
					endif;
					$prev = $page_num;
					?>
					<a
						class="pagination__item<?php echo $page_num === $current_page ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( $case_link( $page_num, $tag_filter ) ); ?>"
						data-page="<?php echo (int) $page_num; ?>"
						<?php echo $page_num === $current_page ? 'aria-current="page"' : ''; ?>
					><?php echo esc_html( $page_num ); ?></a>
					<?php
				endforeach;
				?>

				<?php if ( $current_page < $total_pages ) : ?>
					<a class="pagination__arrow" href="<?php echo esc_url( $case_link( $current_page + 1, $tag_filter ) ); ?>" data-page="<?php echo (int) ( $current_page + 1 ); ?>" aria-label="Вперёд">&#8250;</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</div>
</section>
