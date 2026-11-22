<?php
/**
 * Alfa Digital Agency — theme bootstrap.
 *
 * @package alfa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ALFA_VERSION', '1.0.0' );

require_once get_stylesheet_directory() . '/inc/acf-fields.php';

/**
 * Theme setup.
 */
function alfa_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => 'Главное меню',
			'footer'  => 'Меню в подвале',
		)
	);
}
add_action( 'after_setup_theme', 'alfa_theme_setup' );

/**
 * Assets.
 */
function alfa_theme_assets() {
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'alfa-main',
		$uri . '/assets/css/style.css',
		array(),
		filemtime( $dir . '/assets/css/style.css' )
	);

	wp_enqueue_script(
		'alfa-main',
		$uri . '/assets/js/main.js',
		array(),
		filemtime( $dir . '/assets/js/main.js' ),
		true
	);

	wp_localize_script(
		'alfa-main',
		'alfaData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'alfa_lead' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'alfa_theme_assets' );

/**
 * Basic SEO / Open Graph meta.
 */
function alfa_seo_meta() {
	$title = wp_get_document_title();
	$desc  = get_bloginfo( 'description' );
	$url   = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$image = get_stylesheet_directory_uri() . '/screenshot.png';

	if ( is_front_page() ) {
		$url  = home_url( '/' );
		$desc = 'Digital-агентство полного цикла: системный маркетинг для строительства, ремонта, мебели и недвижимости. Более 2 000 000 € заработали наши клиенты с 2018 года.';
	} elseif ( is_singular() ) {
		global $post;
		$url     = get_permalink( $post );
		$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( $post->post_content );
		$desc    = wp_trim_words( $excerpt, 30, '…' );
		if ( has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post, 'large' );
		}
	}

	$desc = $desc ? $desc : get_bloginfo( 'name' );

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="%s">' . "\n", ( is_singular() && ! is_front_page() ) ? 'article' : 'website' );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
}
add_action( 'wp_head', 'alfa_seo_meta', 5 );

/**
 * Body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function alfa_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	return $classes;
}
add_filter( 'body_class', 'alfa_body_classes' );

/**
 * Reviews post type (видео-отзывы).
 */
