<?php
/**
 * Template Name: Вакансии
 * Slug: vakansii
 *
 * @package alfa
 */

get_header();

$vacancies = array(
	array(
		'title' => 'Маркетолог-стратег',
		'type'  => 'Полная занятость · Минск / удалённо',
		'text'  => 'Ведёте 3–5 проектов: анализ ниши, стратегия, контроль подрядчиков. Нужен опыт в перформансе от 2 лет и умение считать воронку.',
	),
	array(
		'title' => 'Специалист по таргетированной рекламе',
		'type'  => 'Полная занятость · удалённо',
		'text'  => 'Запуск и оптимизация кампаний в Meta и Google. Работа в связке с отделом креатива и аналитиком.',
	),
	array(
		'title' => 'Дизайнер сайтов (UI/UX)',
		'type'  => 'Проектная работа',
		'text'  => 'Дизайн лендингов и сайтов-воронок под строительство, ремонт и мебель. Figma, готовность защищать решения перед клиентом.',
	),
);
?>

<section class="page-hero page-hero--big">
	<div class="container">
		<p class="page-hero__brand">Работа в alfa digital agency</p>
		<h1 class="page-hero__display"><?php echo esc_html( alfa_field( 'vacancies_title', 'Вакансии' ) ); ?></h1>
		<p class="page-hero__text"><?php echo esc_html( alfa_field( 'vacancies_text', 'Мы растём и ищем людей, которым интересно строить системный маркетинг, а не «рисовать баннеры». Ниже — открытые позиции.' ) ); ?></p>
	</div>
</section>

<section class="vacancies">
	<div class="container">
		<?php foreach ( $vacancies as $vacancy ) : ?>
			<details class="vacancy">
				<summary class="vacancy__summary">
					<span class="vacancy__title"><?php echo esc_html( $vacancy['title'] ); ?></span>
					<span class="vacancy__type"><?php echo esc_html( $vacancy['type'] ); ?></span>
					<span class="vacancy__plus" aria-hidden="true"></span>
				</summary>
				<div class="vacancy__body">
					<p><?php echo esc_html( $vacancy['text'] ); ?></p>
					<a class="btn btn--primary btn--sm" href="#callback">Откликнуться</a>
				</div>
			</details>
		<?php endforeach; ?>

		<p class="vacancies__note">Не нашли подходящую позицию? Напишите нам — мы всегда рады сильным людям.</p>
	</div>
</section>

<?php
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
