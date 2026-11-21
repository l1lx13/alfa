<?php
/**
 * Client meetings photo strip — shared block.
 *
 * @package alfa
 */

$img      = get_stylesheet_directory_uri() . '/assets/images';
$meetings = array(
	array( 'image' => 'f-2018-9033.png', 'alt' => 'Выезд маркетолога на объект клиента в Минске' ),
	array( 'image' => 'f-2018-9034.png', 'alt' => 'Встреча с клиентом на строительном объекте' ),
	array( 'image' => 'f-2018-9035.png', 'fallback' => 'f-2018-9023.png', 'alt' => 'Осмотр объекта, пришедшего с рекламы' ),
	array( 'image' => 'f-2018-9036.png', 'fallback' => 'f-2018-9024.png', 'alt' => 'Команда Alfa Digital Agency на выезде' ),
);
?>
<section class="meetings">
	<div class="container">
		<h2 class="h2 meetings__title"><?php echo esc_html( alfa_field( 'meetings_title', 'Встречи с клиентами', 'option' ) ); ?></h2>
		<p class="meetings__lead"><?php echo esc_html( alfa_field( 'meetings_lead', 'Реальный выезд на объект, который пришёл с рекламы, как результат упорного труда команды Alfa Digital Agency', 'option' ) ); ?></p>
	</div>

	<div class="meetings__slider" data-slider>
		<button class="meetings__arrow meetings__arrow--prev" type="button" data-slider-prev aria-label="Назад">&#8249;</button>
		<div class="meetings__strip" data-slider-track>
		<?php
		$meetings = array(
			array( 'image' => 'f-2018-9033.png', 'alt' => 'Выезд маркетолога на объект клиента в Минске' ),
			array( 'image' => 'f-2018-9034.png', 'alt' => 'Встреча с клиентом на строительном объекте' ),
			array( 'image' => 'f-2018-9035.png', 'fallback' => 'f-2018-9023.png', 'alt' => 'Осмотр объекта, пришедшего с рекламы' ),
			array( 'image' => 'f-2018-9036.png', 'fallback' => 'f-2018-9024.png', 'alt' => 'Команда Alfa Digital Agency на выезде' ),
		);
		foreach ( $meetings as $meeting ) :
			?>
			<figure class="meetings__item">
				<img src="<?php echo esc_url( alfa_image( $meeting['image'], isset( $meeting['fallback'] ) ? $meeting['fallback'] : 'f-2018-9033.png' ) ); ?>" alt="<?php echo esc_attr( $meeting['alt'] ); ?>" width="419" height="204" loading="lazy">
			</figure>
		<?php endforeach; ?>
		</div>
		<button class="meetings__arrow meetings__arrow--next" type="button" data-slider-next aria-label="Вперёд">&#8250;</button>
	</div>

	<div class="container meetings__foot">
		<a class="btn btn--primary" href="#gallery"><?php echo esc_html( alfa_field( 'meetings_btn', 'Перейти в фотогалерею', 'option' ) ); ?></a>
	</div>
</section>
