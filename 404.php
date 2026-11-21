<?php
/**
 * 404 template.
 *
 * @package alfa
 */

get_header();
?>

<section class="oops">
	<div class="container oops__inner">
		<span class="oops__ghost" aria-hidden="true"><?php echo esc_html( alfa_field( 'e404_ghost', '404', 'option' ) ); ?></span>

		<div class="oops__text">
			<h1 class="oops__title"><?php echo esc_html( alfa_field( 'e404_title', 'Что-то пошло не так…', 'option' ) ); ?></h1>
			<p class="oops__subtitle"><?php echo esc_html( alfa_field( 'e404_subtitle', 'Страница не найдена', 'option' ) ); ?></p>
			<a class="btn btn--primary oops__btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
		</div>

		<figure class="oops__media">
			<img src="<?php echo esc_url( alfa_field( 'e404_image', alfa_image( 'page-404.webp' ), 'option' ) ); ?>" alt="" loading="lazy">
		</figure>
	</div>
</section>

<?php
get_footer();
