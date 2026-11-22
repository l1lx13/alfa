<?php
/**
 * Front page — landing assembled from the Figma "главная" frame.
 *
 * @package alfa
 */

get_header();

$img = get_stylesheet_directory_uri() . '/assets/images';

$cases = array(
	array(
		'image' => 'f-2018-8635.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Строительство',
	),
	array(
		'image' => 'f-2018-8639.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Ремонт',
	),
	array(
		'image' => 'f-2018-8641.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Мебель',
	),
	array(
		'image' => 'f-2018-8654.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Кинологические центры',
	),
	array(
		'image' => 'f-2018-8658.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Одежда',
	),
	array(
		'image' => 'f-2018-8673.png',
		'title' => 'Сайт каталог для PL Stroy',
		'tag'   => 'Строительство',
	),
);

$reviews = array(
	array( 'image' => 'f-2020-9398.png', 'fallback' => 'f-2018-9024.png', 'title' => 'Натяжные потолки', 'name' => 'Сергей, Минск' ),
	array( 'image' => 'f-2020-9407.png', 'fallback' => 'f-2018-9023.png', 'title' => 'Натяжные потолки', 'name' => 'Дмитрий, Гомель' ),
	array( 'image' => 'f-2020-9416.png', 'fallback' => 'f-2018-9033.png', 'title' => 'Натяжные потолки', 'name' => 'Андрей, Брест' ),
	array( 'image' => 'f-2020-9425.png', 'fallback' => 'f-2018-9034.png', 'title' => 'Натяжные потолки', 'name' => 'Игорь, Витебск' ),
);

