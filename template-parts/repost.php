<?php
/**
 * "Save the article" share block — shared.
 *
 * @package alfa
 */
?>
<section class="repost">
	<div class="container">
		<div class="repost__bar">
			<h2 class="h2 repost__title"><?php echo esc_html( alfa_field( 'repost_title', 'Сохрани себе статью, чтобы не потерять, в 1 клик', 'option' ) ); ?></h2>
			<ul class="repost__list">
				<?php
				$share = array(
					'facebook'  => 'Facebook',
					'instagram' => 'Instagram',
					'whatsapp'  => 'Whatsapp',
					'viber'     => 'Viber',
					'telegram'  => 'Telegram',
				);
				foreach ( $share as $icon => $label ) :
					?>
					<li>
						<a class="share-link share-link--<?php echo esc_attr( $icon ); ?>" href="#" data-share="<?php echo esc_attr( $icon ); ?>">
							<span class="share-link__icon"><?php echo alfa_icon( $icon ); ?></span>
							<span><?php echo esc_html( $label ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
				<li>
					<button class="share-link share-link--copy btn btn--ghost btn--sm" type="button" data-copy-link>
						<span class="share-link__icon"><?php echo alfa_icon( 'clip' ); ?></span>
						<span>Скопировать ссылку</span>
					</button>
				</li>
			</ul>
		</div>
	</div>
</section>
