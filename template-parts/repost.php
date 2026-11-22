<?php
/**
 * "Save the article" share block — shared.
 *
 * @package alfa
 */

$icons = get_stylesheet_directory_uri() . '/assets/icons';
$share = array(
	'vk'        => 'VKontakte',
	'facebook'  => 'Facebook',
	'instagram' => 'Instagram',
	'whatsapp'  => 'Whatsapp',
	'viber'     => 'Viber',
	'telegram'  => 'Telegram',
);
?>
<section class="repost">
	<div class="container">
		<div class="repost__head">
			<img class="repost__share" src="<?php echo esc_url( $icons . '/share.svg' ); ?>" alt="" width="36" height="36">
			<h2 class="h2 repost__title"><?php echo esc_html( alfa_field( 'repost_title', 'Сохрани себе статью, чтобы не потерять, в 1 клик', 'option' ) ); ?></h2>
		</div>

		<ul class="repost__list">
			<?php foreach ( $share as $network => $label ) : ?>
				<li class="repost__item">
					<a class="share-link share-link--<?php echo esc_attr( $network ); ?>" href="#" data-share="<?php echo esc_attr( $network ); ?>">
						<?php if ( 'vk' === $network ) : ?>
							<span class="share-link__vk" aria-hidden="true">ᴠκ</span>
						<?php else : ?>
							<img class="share-link__icon" src="<?php echo esc_url( $icons . '/social-' . $network . '.svg' ); ?>" alt="" width="52" height="52" loading="lazy">
						<?php endif; ?>
						<span><?php echo esc_html( $label ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
			<li class="repost__item">
				<button class="share-link share-link--copy" type="button" data-copy-link>
					<span>Скопировать ссылку</span>
					<img class="share-link__copy-icon" src="<?php echo esc_url( $icons . '/copy-link.svg' ); ?>" alt="" width="18" height="8" loading="lazy">
				</button>
			</li>
		</ul>
	</div>
</section>