$services = array(
	array(
		'image' => 'f-2020-9608.png',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9619.png',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
	array(
		'image' => 'f-2020-9630.png',
		'title' => '10 лучших программ и инструментов для совместной работы',
		'text'  => 'это лучших программ и инструментов для совместной работы над дизайном. Эта статья — путеводитель по самым удобным платформам для совместной работы над дизайном.',
	),
);
?>

<section class="hero">
	<div class="hero__bg" aria-hidden="true">
		<img src="<?php echo esc_url( alfa_image( 'f-2018-8598.png' ) ); ?>" alt="" width="2010" height="624">
	</div>

	<div class="container hero__inner">
		<div class="hero__content">
			<h1 class="hero__title"><?php echo esc_html( alfa_field( 'hero_title', 'alfa digital agency' ) ); ?></h1>
			<p class="hero__lead"><?php
				echo wp_kses(
					alfa_field( 'hero_lead', '<span class="accent">Оставьте заявку</span> на разбор и узнайте как выстроить системный маркетинг, который будет работать <span class="accent">на ваш бизнес 24\7</span>' ),
					array( 'span' => array( 'class' => array() ), 'br' => array(), 'b' => array(), 'strong' => array() )
				);
			?></p>
			<div class="hero__actions">
				<a class="btn btn--primary" href="#callback"><?php echo esc_html( alfa_field( 'hero_btn_primary', 'Оставить заявку на разбор' ) ); ?></a>
				<a class="btn btn--ghost" href="#callback"><?php echo esc_html( alfa_field( 'hero_btn_secondary', 'Записаться на встречу' ) ); ?></a>
			</div>
		</div>

		<button class="hero__play" type="button" data-video-open aria-label="Смотреть видео о нас">
<svg class="hero__play-icon" viewBox="0 0 380 380" aria-hidden="true" focusable="false">
    <circle cx="190" cy="190" r="190" fill="none" stroke="#26CBFF1A" stroke-width="1"/>
    <circle cx="190" cy="190" r="145" fill="none" stroke="#26CBFF4D" stroke-width="1"/>
    <circle cx="190" cy="190" r="105" fill="none" stroke="#26CBFF" stroke-width="1.2" opacity="0.9"/>
    <circle cx="190" cy="190" r="72" fill="#4F7A88"/>
    <path d="M 175 175 L 205 190 L 175 205 Z" fill="white"/>
</svg>
		</button>
	</div>
</section>

<section class="stats">
	<div class="container stats__grid">
		<div class="stats__left">
			<div class="stats__amount">
				<span class="stats__amount-value"><?php echo esc_html( alfa_field( 'stats_amount', '2 000 000 €' ) ); ?></span>
				<span class="stats__amount-caption"><?php echo esc_html( alfa_field( 'stats_caption', 'Получили наши клиенты' ) ); ?></span>
			</div>

			<div class="stats__since">
				<span class="stats__since-value"><?php echo wp_kses( alfa_field( 'stats_since', 'Начиная с 2018 г' ), array() ); ?></span>
				<span class="stats__since-note"><?php echo wp_kses( alfa_field( 'stats_note', 'Команда Alfa Digital Agency поработала >> с 30+ ниш' ), array( 'b' => array() ) ); ?></span>
			</div>

			<blockquote class="stats__quote">
				<?php
				echo wp_kses(
					alfa_field( 'stats_quote', '💼 «Директор <b>несёт ответственность за результат</b> каждого проекта. Руководил отделами продаж, с которых SALES более > 2 🍋 USD»' ),
					array( 'b' => array(), 'strong' => array(), 'br' => array(), 'span' => array( 'class' => array() ) )
				);
				?>
			</blockquote>

			<div class="stats__actions">
				<a class="btn btn--primary" href="#callback">Записаться на встречу</a>
				<a class="btn btn--ghost" href="#cooperation">Подробнее о собственнике</a>
			</div>
		</div>

		<div class="stats__photos">
			<figure class="stats__photo stats__photo--2">
				<img src="<?php echo esc_url( alfa_image( 'f-2018-9024.png' ) ); ?>" alt="Команда Alfa Digital Agency" width="433" height="354" loading="lazy">
			</figure>
			<figure class="stats__photo stats__photo--1">
				<img src="<?php echo esc_url( alfa_image( 'f-2018-9023.png' ) ); ?>" alt="Роман Пожарицкий на встрече" width="376" height="354" loading="lazy">
			</figure>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/cases-grid', null, array( 'title' => 'Примеры наших работ с подвязкой на результат', 'pagination' => true ) ); ?>

<?php get_template_part( 'template-parts/meetings' ); ?>

<?php get_template_part( 'template-parts/coop' ); ?>

<?php get_template_part( 'template-parts/reviews' ); ?>

<section class="mobile-related" aria-label="Другие наши кейсы">
	<div class="container">
		<h2 class="h2 mobile-related__title">#Другие наши кейсы, которые могут вас заинтересовать</h2>
		<div class="mobile-related__grid">
			<?php
			$mobile_cases = new WP_Query( array( 'post_type' => 'alfa_case', 'posts_per_page' => 2, 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
			if ( $mobile_cases->have_posts() ) :
				while ( $mobile_cases->have_posts() ) :
					$mobile_cases->the_post();
					$mobile_cover = get_the_post_thumbnail_url( get_the_ID(), 'large' );
					?>
					<article class="mobile-related__card">
						<a class="mobile-related__media" href="<?php the_permalink(); ?>">
							<?php if ( $mobile_cover ) : ?><img src="<?php echo esc_url( $mobile_cover ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"><?php endif; ?>
						</a>
						<h3><?php the_title(); ?></h3>
						<a class="mobile-related__link" href="<?php the_permalink(); ?>">Подробнее о кейсе</a>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
		<a class="btn btn--primary mobile-related__all" href="<?php echo esc_url( home_url( '/keysy/' ) ); ?>">Все кейсы</a>
	</div>
</section>

<?php get_template_part( 'template-parts/top3' ); ?>

<section class="services" id="services">
	<div class="container services__head">
		<h2 class="h2 services__title"><span class="accent">Услуги</span> которые мы оказываем начиная с <span class="accent">2018 года</span></h2>
		<p class="services__lead"><?php echo esc_html( alfa_field( 'services_lead', 'Список услуг, которые помогли нашим клиентам заработать более 2 млн USD начиная с 2016 года' ) ); ?></p>

		<div class="tabs tabs--services" data-tabs>
			<div class="tabs__list" role="tablist" aria-label="Категории услуг">
				<button class="tabs__item is-active" role="tab" aria-selected="true">По отраслям</button>
				<button class="tabs__item" role="tab" aria-selected="false">Маркетинг</button>
				<button class="tabs__item" role="tab" aria-selected="false">Продажи</button>
				<button class="tabs__item" role="tab" aria-selected="false">Разработка</button>
			</div>
		</div>
	</div>

	<div class="services__rows">
		<?php foreach ( $services as $service ) : ?>
			<article class="service-row">
				<div class="container service-row__inner">
					<div class="service-row__content">
						<h3 class="service-row__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="service-row__text"><?php echo esc_html( $service['text'] ); ?></p>
						<div class="service-row__actions">
							<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
							<a class="btn btn--ghost btn--sm" href="#reviews">Подробнее о ролике</a>
						</div>
					</div>
					<div class="service-row__media">
						<img src="<?php echo esc_url( alfa_image( $service['image'] ) ); ?>" alt="" width="443" height="256" loading="lazy">
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<div class="container services__foot">
		<a class="btn btn--primary btn--sm" href="#services">Смотреть полный список услуг</a>
	</div>
</section>

<?php get_template_part( 'template-parts/repost' ); ?>

<?php get_template_part( 'template-parts/callback' ); ?>

<?php
get_footer();
