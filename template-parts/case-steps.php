<?php
/**
 * Case steps + ad results — shared block for the case template.
 *
 * @package alfa
 *
 * @var array $args { post_id: int }
 */

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();

$steps = get_post_meta( $post_id, 'case_steps', true );
if ( ! is_array( $steps ) || ! $steps ) {
	$steps = array(
		array( 'title' => 'Бриф и аналитика', 'text' => 'Разбираем нишу, конкурентов и текущие заявки. Считаем стоимость лида и точку безубыточности.' ),
		array( 'title' => 'Прототип и структура', 'text' => 'Собираем каркас сайта-воронки под боли клиента и логику продаж в этой нише.' ),
		array( 'title' => 'Дизайн и сборка', 'text' => 'Отрисовываем макет, собираем на WordPress, подключаем формы и аналитику.' ),
		array( 'title' => 'Запуск и оптимизация', 'text' => 'Запускаем трафик, снимаем первые срезы, чистим неэффективные связки.' ),
	);
}

$metrics = get_post_meta( $post_id, 'case_metrics', true );
if ( ! is_array( $metrics ) || ! $metrics ) {
	$metrics = array(
		array( 'value' => '72 млн ₽', 'label' => 'выручка за первые 7 дней рекламы' ),
		array( 'value' => '1000+', 'label' => 'заявок за квартал' ),
		array( 'value' => '−40%', 'label' => 'стоимость заявки' ),
	);
}
?>

<section class="case-steps">
	<div class="container">
		<h2 class="h2 case-steps__title">Этапы работы</h2>
		<ol class="steps">
			<?php foreach ( $steps as $index => $step ) : ?>
				<li class="step">
					<span class="step__num"><?php echo esc_html( str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="step__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="step__text"><?php echo esc_html( $step['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="case-results">
	<div class="container">
		<h2 class="h2 case-results__title">Результат рекламной кампании</h2>
		<div class="metrics">
			<?php foreach ( $metrics as $metric ) : ?>
				<div class="metric">
					<span class="metric__value"><?php echo esc_html( $metric['value'] ); ?></span>
					<span class="metric__label"><?php echo esc_html( $metric['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
