<?php
/**
 * Top-3 results block — shared.
 *
 * @package alfa
 */
?>
<section class="top3">
	<div class="container">
		<h2 class="top3__title"><?php echo esc_html( alfa_field( 'top3_title', '🤪 #Ниже смотрите ТОП-3 выдающихся результата', 'option' ) ); ?></h2>
		<p class="top3__lead"><?php echo esc_html( alfa_field( 'top3_lead', 'Это лучшие кейсы наших клиентов: что именно сделала команда, чтобы прийти к таким цифрам, и какой результат это принесло в деньгах.', 'option' ) ); ?></p>

		<div class="top3__grid">
			<article class="result result--green">
				<h3 class="result__title"><?php echo esc_html( alfa_field( 'top3_1_title', '72 млн ₽ всего за первые 7 дней рекламы', 'option' ) ); ?></h3>
				<p class="result__text">— Разработали сайт-воронку<br>— Анализ целевой аудитории<br>— Рекламу настраивал бывший в стройбизнесе специалист, за счёт этого смогли достичь выдающихся результатов</p>
				<div class="result__actions">
					<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
					<a class="btn btn--ghost btn--sm" href="#cases">Подробнее о кейсе</a>
				</div>
			</article>

			<article class="result result--cyan">
				<h3 class="result__title"><?php echo esc_html( alfa_field( 'top3_2_title', 'Более 1000 заявок на строительство', 'option' ) ); ?></h3>
				<p class="result__text">— Заполнение тех. задания и сбор данных<br>— Анализ целевой аудитории<br>— Общение с экспертами в вашей нише, чтобы максимально приблизить сайт к вашей ЦА</p>
				<div class="result__actions">
					<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
					<a class="btn btn--ghost btn--sm" href="#reviews">Подробнее о ролике</a>
				</div>
			</article>

			<article class="result result--blue">
				<h3 class="result__title"><?php echo esc_html( alfa_field( 'top3_3_title', 'Более 500 000$ на производство', 'option' ) ); ?></h3>
				<p class="result__text">— Заполнение тех. задания и сбор данных<br>— Анализ целевой аудитории<br>— Общение с экспертами в вашей нише, чтобы максимально приблизить сайт к вашей ЦА</p>
				<div class="result__actions">
					<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
					<a class="btn btn--ghost btn--sm" href="#reviews">Подробнее о ролике</a>
				</div>
			</article>
		</div>
	</div>
</section>
