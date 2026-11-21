<?php
/**
 * Template Name: Видео-блог
 * Slug: video-blog
 *
 * @package alfa
 */

get_header();

$videos = array(
	array(
		'title' => 'Разбор кейса: 72 млн ₽ за 7 дней рекламы',
		'text'  => 'Как строили воронку для компании по домам из бруса и что дало такой результат.',
		'image' => 'f-2018-8635.png',
	),
	array(
		'title' => 'Почему заявки дорогие: 5 ошибок в таргете',
		'text'  => 'Разбираем кампании подрядчиков по ремонту и показываем, где сгорает бюджет.',
		'image' => 'f-2018-8639.png',
	),
	array(
		'title' => 'Как считать маркетинг в строительстве',
		'text'  => 'Метрики, которые действительно влияют на выручку, а не на отчёт.',
		'image' => 'f-2018-8641.png',
	),
	array(
		'title' => 'Сайт-воронка за 3 недели: процесс',
		'text'  => 'От брифа до запуска трафика — что происходит на каждом этапе.',
		'image' => 'f-2018-8654.png',
	),
	array(
		'title' => 'Отдел продаж и реклама: как связать',
		'text'  => 'Что делать, если заявки есть, а продаж нет.',
		'image' => 'f-2018-8658.png',
	),
	array(
		'title' => 'Мебель на заказ: канал, который работает',
		'text'  => 'Кейс производителя мебели: от 30 заявок в месяц до 200.',
		'image' => 'f-2018-8673.png',
	),
);
?>

<section class="page-hero page-hero--blog">
	<div class="container">
		<h1 class="page-hero__display page-hero__display--md">Видео-блог</h1>
		<p class="page-hero__text">Разборы кейсов, эфиры и короткие видео о том, как мы строим системный маркетинг в строительстве, ремонте и мебели.</p>
	</div>
</section>

<section class="video-blog">
	<div class="container">
		<div class="video-blog__grid">
			<?php foreach ( $videos as $video ) : ?>
				<article class="video-card">
					<button class="video-card__media" type="button" data-video-open aria-label="Смотреть: <?php echo esc_attr( $video['title'] ); ?>">
						<img src="<?php echo esc_url( alfa_image( $video['image'] ) ); ?>" alt="" loading="lazy">
						<span class="review-card__play"><?php echo alfa_icon( 'play' ); ?></span>
					</button>
					<h2 class="video-card__title"><?php echo esc_html( $video['title'] ); ?></h2>
					<p class="video-card__text"><?php echo esc_html( $video['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/reviews' );
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
