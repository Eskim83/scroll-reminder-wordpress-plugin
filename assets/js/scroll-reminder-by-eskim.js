(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('scroll-reminder-by-eskim-bar');
        const percentBox = document.getElementById('scroll-reminder-by-eskim-percent');
        const opts = window.ScrollReminderSettings || {};

        if (opts.hide_on_mobile && window.innerWidth <= 768) return;
        if (!opts.progress_bar_enabled && !opts.percentage_label_enabled) return;

        // === PROGRESS BAR ===
        if (opts.progress_bar_enabled && bar) {
            Object.assign(bar.style, {
                position: 'fixed',
                left: '0',
                right: '0',
                top: opts.progress_bar_position === 'bottom' ? '' : '0',
                bottom: opts.progress_bar_position === 'bottom' ? '0' : '',
                height: opts.progress_bar_height || '4px',
                backgroundColor: opts.progress_bar_color || '#2299ee',
                zIndex: '9998',
                width: '0',
                transition: `width ${opts.progress_bar_transition_speed || '0.2s'} ease`,
            });
        }

        // === PERCENTAGE LABEL ===
		if (opts.percentage_label_enabled && percentBox) {
			Object.assign(percentBox.style, {
				position: 'fixed',
				zIndex: '9998',
				fontSize: opts.percentage_label_font_size || '12px',
				color: opts.percentage_label_font_color || '#ffffff',
				background: (opts.percentage_label_color || '#000000') + 'aa',
				textAlign: 'center',
				userSelect: 'none',
			});

			// Ustaw kształt
			
			percentBox.style.width = opts.percentage_label_size;
			percentBox.style.height = opts.percentage_label_size;
			
			percentBox.style.padding = '2px 6px';
			percentBox.style.margin = '0';
			percentBox.style.overflow = 'hidden';
			percentBox.style.display = 'flex';
			percentBox.style.alignItems = 'center';
			percentBox.style.justifyContent = 'center';
			
			if (opts.percentage_label_shape === 'circle' && opts.percentage_label_size) percentBox.style.borderRadius = '50%';

			// Pozycja
			if (opts.percentage_label_percent_position?.includes('top')) {
				percentBox.style.top = '10px';
			} else {
				percentBox.style.bottom = '10px';
			}

			if (opts.percentage_label_percent_position?.includes('left')) {
				percentBox.style.left = '10px';
			} else {
				percentBox.style.right = '10px';
			}
		}

        // === SCROLL HANDLING ===
        const updateProgress = () => {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
            const percent = maxScroll > 0 ? Math.min(100, Math.round((scrollTop / maxScroll) * 100)) : 0;

            if (opts.progress_bar_enabled && bar) {
                bar.style.width = `${percent}%`;
				percentBox.textContent = `${percent}%`;
            }
        };

        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    updateProgress();
                    ticking = false;
                });
                ticking = true;
            }
        });

        updateProgress();
    });
})();
