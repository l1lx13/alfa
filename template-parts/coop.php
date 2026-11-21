<?php
/**
 * Cooperation / owner block — shared.
 *
 * @package alfa
 */

$img = get_stylesheet_directory_uri() . '/assets/images';
?>
<section class="coop" id="cooperation">
	<div class="container">
		<h2 class="h2 coop__title"><?php echo esc_html( alfa_field( 'coop_title', 'Сотрудничество с Alfa Digital — это двусторонние отношения', 'option' ) ); ?></h2>

		<div class="coop__grid">
		<div class="coop__content">
			<p class="coop__text"><?php echo esc_html( alfa_field( 'coop_text', '🤪 Мы — инновационное рекламное агентство, которое меняет правила игры. Ещё в далёком 2018 году Пожарицким Романом Николаевичем был придуман и разработан уникальный подход к маркетингу, который сегодня приносит клиентам миллионы.', 'option' ) ); ?></p>

			<div class="coop__person">
				<span class="coop__person-name"><?php echo esc_html( alfa_field( 'coop_person', 'Пожарицкий Роман', 'option' ) ); ?></span>
				<span class="coop__person-role"><?php echo esc_html( alfa_field( 'coop_role', 'Основатель. Alfa Digital Agency', 'option' ) ); ?></span>
			</div>

			<h3 class="coop__subtitle">Цели Агентства Alfa Digital Agency на 2025–2026 г</h3>
			<ul class="checklist">
				<?php foreach ( array_filter( array_map( 'trim', explode( "\n", alfa_field( 'coop_goals', "Открытие ЦО в Аликанте, Испания\nЗапуск платформы для Франчайзи партнёров", 'option' ) ) ) ) as $goal ) : ?>
					<li><?php echo esc_html( $goal ); ?></li>
				<?php endforeach; ?>
			</ul>

			<a class="btn btn--primary" href="#callback"><?php echo esc_html( alfa_field( 'coop_btn', 'О собственнике', 'option' ) ); ?></a>
		</div>

		<figure class="coop__media">
			<img src="<?php echo esc_url( alfa_image( 'f-2020-9460.png', 'f-2018-9024.png' ) ); ?>" alt="Роман Пожарицкий, основатель Alfa Digital Agency" width="508" height="560" loading="lazy">
		</figure>
		</div>
	</div>
</section>
