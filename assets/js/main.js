/* Alfa Digital Agency — UI behaviour */
(function () {
	'use strict';

	const $ = (sel, ctx) => (ctx || document).querySelector(sel);
	const $$ = (sel, ctx) => Array.from((ctx || document).querySelectorAll(sel));

	/* ---------------- Header sticky state ---------------- */
	const header = $('.site-header');
	if (header) {
		const onScroll = () => header.classList.toggle('is-stuck', window.scrollY > 20);
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ---------------- Mobile menu ---------------- */
	const burger = $('.burger');
	const mobileMenu = $('#mobile-menu');
	const mobileClose = $('.mobile-menu__close');

	const closeMenu = () => {
		if (!mobileMenu) return;
		mobileMenu.hidden = true;
		document.body.classList.remove('is-locked');
		if (burger) burger.setAttribute('aria-expanded', 'false');
	};

	const openMenu = () => {
		if (!mobileMenu) return;
		mobileMenu.hidden = false;
		document.body.classList.add('is-locked');
		if (burger) burger.setAttribute('aria-expanded', 'true');
	};

	if (burger && mobileMenu) {
		burger.addEventListener('click', () => (mobileMenu.hidden ? openMenu() : closeMenu()));
		mobileClose && mobileClose.addEventListener('click', closeMenu);
		$$('a', mobileMenu).forEach((a) => a.addEventListener('click', closeMenu));
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && !mobileMenu.hidden) closeMenu();
		});
	}

	/* ---------------- Кейсы: фильтр и пагинация без перезагрузки ---------------- */
	const applyCases = (section, html, tag, page) => {
		const tmp = document.createElement('div');
		tmp.innerHTML = html;

		const freshGrid = tmp.querySelector('.cases__grid');
		const freshPag = tmp.querySelector('.pagination');
		const grid = section.querySelector('.cases__grid');
		const pag = section.querySelector('.pagination');

		if (!freshGrid || !grid) return;

		grid.replaceWith(freshGrid);

		if (pag && freshPag) {
			pag.replaceWith(freshPag);
		} else if (pag && !freshPag) {
			pag.remove();
		} else if (!pag && freshPag) {
			freshGrid.insertAdjacentElement('afterend', freshPag);
		}

		section.dataset.tag = tag || '';
		section.dataset.page = page || 1;

		section.querySelectorAll('.tabs__item').forEach((item) => {
			const active = (item.dataset.tag || '') === (tag || '');
			item.classList.toggle('is-active', active);
			if (active) {
				item.setAttribute('aria-current', 'true');
			} else {
				item.removeAttribute('aria-current');
			}
		});
	};

	const loadCases = (tag, page) => {
		const section = document.querySelector('[data-cases]');
		if (!section || section.dataset.busy === '1') return;

		section.dataset.busy = '1';
		section.classList.add('is-loading');

		const url = `${alfaData.ajaxUrl}?action=alfa_cases&tag=${encodeURIComponent(tag || '')}&page=${page || 1}`;

		fetch(url, { credentials: 'same-origin' })
			.then((r) => r.json())
			.then((res) => {
				if (!res || !res.success || !res.data || !res.data.html) return;
				applyCases(section, res.data.html, tag, page);
			})
			.catch(() => {})
			.finally(() => {
				section.dataset.busy = '0';
				section.classList.remove('is-loading');
			});
	};

	document.addEventListener('click', (e) => {
		const section = e.target.closest('[data-cases]');
		if (!section) return;

		const tab = e.target.closest('.tabs__item');
		if (tab) {
			e.preventDefault();
			loadCases(tab.dataset.tag || '', 1);
			return;
		}

		const pageLink = e.target.closest('.pagination a[data-page]');
		if (pageLink) {
			e.preventDefault();
			loadCases(section.dataset.tag || '', parseInt(pageLink.dataset.page, 10) || 1);
		}
	});

	/* ---------------- Slider ---------------- */
	$$('[data-slider]').forEach((slider) => {
		const track = $('[data-slider-track]', slider);
		if (!track) return;

		const step = () => {
			const card = $('.review-card', track);
			if (!card) return track.clientWidth * 0.8;
			const gap = parseFloat(getComputedStyle(track).columnGap || '0') || 0;
			return card.getBoundingClientRect().width + gap;
		};

		$('[data-slider-prev]', slider) &&
			$('[data-slider-prev]', slider).addEventListener('click', () => {
				track.scrollBy({ left: -step(), behavior: 'smooth' });
			});

		$('[data-slider-next]', slider) &&
			$('[data-slider-next]', slider).addEventListener('click', () => {
				track.scrollBy({ left: step(), behavior: 'smooth' });
			});
	});

	/* ---------------- Video modal ---------------- */
	const modal = $('[data-video-modal]');
	const frame = $('[data-video-frame]');

	const closeVideo = () => {
		if (!modal) return;
		modal.hidden = true;
		document.body.classList.remove('is-locked');
		if (frame) frame.src = '';
	};

	$$('[data-video-open]').forEach((btn) => {
		btn.addEventListener('click', () => {
			if (!modal || !frame) return;
			frame.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&rel=0';
			modal.hidden = false;
			document.body.classList.add('is-locked');
		});
	});

	if (modal) {
		$('[data-video-close]', modal) &&
			$('[data-video-close]', modal).addEventListener('click', closeVideo);
		modal.addEventListener('click', (e) => {
			if (e.target === modal) closeVideo();
		});
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && !modal.hidden) closeVideo();
		});
	}

	/* ---------------- Popup ---------------- */
	const popup = $('[data-popup]');
	if (popup && !sessionStorage.getItem('alfaPopupShown')) {
		const closePopup = () => {
			popup.hidden = true;
			document.body.classList.remove('is-locked');
			sessionStorage.setItem('alfaPopupShown', '1');
		};

		const openPopup = () => {
			if (sessionStorage.getItem('alfaPopupShown')) return;
			popup.hidden = false;
			document.body.classList.add('is-locked');
			sessionStorage.setItem('alfaPopupShown', '1');
		};

		setTimeout(openPopup, 45000);

		$('[data-popup-close]', popup) && $('[data-popup-close]', popup).addEventListener('click', closePopup);
		popup.addEventListener('click', (e) => {
			if (e.target === popup) closePopup();
		});
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && !popup.hidden) closePopup();
		});
	}

	/* ---------------- Toast ---------------- */
	let toastTimer;
	const toast = (message) => {
		let el = $('.toast');
		if (!el) {
			el = document.createElement('div');
			el.className = 'toast';
			document.body.appendChild(el);
		}
		el.textContent = message;
		requestAnimationFrame(() => el.classList.add('is-visible'));
		clearTimeout(toastTimer);
		toastTimer = setTimeout(() => el.classList.remove('is-visible'), 3200);
	};

	/* ---------------- Phone mask ---------------- */
	const maskPhone = (input) => {
		input.addEventListener('input', () => {
			let digits = input.value.replace(/\D/g, '');
			if (digits.startsWith('375')) digits = digits.slice(3);
			digits = digits.slice(0, 9);
			let out = '+375 ';
			if (digits.length) out += '(' + digits.slice(0, 2) + ')';
			if (digits.length >= 3) out += ' ' + digits.slice(2, 5);
			if (digits.length >= 6) out += '-' + digits.slice(5, 7);
			if (digits.length >= 8) out += '-' + digits.slice(7, 9);
			input.value = out;
		});
		input.addEventListener('focus', () => {
			if (!input.value.trim()) input.value = '+375 ';
		});
	};

	$$('input[type="tel"]').forEach(maskPhone);

	/* ---------------- Lead form ---------------- */
	const form = $('[data-lead-form]');
	if (form) {
		const status = $('[data-form-status]', form);
		const submit = $('.lead-form__submit', form);

		const setStatus = (text, kind) => {
			if (!status) return;
			status.textContent = text;
			status.classList.remove('is-error', 'is-success');
			if (kind) status.classList.add('is-' + kind);
		};

		form.addEventListener('submit', (e) => {
			e.preventDefault();

			const name = form.elements.name;
			const phone = form.elements.phone;
			const consent = form.elements.consent;

			let valid = true;
			[name, phone].forEach((input) => {
				const ok = input.value.trim().length > 0 && (input !== phone || input.value.replace(/\D/g, '').length >= 11);
				input.classList.toggle('is-invalid', !ok);
				if (!ok) valid = false;
			});

			if (!valid) {
				setStatus('Заполните имя и корректный номер телефона.', 'error');
				return;
			}

			if (consent && !consent.checked) {
				setStatus('Подтвердите согласие с политикой конфиденциальности.', 'error');
				return;
			}

			if (typeof alfaData === 'undefined') {
				setStatus('Форма временно недоступна.', 'error');
				return;
			}

			if (submit) submit.disabled = true;
			setStatus('Отправляем…');

			const data = new FormData();
			data.append('action', 'alfa_lead');
			data.append('nonce', alfaData.nonce);
			data.append('name', name.value.trim());
			data.append('phone', phone.value.trim());
			data.append('time', (form.elements.time || {}).value || '');
			data.append('way', (form.querySelector('input[name="way"]:checked') || {}).value || '');
			data.append('page', window.location.href);

			fetch(alfaData.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' })
				.then((r) => r.json())
				.then((res) => {
					if (res && res.success) {
						setStatus(res.data.message, 'success');
						form.reset();
					} else {
						const msg = res && res.data && res.data.message ? res.data.message : 'Что-то пошло не так. Попробуйте ещё раз.';
						setStatus(msg, 'error');
					}
				})
				.catch(() => setStatus('Сеть недоступна. Попробуйте ещё раз.', 'error'))
				.finally(() => {
					if (submit) submit.disabled = false;
				});
		});
	}

	/* ---------------- Subscribe form ---------------- */
	$$('[data-subscribe-form]').forEach((f) => {
		f.addEventListener('submit', (e) => {
			e.preventDefault();
			const input = f.querySelector('input');
			if (!input || !input.value) return;
			toast('Спасибо! Чек-лист придёт на почту.');
			f.reset();
		});
	});

	/* ---------------- Share ---------------- */
	const pageUrl = encodeURIComponent(window.location.href);
	const pageTitle = encodeURIComponent(document.title);

	const shareTargets = {
		facebook: 'https://www.facebook.com/sharer/sharer.php?u=' + pageUrl,
		vk: 'https://vk.com/share.php?url=' + pageUrl,
		telegram: 'https://t.me/share/url?url=' + pageUrl + '&text=' + pageTitle,
		whatsapp: 'https://wa.me/?text=' + pageTitle + '%20' + pageUrl,
		viber: 'viber://forward?text=' + pageTitle + '%20' + pageUrl,
		instagram: 'https://www.instagram.com/',
	};

	$$('[data-share]').forEach((link) => {
		link.addEventListener('click', (e) => {
			e.preventDefault();
			const network = link.dataset.share;
			const url = shareTargets[network];
			if (url) window.open(url, '_blank', 'noopener,width=640,height=560');
		});
	});

	$$('[data-copy-link]').forEach((btn) => {
		btn.addEventListener('click', () => {
			const done = () => toast('Ссылка скопирована');
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(window.location.href).then(done, done);
			} else {
				const tmp = document.createElement('textarea');
				tmp.value = window.location.href;
				document.body.appendChild(tmp);
				tmp.select();
				document.execCommand('copy');
				tmp.remove();
				done();
			}
		});
	});

	/* ---------------- Quiz ---------------- */
	const quiz = $('[data-quiz]');
	if (quiz) {
		const steps = $$('[data-quiz-step]', quiz);
		const bar = $('[data-quiz-bar]', quiz);
		const counter = $('[data-quiz-counter]', quiz);
		const formEl = $('[data-quiz-form]', quiz);
		let index = 0;

		const show = (i) => {
			index = Math.max(0, Math.min(i, steps.length - 1));
			steps.forEach((s, n) => s.classList.toggle('is-active', n === index));
			if (bar) {
				const pct = Math.round(((index + 1) / 4) * 100);
				bar.style.width = Math.min(pct, 100) + '%';
			}
			if (counter) counter.textContent = 'Шаг ' + Math.min(index + 1, 4) + ' из 4';
		};

		$$('[data-quiz-next]', quiz).forEach((btn) => {
			btn.addEventListener('click', () => {
				const step = steps[index];
				const radios = $$('input[type="radio"]', step);
				if (radios.length && !radios.some((r) => r.checked)) {
					step.querySelector('.quiz__question').animate(
						[{ transform: 'translateX(0)' }, { transform: 'translateX(-6px)' }, { transform: 'translateX(6px)' }, { transform: 'translateX(0)' }],
						{ duration: 220 }
					);
					return;
				}
				show(index + 1);
			});
		});

		$$('[data-quiz-back]', quiz).forEach((btn) => btn.addEventListener('click', () => show(index - 1)));

		if (formEl) {
			formEl.addEventListener('submit', (e) => {
				e.preventDefault();
				const status = $('[data-form-status]', formEl);
				const data = new FormData();

				const answers = [];
				['niche', 'budget', 'goal'].forEach((name) => {
					const checked = formEl.querySelector('input[name="' + name + '"]:checked');
					if (checked) answers.push(name + ': ' + checked.value);
				});

				data.append('action', 'alfa_lead');
				data.append('nonce', alfaData.nonce);
				data.append('name', (formEl.elements.name || {}).value || '');
				data.append('phone', (formEl.elements.phone || {}).value || '');
				data.append('note', 'Квиз — ' + answers.join('; '));
				data.append('page', window.location.href);

				if (!data.get('name') || !data.get('phone')) {
					if (status) { status.textContent = 'Укажите имя и телефон.'; status.className = 'lead-form__status is-error'; }
					return;
				}

				fetch(alfaData.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' })
					.then((r) => r.json())
					.then((res) => {
						if (res && res.success) {
							show(4);
						} else if (status) {
							status.textContent = (res && res.data && res.data.message) || 'Что-то пошло не так.';
							status.className = 'lead-form__status is-error';
						}
					})
					.catch(() => {
						if (status) { status.textContent = 'Сеть недоступна.'; status.className = 'lead-form__status is-error'; }
					});
			});
		}
	}

	/* ---------------- Smooth anchor offset ---------------- */
	$$('a[href^="#"]').forEach((a) => {
		a.addEventListener('click', (e) => {
			const id = a.getAttribute('href');
			if (!id || id === '#') return;
			const target = document.querySelector(id);
			if (!target) return;
			e.preventDefault();
			const top = target.getBoundingClientRect().top + window.scrollY - (header ? header.offsetHeight : 0);
			window.scrollTo({ top, behavior: 'smooth' });
		});
	});
})();

