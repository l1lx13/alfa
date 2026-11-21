<?php
/**
 * Template Name: Кейсы
 * Slug: keysy
 *
 * @package alfa
 */

get_header();

$img = get_stylesheet_directory_uri() . '/assets/images';
?>

<section class="page-hero page-hero--case">
	<div class="container">
		<h1 class="page-hero__display page-hero__display--md"><?php echo esc_html( alfa_field( 'cases_page_title', 'Приведём лояльных клиентов в нишу ремонта и отделки с оплатой от результата' ) ); ?></h1>
		<p class="page-hero__text"><?php echo esc_html( alfa_field( 'cases_page_lead', 'Оставьте заявку и узнайте, как выстроить системный маркетинг, который будет работать на ваш бизнес 24/7 😁' ) ); ?></p>
		<p class="page-hero__subtitle">Консультация с маркетологом</p>
		<p class="page-hero__bonus">Бонусы будут закреплены за вашим номером телефона и сгорят через 7 дней после отправки заявки.</p>

		<div class="page-hero__actions">
			<a class="btn btn--primary" href="#callback">Написать эксперту</a>
			<a class="btn btn--ghost" href="#promo">Подробнее о ролике</a>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/cases-grid', null, array( 'title' => 'Примеры наших работ с подвязкой на результат', 'pagination' => true ) ); ?>

<section class="promo" id="promo">
	<div class="container">
		<h2 class="promo__title">#Промо видео <span>сокращённый вариант до 1 минуты</span></h2>

		<div class="promo__grid">
			<?php
			$promo = array(
				array( 'image' => 'f-2018-8643.png', 'title' => 'Сайт каталог для PL Stroy — с нуля', 'poster_alt' => 'Промо-ролик кейса PL Stroy' ),
				array( 'image' => 'f-2018-8656.png', 'title' => 'Ремонт и отделка — система заявок', 'poster_alt' => 'Промо-ролик кейса по ремонту' ),
			);
			foreach ( $promo as $item ) :
				?>
				<article class="promo-card">
					<button class="promo-card__media" type="button" data-video-open aria-label="Смотреть: <?php echo esc_attr( $item['title'] ); ?>">
						<img src="<?php echo esc_url( alfa_image( $item['image'], 'f-2018-8639.png' ) ); ?>" alt="<?php echo esc_attr( $item['poster_alt'] ); ?>" loading="lazy">
						<span class="review-card__play"><?php echo alfa_icon( 'play' ); ?></span>
					</button>
					<h3 class="promo-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<div class="promo-card__actions">
						<a class="btn btn--primary btn--sm" href="#callback"><?php echo alfa_icon( 'hand' ); ?>Написать эксперту</a>
						<a class="btn btn--ghost btn--sm" href="#promo">Подробнее о ролике</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
