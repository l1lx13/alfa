<?php
/**
 * Template Name: Спасибо
 * Slug: spasibo
 *
 * @package alfa
 */

get_header();
?>

<section class="thanks">
	<div class="container thanks__inner">
		<span class="thanks__icon"><?php echo alfa_icon( 'check' ); ?></span>
		<h1 class="thanks__title"><?php echo esc_html( alfa_field( 'thanks_title', 'Спасибо! Заявка у нас' ) ); ?></h1>
		<p class="thanks__text"><?php echo esc_html( alfa_field( 'thanks_text', 'Роман свяжется с вами в течение рабочего дня и подготовит разбор под вашу нишу.' ) ); ?></p>
		<div class="thanks__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/keysy/' ) ); ?>">Смотреть кейсы</a>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/reviews' );
get_footer();
