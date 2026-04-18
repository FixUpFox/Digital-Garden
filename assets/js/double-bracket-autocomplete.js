/**
 * Double-bracket wikilink autocomplete for the note block editor.
 *
 * Activates when '[[' is typed and searches published notes via the REST
 * API. Selecting an existing note inserts [[Note Title]]. Selecting the
 * "Create draft" option inserts [[New Title]], and the server-side
 * process_double_brackets() hook creates the draft stub when the note is saved.
 *
 * Enqueued only on the 'note' post type editor screen via
 * Digital_Garden_Blocks::__construct().
 *
 * @param {Object} wp The global wp object provided by WordPress.
 */
(function (wp) {
	if (!wp || !wp.hooks || !wp.element || !wp.apiFetch) {
		return;
	}

	var addFilter = wp.hooks.addFilter;
	var el = wp.element.createElement;

	var doubleBracketCompleter = {
		name: 'digital-garden-double-bracket',

		// Scopes the dropdown's wrapper element for CSS targeting.
		className: 'digital-garden-double-bracket-completer',

		// Two-character trigger — activates after the user types '[['.
		triggerPrefix: '[[',

		// Debounce REST requests so we don't fire on every keystroke.
		isDebounced: true,

		/**
		 * Fetches published notes matching the current query.
		 *
		 * Published notes are fetched so the autocomplete doesn't surface
		 * draft stubs that aren't ready to link to. A "Create draft" option
		 * is always appended when no exact title match exists — even when the
		 * API request fails — so the user can always create a new draft stub.
		 *
		 * Note: spaces are intentionally allowed in the query because note
		 * titles commonly contain them (unlike hashtags).
		 *
		 * @param {string} query Text typed after the '[[' trigger.
		 * @return {Promise<Array>} Resolved list of option objects.
		 */
		options: async function (query) {
			if (!query) {
				return [];
			}

			let notes = [];
			try {
				const result = await wp.apiFetch({
					path:
						'/wp/v2/note?search=' +
						encodeURIComponent(query) +
						'&per_page=10',
				});
				if (Array.isArray(result)) {
					// Only surface published notes — draft stubs aren't ready to link to.
					notes = result.filter(function (note) {
						return note.status === 'publish';
					});
				}
			} catch {
				// API failure — fall through so "Create draft" still appears.
			}

			const options = notes.map(function (note) {
				// title.raw is the plain-text title; title.rendered may
				// contain HTML entities and is less safe to embed in [[…]].
				return {
					title: note.title.raw || note.title.rendered,
					isNew: false,
				};
			});

			// Only show "Create draft" when the typed text doesn't exactly
			// match an existing published note title.
			const exactMatch = notes.some(function (n) {
				const title = n.title.raw || n.title.rendered;
				return title.toLowerCase() === query.toLowerCase();
			});

			if (!exactMatch) {
				options.push({ title: query, isNew: true });
			}

			return options;
		},

		/**
		 * Renders the dropdown label for each option.
		 *
		 * "Create draft" entries are styled distinctly (see digital-garden-block-editor.css)
		 * and use color: inherit so they remain readable when the row is highlighted.
		 *
		 * @param {Object} option Option object with title and isNew properties.
		 * @return {Element} React element for the dropdown label.
		 */
		getOptionLabel: function (option) {
			if (option.isNew) {
				return el(
					'span',
					{ className: 'digital-garden-double-bracket-completer__create' },
					'Create draft ',
					el('strong', {}, option.title),
				);
			}
			return el('span', {}, option.title);
		},

		// Used by Gutenberg's client-side filter to narrow results as the
		// user types, before the debounced REST request returns.
		// @param {Object} option The option object.
		// @return {Array<string>} Keywords to match against the current query.
		getOptionKeywords: function (option) {
			return [option.title];
		},

		// Replaces the '[[query' trigger text with '[[Title]]' in the editor.
		// The full '[[' prefix is included because Gutenberg substitutes the
		// entire trigger+query region with this return value.
		// @param {Object} option The selected option object.
		// @return {string} The wikilink text to insert in place of the trigger+query.
		getOptionCompletion: function (option) {
			return '[[' + option.title + ']]';
		},
	};

	// Remove any existing [[ completer (e.g. a core link-search completer) so
	// ours takes precedence, then prepend it so it runs before other triggers.
	addFilter(
		'editor.Autocomplete.completers',
		'digital-garden/double-bracket-completer',
		function (completers) {
			const without = completers.filter(function (c) {
				return c.triggerPrefix !== '[[';
			});
			return [doubleBracketCompleter].concat(without);
		},
	);
})(window.wp);
