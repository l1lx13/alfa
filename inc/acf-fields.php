<?php
/**
 * ACF integration: local field groups + a unified getter.
 *
 * Если плагин ACF установлен — поля появляются в админке и используются в шаблонах.
 * Если нет — шаблоны берут значения из мета-полей / опций, а в их отсутствие
 * показывают дефолты, поэтому сайт выглядит одинаково в обоих случаях.
 *
 * @package alfa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a theme field: ACF → post meta / option → default.
 *
 * @param string   $name    Field name.
 * @param mixed    $default Default value.
 * @param string   $context 'post' or 'option'.
 * @param int|null $post_id Post ID override.
 * @return mixed
 */
function alfa_field( $name, $default = '', $context = 'post', $post_id = null ) {
	$post_id = $post_id ? $post_id : ( 'option' === $context ? (int) get_option( 'alfa_settings_page' ) : get_the_ID() );

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
	} else {
		$value = get_post_meta( $post_id, $name, true );
	}

	if ( null === $value || '' === $value || false === $value || array() === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Сохраняем группу полей в базу (чтобы она была видна и редактируема в админке).
 * Если такая группа уже есть — ничего не делаем.
 *
 * @param array $group ACF group definition.
 */
function alfa_import_field_group( $group ) {
	static $done = array();

	if ( ! function_exists( 'acf_import_field_group' ) ) {
		return;
	}

	if ( isset( $done[ $group['key'] ] ) ) {
		return;
	}
	$done[ $group['key'] ] = true;

	if ( acf_get_field_group( $group['key'] ) ) {
		return;
	}

	acf_import_field_group( $group );
}

/**
 * Options page + field groups.
 */
function alfa_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$settings_page = (int) get_option( 'alfa_settings_page' );

	$social = array( 'youtube', 'vk', 'facebook', 'instagram', 'telegram', 'whatsapp', 'viber' );

	$header_fields = array(
		array(
			'key'   => 'field_alfa_head_tab',
			'label' => 'Шапка',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_alfa_head_phone',
			'name'          => 'header_phone',
			'label'         => 'Телефон',
			'type'          => 'text',
			'default_value' => '+375 (44) 731-25-64',
		),
		array(
			'key'           => 'field_alfa_head_wa',
			'name'          => 'header_whatsapp',
			'label'         => 'Ссылка WhatsApp',
			'type'          => 'url',
			'default_value' => 'https://wa.me/375447312564',
		),
		array(
			'key'           => 'field_alfa_head_tagline',
			'name'          => 'header_tagline',
			'label'         => 'Подпись у логотипа',
			'type'          => 'textarea',
			'rows'          => 2,
			'default_value' => 'Digital агентство полного цикла в СНГ и ЕС',
			'instructions'  => 'Можно выделять <b>СНГ</b> и <b>ЕС</b> тегом b.',
		),
		array(
			'key'           => 'field_alfa_head_cta',
			'name'          => 'header_cta_text',
			'label'         => 'Кнопка в шапке',
			'type'          => 'text',
			'default_value' => 'Связаться с нами',
		),
		array(
			'key'           => 'field_alfa_head_cta_link',
			'name'          => 'header_cta_link',
			'label'         => 'Ссылка кнопки',
			'type'          => 'text',
			'default_value' => '#callback',
		),
	);

	foreach ( $social as $network ) {
		$header_fields[] = array(
			'key'   => 'field_alfa_head_social_' . $network,
			'name'  => 'header_social_' . $network,
			'label' => 'Соцсеть: ' . $network,
			'type'  => 'url',
		);
	}

	$header_fields[] = array(
		'key'   => 'field_alfa_foot_tab',
		'label' => 'Подвал',
		'type'  => 'tab',
	);
	$header_fields[] = array(
		'key'           => 'field_alfa_foot_lead',
		'name'          => 'footer_lead',
		'label'         => 'Заголовок подвала',
		'type'          => 'text',
		'default_value' => 'Свяжитесь с нами любым удобным для вас способом',
	);
	$header_fields[] = array(
		'key'           => 'field_alfa_foot_phone2',
		'name'          => 'footer_phone_two',
		'label'         => 'Второй телефон',
		'type'          => 'text',
		'default_value' => '+375 (29) 915 87 66',
	);
	$header_fields[] = array(
		'key'           => 'field_alfa_foot_subscribe',
		'name'          => 'footer_subscribe',
		'label'         => 'Текст подписки',
		'type'          => 'text',
		'default_value' => 'получите чек-лист для привлечения клиентов БЕСПЛАТНО',
	);
	$header_fields[] = array(
		'key'           => 'field_alfa_foot_privacy',
		'name'          => 'footer_privacy',
		'label'         => 'Ссылка на политику',
		'type'          => 'url',
	);
	$header_fields[] = array(
		'key'   => 'field_alfa_foot_qr',
		'name'  => 'footer_qr',
		'label' => 'Картинка QR',
		'type'  => 'image',
		'return_format' => 'url',
	);
	$header_fields[] = array(
		'key'   => 'field_alfa_foot_pay',
		'name'  => 'footer_payments',
		'label' => 'Логотипы оплаты',
		'type'  => 'image',
		'return_format' => 'url',
	);

	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_settings',
			'title'    => 'Настройки шапки и подвала',
			'fields'   => $header_fields,
			'location' => array(
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => (string) $settings_page,
					),
				),
			),
		)
	);

	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_front',
			'title'    => 'Главная — тексты',
			'fields'   => array(
				array(
					'key'   => 'field_alfa_front_hero',
					'label' => 'Hero',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_alfa_hero_title',
					'name'          => 'hero_title',
					'label'         => 'Заголовок',
					'type'          => 'text',
					'default_value' => 'alfa digital agency',
				),
				array(
					'key'           => 'field_alfa_hero_lead',
					'name'          => 'hero_lead',
					'label'         => 'Подзаголовок',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Оставьте заявку на разбор и узнайте, как выстроить системный маркетинг, который будет работать на ваш бизнес 24/7',
				),
				array(
					'key'           => 'field_alfa_hero_btn1',
					'name'          => 'hero_btn_primary',
					'label'         => 'Кнопка 1',
					'type'          => 'text',
					'default_value' => 'Оставить заявку на разбор',
				),
				array(
					'key'           => 'field_alfa_hero_btn2',
					'name'          => 'hero_btn_secondary',
					'label'         => 'Кнопка 2',
					'type'          => 'text',
					'default_value' => 'Записаться на встречу',
				),
				array(
					'key'   => 'field_alfa_front_stats',
					'label' => 'Цифры',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_alfa_stats_amount',
					'name'          => 'stats_amount',
					'label'         => 'Сумма',
					'type'          => 'text',
					'default_value' => '2 000 000 €',
				),
				array(
					'key'           => 'field_alfa_stats_caption',
					'name'          => 'stats_caption',
					'label'         => 'Подпись к сумме',
					'type'          => 'text',
					'default_value' => 'Получили наши клиенты',
				),
				array(
					'key'           => 'field_alfa_stats_since',
					'name'          => 'stats_since',
					'label'         => 'Заголовок «Начиная с…»',
					'type'          => 'text',
					'default_value' => 'Начиная с 2018 г',
				),
				array(
					'key'           => 'field_alfa_stats_note',
					'name'          => 'stats_note',
					'label'         => 'Текст рядом',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Команда Alfa Digital Agency поработала более чем с 30+ нишами',
				),
				array(
					'key'   => 'field_alfa_front_sections',
					'label' => 'Заголовки секций',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_alfa_cases_title',
					'name'          => 'cases_title',
					'label'         => 'Кейсы — заголовок',
					'type'          => 'text',
					'default_value' => 'Примеры наших работ с подвязкой на результат',
				),
				array(
					'key'           => 'field_alfa_meetings_title',
					'name'          => 'meetings_title',
					'label'         => 'Встречи — заголовок',
					'type'          => 'text',
					'default_value' => 'Встречи с клиентами',
				),
				array(
					'key'           => 'field_alfa_meetings_lead',
					'name'          => 'meetings_lead',
					'label'         => 'Встречи — текст',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Реальный выезд на объект, который пришёл с рекламы, как результат упорного труда команды Alfa Digital Agency',
				),
				array(
					'key'           => 'field_alfa_coop_title',
					'name'          => 'coop_title',
					'label'         => 'Сотрудничество — заголовок',
					'type'          => 'text',
					'default_value' => 'Сотрудничество с Alfa Digital — это двусторонние отношения',
				),
				array(
					'key'           => 'field_alfa_services_title',
					'name'          => 'services_title',
					'label'         => 'Услуги — заголовок',
					'type'          => 'text',
					'default_value' => 'Услуги, которые мы оказываем начиная с 2018 года',
				),
				array(
					'key'           => 'field_alfa_services_lead',
					'name'          => 'services_lead',
					'label'         => 'Услуги — подзаголовок',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Список услуг, которые помогли нашим клиентам заработать более 2 млн USD начиная с 2016 года',
				),
				array(
					'key'           => 'field_alfa_repost_title',
					'name'          => 'repost_title',
					'label'         => 'Репост — заголовок',
					'type'          => 'text',
					'default_value' => 'Сохрани себе статью, чтобы не потерять, в 1 клик',
				),
				array(
					'key'           => 'field_alfa_stats_quote',
					'name'          => 'stats_quote',
					'label'         => 'Цитата',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => '💼 «Директор несёт ответственность за результат каждого проекта. Руководил отделами продаж, с которых SALES принёс более 2 млн USD»',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);
	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_review',
			'title'    => 'Видео-отзыв',
			'fields'   => array(
				array( 'key' => 'field_alfa_rev_poster', 'name' => 'review_poster', 'label' => 'Постер (фото)', 'type' => 'image', 'return_format' => 'url', 'instructions' => 'Можно оставить пустым — подставится картинка по умолчанию.' ),
				array( 'key' => 'field_alfa_rev_title', 'name' => 'review_title', 'label' => 'Заголовок на карточке', 'type' => 'text', 'default_value' => 'Натяжные потолки' ),
				array( 'key' => 'field_alfa_rev_sub', 'name' => 'review_sub', 'label' => 'Подпись', 'type' => 'text', 'default_value' => 'Таргетированная реклама' ),
				array( 'key' => 'field_alfa_rev_name', 'name' => 'review_name', 'label' => 'Имя клиента', 'type' => 'text' ),
				array( 'key' => 'field_alfa_rev_video', 'name' => 'review_video', 'label' => 'Ссылка на видео', 'type' => 'url' ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'alfa_review' ) ) ),
		)
	);

	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_case',
			'title'    => 'Кейс',
			'fields'   => array(
				array( 'key' => 'field_alfa_case_cover', 'name' => 'case_cover', 'label' => 'Обложка кейса', 'type' => 'image', 'return_format' => 'url' ),
				array( 'key' => 'field_alfa_case_tag', 'name' => 'case_tag', 'label' => 'Отрасль (тег)', 'type' => 'text', 'default_value' => 'Строительство' ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'alfa_case' ) ) ),
		)
	);

	/* Глобальные блоки, повторяющиеся на всех страницах */
	$blocks = array(
		array( 'key' => 'field_alfa_blk_tab', 'label' => 'Блок «Сотрудничество»', 'type' => 'tab' ),
		array( 'key' => 'field_alfa_blk_coop_title', 'name' => 'coop_title', 'label' => 'Заголовок', 'type' => 'text', 'default_value' => 'Сотрудничество с Alfa Digital — это двусторонние отношения' ),
		array( 'key' => 'field_alfa_blk_coop_text', 'name' => 'coop_text', 'label' => 'Текст', 'type' => 'textarea', 'rows' => 3, 'default_value' => '🤪 Мы — инновационное рекламное агентство, которое меняет правила игры. Ещё в далёком 2018 году Пожарицким Романом Николаевичем был придуман и разработан уникальный подход к маркетингу, который сегодня приносит клиентам миллионы.' ),
		array( 'key' => 'field_alfa_blk_coop_person', 'name' => 'coop_person', 'label' => 'Имя', 'type' => 'text', 'default_value' => 'Пожарицкий Роман' ),
		array( 'key' => 'field_alfa_blk_coop_role', 'name' => 'coop_role', 'label' => 'Должность', 'type' => 'text', 'default_value' => 'Основатель. Alfa Digital Agency' ),
		array( 'key' => 'field_alfa_blk_coop_goals', 'name' => 'coop_goals', 'label' => 'Цели (по одной в строке)', 'type' => 'textarea', 'rows' => 3, 'default_value' => "Открытие ЦО в Аликанте, Испания\nЗапуск платформы для Франчайзи партнёров" ),
		array( 'key' => 'field_alfa_blk_coop_btn', 'name' => 'coop_btn', 'label' => 'Кнопка', 'type' => 'text', 'default_value' => 'О собственнике' ),
		array( 'key' => 'field_alfa_blk_coop_img', 'name' => 'coop_image', 'label' => 'Фото', 'type' => 'image', 'return_format' => 'url' ),

		array( 'key' => 'field_alfa_blk_tab2', 'label' => 'Блок «ТОП-3»', 'type' => 'tab' ),
		array( 'key' => 'field_alfa_blk_top3_title', 'name' => 'top3_title', 'label' => 'Заголовок', 'type' => 'text', 'default_value' => '🤪 #Ниже смотрите ТОП-3 выдающихся результата' ),
		array( 'key' => 'field_alfa_blk_top3_lead', 'name' => 'top3_lead', 'label' => 'Подзаголовок', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Это лучшие кейсы наших клиентов: что именно сделала команда, чтобы прийти к таким цифрам, и какой результат это принесло в деньгах.' ),
		array( 'key' => 'field_alfa_blk_t3_1', 'name' => 'top3_1_title', 'label' => 'Результат 1 — заголовок', 'type' => 'text', 'default_value' => '72 млн ₽ всего за первые 7 дней рекламы' ),
		array( 'key' => 'field_alfa_blk_t3_2', 'name' => 'top3_2_title', 'label' => 'Результат 2 — заголовок', 'type' => 'text', 'default_value' => 'Более 1000 заявок на строительство' ),
		array( 'key' => 'field_alfa_blk_t3_3', 'name' => 'top3_3_title', 'label' => 'Результат 3 — заголовок', 'type' => 'text', 'default_value' => 'Более 500 000$ на производство' ),

		array( 'key' => 'field_alfa_blk_tab3', 'label' => 'Блок «Заявка»', 'type' => 'tab' ),
		array( 'key' => 'field_alfa_blk_cb_eyebrow', 'name' => 'callback_eyebrow', 'label' => 'Надзаголовок', 'type' => 'text', 'default_value' => 'Оставляйте заявку и получите стратегию в ПОДАРОК!' ),
		array( 'key' => 'field_alfa_blk_cb_title', 'name' => 'callback_title', 'label' => 'Заголовок', 'type' => 'text', 'default_value' => '🔥 Друг, давай я тебе перезвоню' ),
		array( 'key' => 'field_alfa_blk_cb_text', 'name' => 'callback_text', 'label' => 'Текст', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Меня зовут Роман, я СЕО Alfa Digital Agency. В прошлом был опыт своего строительного бизнеса, поэтому очень хорошо понимаю внутреннюю кухню.' ),
		array( 'key' => 'field_alfa_blk_cb_strong', 'name' => 'callback_strong', 'label' => 'Выделенный текст', 'type' => 'text', 'default_value' => 'РАЗДАЮ ЗАКАЗЫ НА СТРОИТЕЛЬСТВО, РЕМОНТ, МЕБЕЛЬ, НЕДВИЖИМОСТЬ' ),
		array( 'key' => 'field_alfa_blk_cb_person', 'name' => 'callback_person', 'label' => 'Имя', 'type' => 'text', 'default_value' => 'Пожарицкий Роман' ),
		array( 'key' => 'field_alfa_blk_cb_role', 'name' => 'callback_role', 'label' => 'Должность', 'type' => 'text', 'default_value' => 'Основатель Alfa Digital Agency' ),
		array( 'key' => 'field_alfa_blk_cb_submit', 'name' => 'callback_submit', 'label' => 'Кнопка отправки', 'type' => 'text', 'default_value' => 'Перезвонить мне' ),
		array( 'key' => 'field_alfa_blk_cb_consent', 'name' => 'callback_consent', 'label' => 'Согласие', 'type' => 'text', 'default_value' => 'Я ознакомлен(-а) с Политикой конфиденциальности' ),

		array( 'key' => 'field_alfa_blk_tab4', 'label' => 'Блок «Встречи» и «Репост»', 'type' => 'tab' ),
		array( 'key' => 'field_alfa_blk_meet_title', 'name' => 'meetings_title', 'label' => 'Встречи — заголовок', 'type' => 'text', 'default_value' => 'Встречи с клиентами' ),
		array( 'key' => 'field_alfa_blk_meet_lead', 'name' => 'meetings_lead', 'label' => 'Встречи — текст', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Реальный выезд на объект, который пришёл с рекламы, как результат упорного труда команды Alfa Digital Agency' ),
		array( 'key' => 'field_alfa_blk_meet_btn', 'name' => 'meetings_btn', 'label' => 'Встречи — кнопка', 'type' => 'text', 'default_value' => 'Перейти в фотогалерею' ),
		array( 'key' => 'field_alfa_blk_rep_title', 'name' => 'repost_title', 'label' => 'Репост — заголовок', 'type' => 'text', 'default_value' => 'Сохрани себе статью, чтобы не потерять, в 1 клик' ),
	);

	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_blocks',
			'title'    => 'Общие блоки (все страницы)',
			'fields'   => $blocks,
			'location' => array( array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $settings_page ) ) ),
		)
	);

	alfa_import_field_group(
		array(
			'key'      => 'group_alfa_pages',
			'title'    => 'Страницы — заголовки',
			'fields'   => array(
				array( 'key' => 'field_alfa_pg_uslugi_title', 'name' => 'uslugi_title', 'label' => 'Услуги — заголовок', 'type' => 'text', 'default_value' => 'Услуги, которые мы оказываем начиная с 2018 года' ),
				array( 'key' => 'field_alfa_pg_uslugi_lead', 'name' => 'uslugi_lead', 'label' => 'Услуги — подзаголовок', 'type' => 'text', 'default_value' => 'Оставьте заявку и мы свяжемся с вами в течение рабочего дня' ),
				array( 'key' => 'field_alfa_pg_uslugi_sub', 'name' => 'uslugi_subtitle', 'label' => 'Услуги — заголовок списка', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Список услуг, благодаря которым мы помогли нашим клиентам заработать более 2 млн USD начиная с 2018 года' ),
				array( 'key' => 'field_alfa_pg_about_brand', 'name' => 'about_brand', 'label' => 'О нас — надзаголовок', 'type' => 'text', 'default_value' => 'История alfa digital agency' ),
				array( 'key' => 'field_alfa_pg_about_title', 'name' => 'about_title', 'label' => 'О нас — заголовок', 'type' => 'text', 'default_value' => 'Как всё начиналось' ),
				array( 'key' => 'field_alfa_pg_about_text', 'name' => 'about_text', 'label' => 'О нас — текст', 'type' => 'textarea', 'rows' => 3, 'default_value' => '🤪 Мы — инновационное рекламное агентство, которое меняет правила игры. Нестандартный подход к решению бизнес-задач.' ),
				array( 'key' => 'field_alfa_pg_cases_title', 'name' => 'cases_page_title', 'label' => 'Кейсы — заголовок', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Приведём лояльных клиентов в нишу ремонта и отделки с оплатой от результата' ),
				array( 'key' => 'field_alfa_pg_cases_lead', 'name' => 'cases_page_lead', 'label' => 'Кейсы — подзаголовок', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Оставьте заявку и узнайте, как выстроить системный маркетинг, который будет работать на ваш бизнес 24/7 😁' ),
				array( 'key' => 'field_alfa_pg_vac_title', 'name' => 'vacancies_title', 'label' => 'Вакансии — заголовок', 'type' => 'text', 'default_value' => 'Вакансии' ),
				array( 'key' => 'field_alfa_pg_vac_text', 'name' => 'vacancies_text', 'label' => 'Вакансии — текст', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Мы растём и ищем людей, которым интересно строить системный маркетинг, а не «рисовать баннеры». Ниже — открытые позиции.' ),
				array( 'key' => 'field_alfa_pg_thanks_title', 'name' => 'thanks_title', 'label' => 'Спасибо — заголовок', 'type' => 'text', 'default_value' => 'Спасибо! Заявка у нас' ),
				array( 'key' => 'field_alfa_pg_thanks_text', 'name' => 'thanks_text', 'label' => 'Спасибо — текст', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Роман свяжется с вами в течение рабочего дня и подготовит разбор под вашу нишу.' ),
				array( 'key' => 'field_alfa_pg_quiz_title', 'name' => 'quiz_title', 'label' => 'Квиз — заголовок', 'type' => 'text', 'default_value' => 'Получите стратегию продвижения в подарок' ),
				array( 'key' => 'field_alfa_pg_quiz_lead', 'name' => 'quiz_lead', 'label' => 'Квиз — подзаголовок', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Ответьте на 4 вопроса — Роман подготовит разбор под вашу нишу и пришлёт в течение рабочего дня.' ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ) ),
		)
	);
}
add_action( 'acf/init', 'alfa_acf_fields' );