function alfa_register_reviews() {
	register_post_type(
		'alfa_review',
		array(
			'labels'       => array(
				'name'          => 'Видео-отзывы',
				'singular_name' => 'Видео-отзыв',
				'add_new_item'  => 'Добавить отзыв',
				'edit_item'     => 'Редактировать отзыв',
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-format-video',
			'supports'     => array( 'title', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'alfa_register_reviews' );

/**
 * Cases post type.
 */
function alfa_register_cases() {
	register_post_type(
		'alfa_case',
		array(
			'labels'       => array(
				'name'          => 'Кейсы',
				'singular_name' => 'Кейс',
				'add_new_item'  => 'Добавить кейс',
				'edit_item'     => 'Редактировать кейс',
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-portfolio',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'      => array( 'slug' => 'keysy', 'with_front' => false ),
			'taxonomies'   => array( 'post_tag' ),
		)
	);

	register_taxonomy_for_object_type( 'post_tag', 'alfa_case' );
}
add_action( 'init', 'alfa_register_cases' );

/**
 * Lead form: store submissions as a private post type.
 */
function alfa_register_leads() {
	register_post_type(
		'alfa_lead',
		array(
			'labels'       => array(
				'name'          => 'Заявки',
				'singular_name' => 'Заявка',
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-email-alt',
			'supports'     => array( 'title', 'editor' ),
			'capability_type' => 'post',
		)
	);
}
add_action( 'init', 'alfa_register_leads' );

/**
 * Handle the callback form.
 */
function alfa_handle_lead() {
	check_ajax_referer( 'alfa_lead', 'nonce' );

	$name  = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$time  = isset( $_POST['time'] ) ? sanitize_text_field( wp_unslash( $_POST['time'] ) ) : '';
	$way   = isset( $_POST['way'] ) ? sanitize_text_field( wp_unslash( $_POST['way'] ) ) : '';
	$page  = isset( $_POST['page'] ) ? esc_url_raw( wp_unslash( $_POST['page'] ) ) : '';
	$note  = isset( $_POST['note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['note'] ) ) : '';

	if ( '' === $name || '' === $phone ) {
		wp_send_json_error( array( 'message' => 'Укажите имя и телефон.' ), 422 );
	}

	$digits = preg_replace( '/\D+/', '', $phone );
	if ( strlen( $digits ) < 9 ) {
		wp_send_json_error( array( 'message' => 'Проверьте номер телефона.' ), 422 );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'alfa_lead',
			'post_status' => 'private',
			'post_title'  => sprintf( '%s — %s', $name, $phone ),
			'post_content' => sprintf(
				"Имя: %s\nТелефон: %s\nУдобное время: %s\nСпособ связи: %s\nСтраница: %s\nКомментарий: %s",
				$name,
				$phone,
				$time,
				$way,
				$page,
				$note
			),
		)
	);

	if ( ! $id || is_wp_error( $id ) ) {
		wp_send_json_error( array( 'message' => 'Не удалось сохранить заявку.' ), 500 );
	}

	wp_send_json_success( array( 'message' => 'Спасибо! Роман свяжется с вами в ближайшее время.' ) );
}

/**
 * AJAX: подгрузка сетки кейсов (фильтр по отрасли + пагинация) без перезагрузки.
 */
function alfa_ajax_cases() {
	$tag  = isset( $_GET['tag'] ) ? sanitize_text_field( wp_unslash( $_GET['tag'] ) ) : '';
	$page = isset( $_GET['page'] ) ? max( 1, (int) $_GET['page'] ) : 1;

	ob_start();
	get_template_part(
		'template-parts/cases-grid',
		null,
		array(
			'tag'        => $tag,
			'page'       => $page,
			'pagination' => true,
		)
	);
	$html = ob_get_clean();

	wp_send_json_success(
		array(
			'html' => $html,
			'tag'  => $tag,
			'page' => $page,
		)
	);
}
add_action( 'wp_ajax_alfa_cases', 'alfa_ajax_cases' );
add_action( 'wp_ajax_nopriv_alfa_cases', 'alfa_ajax_cases' );

add_action( 'wp_ajax_alfa_lead', 'alfa_handle_lead' );
add_action( 'wp_ajax_nopriv_alfa_lead', 'alfa_handle_lead' );

/**
 * Meta box: case steps and ad results.
 */
function alfa_case_meta_box() {
	add_meta_box(
		'alfa_case_extra',
		'Этапы и результаты кейса',
		'alfa_case_meta_box_render',
		'alfa_case',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'alfa_case_meta_box' );

/**
 * Render the meta box.
 *
 * @param WP_Post $post Current post.
 */
function alfa_case_meta_box_render( $post ) {
	wp_nonce_field( 'alfa_case_extra', 'alfa_case_extra_nonce' );

	$steps = get_post_meta( $post->ID, 'case_steps', true );
	$metrics = get_post_meta( $post->ID, 'case_metrics', true );

	if ( ! is_array( $steps ) ) {
		$steps = array();
	}
	if ( ! is_array( $metrics ) ) {
		$metrics = array();
	}

	$steps   = array_pad( $steps, 4, array( 'title' => '', 'text' => '' ) );
	$metrics = array_pad( $metrics, 3, array( 'value' => '', 'label' => '' ) );

	echo '<h3 style="margin:16px 0 8px">Этапы работы</h3>';
	foreach ( $steps as $i => $step ) {
		printf(
			'<p><input type="text" name="alfa_steps[%1$d][title]" value="%2$s" placeholder="Название шага %1$d" style="width:32%%;margin-right:8px">'
			. '<textarea name="alfa_steps[%1$d][text]" rows="2" placeholder="Описание шага %1$d" style="width:60%%;vertical-align:top">%3$s</textarea></p>',
			(int) $i,
			esc_attr( $step['title'] ),
			esc_textarea( $step['text'] )
		);
	}

	echo '<h3 style="margin:20px 0 8px">Результат рекламной кампании</h3>';
	foreach ( $metrics as $i => $metric ) {
		printf(
			'<p><input type="text" name="alfa_metrics[%1$d][value]" value="%2$s" placeholder="Цифра" style="width:22%%;margin-right:8px">'
			. '<input type="text" name="alfa_metrics[%1$d][label]" value="%3$s" placeholder="Подпись" style="width:60%%"></p>',
			(int) $i,
			esc_attr( $metric['value'] ),
			esc_attr( $metric['label'] )
		);
	}
}

/**
 * Save the meta box.
 *
 * @param int $post_id Post ID.
 */
function alfa_case_meta_box_save( $post_id ) {
	if ( ! isset( $_POST['alfa_case_extra_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['alfa_case_extra_nonce'] ), 'alfa_case_extra' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$steps = array();
	if ( isset( $_POST['alfa_steps'] ) && is_array( $_POST['alfa_steps'] ) ) {
		foreach ( wp_unslash( $_POST['alfa_steps'] ) as $row ) {
			$title = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
			$text  = isset( $row['text'] ) ? sanitize_textarea_field( $row['text'] ) : '';
			if ( '' !== $title || '' !== $text ) {
				$steps[] = array( 'title' => $title, 'text' => $text );
			}
		}
	}

	$metrics = array();
	if ( isset( $_POST['alfa_metrics'] ) && is_array( $_POST['alfa_metrics'] ) ) {
		foreach ( wp_unslash( $_POST['alfa_metrics'] ) as $row ) {
			$value = isset( $row['value'] ) ? sanitize_text_field( $row['value'] ) : '';
			$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
			if ( '' !== $value || '' !== $label ) {
				$metrics[] = array( 'value' => $value, 'label' => $label );
			}
		}
	}

	if ( $steps ) {
		update_post_meta( $post_id, 'case_steps', $steps );
	} else {
		delete_post_meta( $post_id, 'case_steps' );
	}

	if ( $metrics ) {
		update_post_meta( $post_id, 'case_metrics', $metrics );
	} else {
		delete_post_meta( $post_id, 'case_metrics' );
	}
}
add_action( 'save_post_alfa_case', 'alfa_case_meta_box_save' );

/**
 * Small helper: inline SVG icon set.
 *
 * @param string $name Icon name.
 * @param string $class Extra class.
 * @return string
 */
function alfa_icon( $name, $class = '' ) {
	return sprintf(
		'<svg class="icon %1$s" aria-hidden="true" focusable="false"><use href="#i-%2$s"></use></svg>',
		esc_attr( $class ),
		esc_attr( $name )
	);
}

/**
 * Inline the SVG sprite once per page.
 */
function alfa_sprite() {
	$file = get_stylesheet_directory() . '/assets/icons/sprite.svg';
	if ( is_file( $file ) ) {
		echo '<div class="svg-sprite" aria-hidden="true">' . file_get_contents( $file ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_body_open', 'alfa_sprite', 5 );

/**
 * Fallback menu for the header when no menu is assigned yet.
 */
function alfa_fallback_menu() {
	$items = array(
		'Главная'      => home_url( '/' ),
		'Услуги'       => home_url( '/uslugi/' ),
		'Кейсы'        => home_url( '/keysy/' ),
		'О нас'        => home_url( '/o-nas/' ),
		'База знаний'  => home_url( '/blog/' ),
	);

	echo '<ul class="nav__list">';
	foreach ( $items as $label => $url ) {
		$icon = 'База знаний' === $label ? alfa_icon( 'cloud' ) : '';
		printf( '<li><a href="%s">%s%s</a></li>', esc_url( $url ), $icon, esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Image URI with a graceful fallback while an asset has not been exported yet.
 *
 * @param string $file     File name inside assets/images.
 * @param string $fallback Fallback file name inside assets/images.
 * @return string
 */
function alfa_image( $file, $fallback = '' ) {
	$dir = get_stylesheet_directory() . '/assets/images/';
	$uri = get_stylesheet_directory_uri() . '/assets/images/';

	$pick = function ( $name ) use ( $dir, $uri ) {
		$webp = preg_replace( '/\.png$/i', '.webp', $name );
		if ( is_file( $dir . $webp ) ) {
			return $uri . $webp;
		}
		if ( is_file( $dir . $name ) ) {
			return $uri . $name;
		}
		return '';
	};

	if ( $found = $pick( $file ) ) {
		return $found;
	}
	if ( $fallback && ( $found = $pick( $fallback ) ) ) {
		return $found;
	}
	if ( $found = $pick( 'f-2018-8635.png' ) ) {
		return $found;
	}

	return $uri . preg_replace( '/\.png$/i', '.webp', $file );
}
