<?php
/**
 * Callback form block — shared.
 *
 * @package alfa
 */

$icons = get_stylesheet_directory_uri() . '/assets/icons';

$eyebrow = alfa_field( 'callback_eyebrow', 'Оставляйте заявку и получите стратегию в ПОДАРОК!', 'option' );
$title   = alfa_field( 'callback_title', '🔥 Друг, давай я тебе перезвоню', 'option' );
$text    = alfa_field( 'callback_text', 'Меня зовут Роман, я СЕО Alfa Digital Agency! В прошлом был опыт своего строительного бизнеса, поэтому очень хорошо понимаю внутреннюю кухню.', 'option' );
$strong  = alfa_field( 'callback_strong', 'РАЗДАЮ ЗАКАЗЫ НА СТРОИТЕЛЬСТВО, РЕМОНТ, МЕБЕЛЬ, НЕДВИЖИМОСТЬ', 'option' );
$person  = alfa_field( 'callback_person', 'Пожарицкий Роман', 'option' );
$role    = alfa_field( 'callback_role', 'Основатель Alfa Digital Agency', 'option' );

/* Первая фраза идёт отдельной строкой — как в макете */
$parts = preg_split( '/!\s*/u', $text, 2 );
$lead  = isset( $parts[0] ) ? $parts[0] . '!' : $text;
$after = isset( $parts[1] ) ? trim( $parts[1] ) : '';
?>
<section class="callback" id="callback">
	<div class="callback__bg" aria-hidden="true">
		<img src="<?php echo esc_url( alfa_image( 'callback-bg.png' ) ); ?>" alt="" width="1920" height="596">
	</div>

	<div class="container">
		<div class="callback__grid">
			<div class="callback__left">
				<span class="callback__name"><?php echo esc_html( $person ); ?></span>
				<span class="callback__divider" aria-hidden="true"></span>
				<span class="callback__role"><?php echo esc_html( $role ); ?></span>
				<img class="callback__face" src="<?php echo esc_url( alfa_image( 'callback-face.png' ) ); ?>" alt="" width="44" height="44" aria-hidden="true">
				<img class="callback__pin" src="<?php echo esc_url( alfa_image( 'callback-pin.png' ) ); ?>" alt="" width="20" height="20" aria-hidden="true">
				<span class="callback__portrait-wrap">
					<img class="callback__portrait" src="<?php echo esc_url( alfa_image( 'callback-portrait.png' ) ); ?>" alt="Роман Пожарицкий — основатель Alfa Digital Agency" width="960" height="720">
				</span>
			</div>

			<div class="callback__content">
				<h2 class="callback__title"><?php echo esc_html( $title ); ?></h2>
				<p class="callback__lead"><?php echo esc_html( $lead ); ?></p>
				<?php if ( $after ) : ?>
					<p class="callback__text"><?php echo esc_html( $after ); ?></p>
				<?php endif; ?>
				<p class="callback__strong"><?php echo esc_html( $strong ); ?></p>
				<ul class="callback__list">
					<li>Есть своя рабочая стратегия под строительный бизнес</li>
					<li>Есть опыт работы на Испанском рынке в сфере недвижимости и ремонта</li>
				</ul>
			</div>

			<form class="lead-form callback__form" method="post" data-lead-form novalidate>
				<p class="callback__form-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>

				<input class="callback__input" type="text" name="name" placeholder="Имя" autocomplete="name" required>
				<input class="callback__input" type="tel" name="phone" placeholder="+375 (__) ___ __ __" autocomplete="tel" inputmode="tel" required>
				<input class="callback__input" type="text" name="time" placeholder="Удобное время звонка">

				<fieldset class="ways">
					<legend class="ways__legend">Где с Вами удобнее связаться?</legend>
					<div class="ways__list">
						<label class="way way--phone">
							<input type="radio" name="way" value="Телефон" checked>
							<span class="way__box" aria-hidden="true"></span>
							<span class="way__label">Телефон</span>
						</label>
						<label class="way way--telegram">
							<input type="radio" name="way" value="Telegram">
							<span class="way__box" aria-hidden="true"></span>
							<span class="way__label">Telegram</span>
						</label>
						<label class="way way--viber">
							<input type="radio" name="way" value="Viber">
							<span class="way__box" aria-hidden="true"></span>
							<span class="way__label">Viber</span>
						</label>
						<label class="way way--whatsapp">
							<input type="radio" name="way" value="WhatsApp">
							<span class="way__box" aria-hidden="true"></span>
							<span class="way__label">WhatsApp</span>
						</label>
					</div>
				</fieldset>

				<button class="callback__submit" type="submit">
					<?php echo alfa_icon( 'hand' ); ?>
					<span><?php echo esc_html( alfa_field( 'callback_submit', 'Перезвонить мне', 'option' ) ); ?></span>
				</button>

				<label class="consent">
					<input type="checkbox" name="consent" checked required>
					<span><?php echo esc_html( alfa_field( 'callback_consent', 'Я ознакомлен(-а) с Политикой конфиденциальности', 'option' ) ); ?></span>
				</label>

				<p class="consent__note">Ваши данные не будут переданы третьим лицам</p>

				<p class="lead-form__status" data-form-status role="status" aria-live="polite"></p>
			</form>
		</div>
	</div>
</section>
