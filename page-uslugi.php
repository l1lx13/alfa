<?php
/**
 * Template Name: Услуги
 * Slug: uslugi
 *
 * @package alfa
 */

get_header();

$img = get_stylesheet_directory_uri() . '/assets/images';

$services = array(
	array(
		'image' => 'f-2020-9608.png',
		'cat'   => 'marketing',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9619.png',
		'cat'   => 'prodazhi',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9630.png',
		'cat'   => 'razrabotka',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9608.png',
		'cat'   => 'marketing',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9619.png',
		'cat'   => 'prodazhi',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9630.png',
		'cat'   => 'razrabotka',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
);
?>

<section class="page-hero">
	<div class="container">
		<h1 class="page-hero__title"><?php echo esc_html( alfa_field( 'uslugi_title', 'Услуги, которые мы оказываем начиная с 2018 года' ) ); ?></h1>
		<p class="page-hero__lead"><?php echo esc_html( alfa_field( 'uslugi_lead', 'Оставьте заявку и мы свяжемся с вами в течение рабочего дня' ) ); ?></p>

		<form class="page-hero__form" method="post" data-lead-form>
			<input class="page-hero__input" type="text" name="name" placeholder="Ваше имя" autocomplete="name" required>
			<input class="page-hero__input" type="tel" name="phone" placeholder="Ваш номер телефона" autocomplete="tel" required>
			<button class="btn btn--primary" type="submit">Отправить запрос</button>
			<label class="consent consent--inline">
				<input type="checkbox" name="consent" checked required>
				<span>Я даю согласие на обработку персональных данных</span>
			</label>
			<p class="lead-form__status" data-form-status role="status" aria-live="polite"></p>
		</form>
	</div>
</section>

<section class="services services--page" id="services">
	<div class="container services__head">
		<h2 class="services__subtitle"><?php echo esc_html( alfa_field( 'uslugi_subtitle', 'Список услуг, благодаря которым мы помогли нашим клиентам заработать более 2 млн USD начиная с 2018 года' ) ); ?></h2>

		<div class="tabs tabs--services" data-tabs>
			<div class="tabs__list" role="group" aria-label="Фильтр услуг по направлению">
				<button class="tabs__item is-active" aria-pressed="true" data-filter="all">По отраслям</button>
				<button class="tabs__item" aria-pressed="false" data-filter="marketing">Маркетинг</button>
				<button class="tabs__item" aria-pressed="false" data-filter="prodazhi">Продажи</button>
				<button class="tabs__item" aria-pressed="false" data-filter="razrabotka">Разработка</button>
			</div>
		</div>
	</div>

	<div class="services__rows">
		<?php foreach ( $services as $service ) : ?>
			<article class="service-row" data-cat="<?php echo esc_attr( $service['cat'] ); ?>">
				<div class="container service-row__inner">
					<div class="service-row__content">
						<h3 class="service-row__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="service-row__text"><?php echo esc_html( $service['text'] ); ?></p>
						<div class="service-row__actions">
							<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
							<a class="btn btn--ghost btn--sm" href="<?php echo esc_url( home_url( '/keysy/' ) ); ?>">Подробнее о ролике</a>
						</div>
					</div>
					<div class="service-row__media">
						<img src="<?php echo esc_url( alfa_image( $service['image'] ) ); ?>" alt="" width="443" height="256" loading="lazy">
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<nav class="pagination" aria-label="Страницы услуг">
		<a class="pagination__item is-active" href="#services">1</a>
		<a class="pagination__item" href="#services">2</a>
		<a class="pagination__item" href="#services">3</a>
		<a class="pagination__item" href="#services">15</a>
	</nav>
</section>

<?php
get_template_part( 'template-parts/reviews' );
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