/* ---------------- Мега-меню «Услуги» ---------------- */
(function () {
	const mega = document.getElementById('mega');
	if (!mega) return;

	const navbar = mega.closest('.navbar');
	const trigger = navbar && navbar.querySelector('.nav__list a[href*="/uslugi"]');
	if (!trigger) return;

	const backdrop = document.createElement('div');
	backdrop.className = 'mega-backdrop';
	backdrop.hidden = true;
	document.body.appendChild(backdrop);

	const isDesktop = () => window.matchMedia('(min-width: 1025px)').matches;

	const close = () => {
		mega.hidden = true;
		backdrop.hidden = true;
		trigger.classList.remove('is-mega-open');
		trigger.setAttribute('aria-expanded', 'false');
	};

	const positionBackdrop = () => {
		const navRect = navbar.getBoundingClientRect();
		backdrop.style.top = Math.max(0, navRect.bottom) + 'px';
	};

	const open = () => {
		mega.hidden = false;
		backdrop.hidden = false;
		positionBackdrop();
		trigger.classList.add('is-mega-open');
		trigger.setAttribute('aria-expanded', 'true');
	};

	trigger.setAttribute('aria-expanded', 'false');
	trigger.setAttribute('aria-controls', 'mega');

	trigger.addEventListener('click', (e) => {
		if (!isDesktop()) return;
		e.preventDefault();
		mega.hidden ? open() : close();
	});

	backdrop.addEventListener('click', close);

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && !mega.hidden) close();
	});

	document.addEventListener('click', (e) => {
		if (mega.hidden) return;
		if (mega.contains(e.target) || trigger.contains(e.target)) return;
		close();
	});

	window.addEventListener('resize', () => {
		if (!isDesktop()) close();
		if (!mega.hidden) positionBackdrop();
	});

	window.addEventListener('scroll', () => {
		if (!mega.hidden) positionBackdrop();
	}, { passive: true });

	mega.addEventListener('click', (e) => {
		if (e.target.closest('a')) close();
	});
})();
