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
		<?php
		$coop_heading = alfa_field( 'coop_title', 'Сотрудничество с Alfa Digital — это двусторонние отношения', 'option' );
		$coop_parts   = preg_split( '/\s*—\s*/u', $coop_heading, 2 );
		?>
		<h2 class="h2 coop__title">
			<?php echo esc_html( $coop_parts[0] ); ?><?php if ( isset( $coop_parts[1] ) ) : ?> — <span class="coop__title-accent"><?php echo esc_html( $coop_parts[1] ); ?></span><?php endif; ?>
		</h2>

		<div class="coop__grid">
		<div class="coop__content">
			<p class="coop__text"><?php echo esc_html( alfa_field( 'coop_text', '🤪 Мы - инновационное рекламное агентство которое меняем правила игры.                                                        Ещё в далёком 2018 году Пожарицким Романом Николаевичем был придуман и разработал бренд ALFA DIGITAL AGENCY, в то время Роман в основном работал на Россию. Сейчас 
>
> Европа, СНГ. В настоящее время агенством Романа управляет Максим Шупляков - собственник( франчайзи партнёр) и руководитель Беларуского филиала Alfa Digital Agency ', 'option' ) ); ?></p>

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

		</div>

		<figure class="coop__media">
			<img src="<?php echo esc_url( alfa_image( 'coop-portrait.png', 'owner-portrait.png' ) ); ?>" alt="Роман Пожарицкий, основатель Alfa Digital Agency" width="508" height="560" loading="lazy">

			<figcaption class="coop__sign">
				<span class="coop__sign-role"><?php echo esc_html( alfa_field( 'coop_role', '📌 Основатель. Alfa Digital Agency', 'option' ) ); ?></span>
				<span class="coop__sign-line" aria-hidden="true"></span>
				<span class="coop__sign-name"><?php echo esc_html( alfa_field( 'coop_person', '🙍🏻‍♂️ Пожарицкий Роман', 'option' ) ); ?></span>
			</figcaption>

			<a class="btn btn--primary coop__cta" href="#callback"><?php echo esc_html( alfa_field( 'coop_btn', 'О собственнике', 'option' ) ); ?></a>
		</figure>
		</div>
	</div>
</section>
