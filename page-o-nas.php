<?php
/**
 * Template Name: О нас
 * Slug: o-nas
 *
 * @package alfa
 */

get_header();
?>

<section class="page-hero page-hero--big">
	<div class="container">
		<p class="page-hero__brand"><?php echo esc_html( alfa_field( 'about_brand', 'История alfa digital agency' ) ); ?></p>
		<h1 class="page-hero__display"><?php echo esc_html( alfa_field( 'about_title', 'Как всё начиналось' ) ); ?></h1>
		<p class="page-hero__text">🤪 Мы — инновационное рекламное агентство, которое меняет правила игры. Нестандартный подход к решению бизнес-задач. Ещё в далёком 2018 году Пожарицким Романом Николаевичем был придуман и разработан уникальный подход к маркетингу, который сегодня приносит клиентам миллионы.</p>
	</div>
</section>

<?php get_template_part( 'template-parts/coop' ); ?>

<section class="about-block">
	<div class="container">
		<h2 class="about-block__title">Наш подход к работе</h2>
		<p class="about-block__text">🤪 Мы — инновационное рекламное агентство, которое меняет правила игры. Абсолютно новый подход в работе с американскими и европейскими стандартами маркетинга, адаптированный под СНГ. Мы не просто делаем рекламу — мы выстраиваем систему, которая приносит заявки каждый день.</p>
	</div>
</section>

<section class="about-block">
	<div class="container">
		<h2 class="about-block__title">Цели Агентства Alfa Digital Agency на 2025–2026 г</h2>
		<ul class="checklist">
			<li>Открытие ЦО в Аликанте, Испания</li>
			<li>Запуск платформы для Франчайзи партнёров</li>
		</ul>
	</div>
</section>

<?php
get_template_part( 'template-parts/meetings' );
get_template_part( 'template-parts/top3' );
get_template_part( 'template-parts/reviews' );
get_template_part( 'template-parts/callback' );
get_template_part( 'template-parts/repost' );
get_footer();
