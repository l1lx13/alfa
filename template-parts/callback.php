<?php
/**
 * Callback form block — shared.
 *
 * @package alfa
 */
?>
<section class="callback" id="callback">
	<div class="container callback__inner">
		<figure class="callback__photo">
			<img src="<?php echo esc_url( alfa_image( 'f-2018-9023.png' ) ); ?>" alt="Роман Пожарицкий, основатель Alfa Digital Agency" loading="lazy">
			<figcaption>
				<span class="callback__photo-name">Пожарицкий Роман</span>
				<span class="callback__photo-role">Владелец Alfa Digital Agency</span>
			</figcaption>
		</figure>

		<div class="callback__content">
			<span class="callback__eyebrow"><?php echo esc_html( alfa_field( 'callback_eyebrow', 'Оставляйте заявку и получите стратегию в ПОДАРОК!', 'option' ) ); ?></span>
			<h2 class="callback__title"><?php echo esc_html( alfa_field( 'callback_title', '🔥 Друг, давай я тебе перезвоню', 'option' ) ); ?></h2>
			<p class="callback__text"><?php echo esc_html( alfa_field( 'callback_text', 'Меня зовут Роман, я СЕО Alfa Digital Agency. В прошлом был опыт своего строительного бизнеса, поэтому очень хорошо понимаю внутреннюю кухню.', 'option' ) ); ?></p>
			<p class="callback__text callback__text--accent"><?php echo esc_html( alfa_field( 'callback_strong', 'РАЗДАЮ ЗАКАЗЫ НА СТРОИТЕЛЬСТВО, РЕМОНТ, МЕБЕЛЬ, НЕДВИЖИМОСТЬ', 'option' ) ); ?></p>
			<ul class="callback__list">
				<li>Есть своя рабочая стратегия под строительный бизнес</li>
				<li>Есть опыт работы на испанском рынке в сфере недвижимости и ремонта</li>
			</ul>

			<div class="callback__person">
				<span class="callback__person-name"><?php echo esc_html( alfa_field( 'callback_person', 'Пожарицкий Роман', 'option' ) ); ?></span>
				<span class="callback__person-role"><?php echo esc_html( alfa_field( 'callback_role', 'Основатель Alfa Digital Agency', 'option' ) ); ?></span>
			</div>
		</div>

		<form class="lead-form" method="post" data-lead-form novalidate>
			<div class="lead-form__row">
				<label class="field">
					<span class="field__label">Имя</span>
					<input class="field__input" type="text" name="name" placeholder="Роман" autocomplete="name" required>
				</label>
				<label class="field">
					<span class="field__label">Телефон</span>
					<input class="field__input" type="tel" name="phone" placeholder="+375 (__) ___ __ __" autocomplete="tel" inputmode="tel" required>
				</label>
			</div>

			<label class="field">
				<span class="field__label">Удобное время звонка</span>
				<input class="field__input" type="text" name="time" placeholder="Например, после 18:00">
			</label>

			<fieldset class="ways">
				<legend class="field__label">Где с Вами удобнее связаться?</legend>
				<div class="ways__list">
					<label class="way">
						<input type="radio" name="way" value="Телефон" checked>
						<span class="way__box"><?php echo alfa_icon( 'phone' ); ?></span>
						<span class="way__label">Телефон</span>
					</label>
					<label class="way">
						<input type="radio" name="way" value="Telegram">
						<span class="way__box"><?php echo alfa_icon( 'telegram' ); ?></span>
						<span class="way__label">Telegram</span>
					</label>
					<label class="way">
						<input type="radio" name="way" value="Viber">
						<span class="way__box"><?php echo alfa_icon( 'viber' ); ?></span>
						<span class="way__label">Viber</span>
					</label>
					<label class="way">
						<input type="radio" name="way" value="WhatsApp">
						<span class="way__box"><?php echo alfa_icon( 'whatsapp' ); ?></span>
						<span class="way__label">WhatsApp</span>
					</label>
				</div>
			</fieldset>

			<button class="btn btn--primary lead-form__submit" type="submit">
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
</section>
