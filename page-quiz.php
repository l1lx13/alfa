<?php
/**
 * Template Name: Квиз
 * Slug: quiz
 *
 * @package alfa
 */

get_header();
?>

<section class="quiz" data-quiz>
	<div class="container quiz__inner">
		<div class="quiz__head">
			<div class="quiz__progress"><span class="quiz__progress-bar" data-quiz-bar style="width:25%"></span></div>
			<p class="quiz__step-label" data-quiz-counter>Шаг 1 из 4</p>
			<h1 class="quiz__title"><?php echo esc_html( alfa_field( 'quiz_title', 'Получите стратегию продвижения в подарок' ) ); ?></h1>
			<p class="quiz__lead"><?php echo esc_html( alfa_field( 'quiz_lead', 'Ответьте на 4 вопроса — Роман подготовит разбор под вашу нишу и пришлёт в течение рабочего дня.' ) ); ?></p>
		</div>

		<form class="quiz__form" method="post" data-quiz-form>
			<div class="quiz__step is-active" data-quiz-step="1">
				<h2 class="quiz__question">Какая у вас ниша?</h2>
				<div class="quiz__options">
					<label class="quiz__option"><input type="radio" name="niche" value="Строительство"><span>Строительство домов</span></label>
					<label class="quiz__option"><input type="radio" name="niche" value="Ремонт"><span>Ремонт и отделка</span></label>
					<label class="quiz__option"><input type="radio" name="niche" value="Мебель"><span>Мебель на заказ</span></label>
					<label class="quiz__option"><input type="radio" name="niche" value="Недвижимость"><span>Недвижимость</span></label>
				</div>
				<button class="btn btn--primary quiz__next" type="button" data-quiz-next>Далее</button>
			</div>

			<div class="quiz__step" data-quiz-step="2">
				<h2 class="quiz__question">Какой бюджет на маркетинг в месяц?</h2>
				<div class="quiz__options">
					<label class="quiz__option"><input type="radio" name="budget" value="до 1000$"><span>До 1 000 $</span></label>
					<label class="quiz__option"><input type="radio" name="budget" value="1000–3000$"><span>1 000 – 3 000 $</span></label>
					<label class="quiz__option"><input type="radio" name="budget" value="3000–7000$"><span>3 000 – 7 000 $</span></label>
					<label class="quiz__option"><input type="radio" name="budget" value="более 7000$"><span>Более 7 000 $</span></label>
				</div>
				<div class="quiz__nav">
					<button class="btn btn--ghost quiz__back" type="button" data-quiz-back>Назад</button>
					<button class="btn btn--primary quiz__next" type="button" data-quiz-next>Далее</button>
				</div>
			</div>

			<div class="quiz__step" data-quiz-step="3">
				<h2 class="quiz__question">Что для вас важнее всего?</h2>
				<div class="quiz__cards">
					<?php
					$cards = array(
						array( 'value' => 'Заявки', 'label' => 'Заявки каждый день', 'image' => 'f-2018-8635.png' ),
						array( 'value' => 'Бренд', 'label' => 'Узнаваемость бренда', 'image' => 'f-2018-8639.png' ),
						array( 'value' => 'Продажи', 'label' => 'Рост продаж', 'image' => 'f-2018-8641.png' ),
					);
					foreach ( $cards as $card ) :
						?>
						<label class="quiz__card">
							<input type="radio" name="goal" value="<?php echo esc_attr( $card['value'] ); ?>">
							<span class="quiz__card-media">
								<img src="<?php echo esc_url( alfa_image( $card['image'] ) ); ?>" alt="" loading="lazy">
							</span>
							<span class="quiz__card-label"><?php echo esc_html( $card['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
				<div class="quiz__nav">
					<button class="btn btn--ghost quiz__back" type="button" data-quiz-back>Назад</button>
					<button class="btn btn--primary quiz__next" type="button" data-quiz-next>Далее</button>
				</div>
			</div>

			<div class="quiz__step" data-quiz-step="4">
				<h2 class="quiz__question">Куда прислать стратегию?</h2>
				<div class="quiz__fields">
					<label class="field">
						<span class="field__label">Имя</span>
						<input class="field__input" type="text" name="name" autocomplete="name" required>
					</label>
					<label class="field">
						<span class="field__label">Телефон</span>
						<input class="field__input" type="tel" name="phone" autocomplete="tel" required>
					</label>
				</div>
				<label class="consent">
					<input type="checkbox" name="consent" checked required>
					<span>Я ознакомлен(-а) с <a href="#">Политикой конфиденциальности</a></span>
				</label>
				<div class="quiz__nav">
					<button class="btn btn--ghost quiz__back" type="button" data-quiz-back>Назад</button>
					<button class="btn btn--primary" type="submit">Получить стратегию</button>
				</div>
				<p class="lead-form__status" data-form-status role="status" aria-live="polite"></p>
			</div>

			<div class="quiz__step quiz__step--done" data-quiz-step="5">
				<span class="thanks__icon"><?php echo alfa_icon( 'check' ); ?></span>
				<h2 class="quiz__question">Готово! Стратегия уже готовится</h2>
				<p class="quiz__lead">Роман свяжется с вами в течение рабочего дня.</p>
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
			</div>
		</form>
	</div>
</section>

<?php
get_footer();
