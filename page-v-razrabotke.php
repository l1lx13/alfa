<?php
/**
 * Template Name: В разработке
 * Slug: v-razrabotke
 *
 * @package alfa
 */

get_header();
?>

<section class="oops oops--dev">
	<div class="container oops__inner">
		<span class="oops__ghost" aria-hidden="true"><?php echo esc_html( alfa_field( 'dev_ghost', 'Упс…', 'option' ) ); ?></span>

		<div class="oops__text">
			<h1 class="oops__title"><?php echo esc_html( alfa_field( 'dev_title', 'Страница в разработке', 'option' ) ); ?></h1>
			<p class="oops__subtitle"><?php echo esc_html( alfa_field( 'dev_subtitle', 'Скоро здесь появится страница. А пока — посмотрите кейсы или оставьте заявку.', 'option' ) ); ?></p>
			<div class="oops__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/keysy/' ) ); ?>">Смотреть кейсы</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
			</div>
		</div>

		<figure class="oops__media">
			<img src="<?php echo esc_url( alfa_field( 'dev_image', alfa_image( 'page-dev.webp' ), 'option' ) ); ?>" alt="" loading="lazy">
		</figure>
	</div>
</section>

<?php
get_footer();
