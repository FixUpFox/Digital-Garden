/**
 * Breadcrumb trail for Digital Garden note pages.
 *
 * On every note visit the current page is appended to a localStorage queue.
 * If a `.digital-garden-breadcrumbs-placeholder` element is present on the
 * page, the queue is rendered into it as a navigation trail (excluding the
 * current page so you never see "you are here" in your own trail).
 *
 * Configuration is read from data attributes on the placeholder element:
 *   data-max-steps  — maximum number of notes to remember (default 5)
 *   data-heading    — heading text (default "Recently Viewed Notes")
 */
document.addEventListener('DOMContentLoaded', function () {
	var STORAGE_KEY = 'digitalGardenNotes';
	var placeholder = document.querySelector(
		'.digital-garden-breadcrumbs-placeholder',
	);
	var maxSteps = placeholder
		? parseInt(placeholder.getAttribute('data-max-steps'), 10) || 5
		: 5;

	// Record this visit so future pages can show it in their trail.
	if (document.body.classList.contains('single-note')) {
		var titleEl = document.querySelector(
			'.wp-block-post-title, h1.entry-title, h1.post-title',
		);
		if (titleEl) {
			track(
				{ title: titleEl.textContent.trim(), url: window.location.href },
				maxSteps,
			);
		}
	}

	// Populate the breadcrumb placeholder if it exists on this page.
	if (placeholder) {
		render(placeholder);
	}

	/**
	 * Appends a note to the history queue, deduplicating by URL and
	 * trimming the oldest entry when the queue exceeds maxSteps.
	 *
	 * @param {{title: string, url: string}} note
	 * @param {number} max
	 */
	function track(note, max) {
		var history = getHistory().filter(function (n) {
			return n.url !== note.url;
		});
		history.push(note);
		if (history.length > max) {
			history = history.slice(-max);
		}
		try {
			localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
		} catch (e) {
			// localStorage may be unavailable in private-browsing modes.
		}
	}

	/**
	 * Returns the stored note history, or an empty array on any error.
	 *
	 * @return {Array<{title: string, url: string}>}
	 */
	function getHistory() {
		try {
			return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
		} catch (e) {
			return [];
		}
	}

	/**
	 * Builds the breadcrumb HTML inside the placeholder element.
	 * Hides the element entirely if there is nothing to show.
	 *
	 * @param {Element} container The `.digital-garden-breadcrumbs-placeholder` element.
	 */
	function render(container) {
		var heading =
			container.getAttribute('data-heading') || 'Recently Viewed Notes';

		// Exclude the current page — it is already visible on screen.
		var items = getHistory().filter(function (n) {
			return n.url !== window.location.href;
		});

		if (!items.length) {
			container.style.display = 'none';
			return;
		}

		container.className = 'digital-garden-breadcrumbs';

		var html =
			'<div class="digital-garden-breadcrumb-title">' +
			escHtml(heading) +
			'</div><ul>';
		items.forEach(function (note) {
			html +=
				'<li><a href="' +
				escHtml(note.url) +
				'">' +
				escHtml(note.title) +
				'</a></li>';
		});
		html += '</ul>';

		container.innerHTML = html;
	}

	/**
	 * Escapes a plain-text string for safe insertion into HTML.
	 *
	 * @param {string} str
	 * @return {string}
	 */
	function escHtml(str) {
		var d = document.createElement('div');
		d.appendChild(document.createTextNode(String(str)));
		return d.innerHTML;
	}
});
