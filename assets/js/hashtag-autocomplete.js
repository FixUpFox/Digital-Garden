/**
 * Hashtag autocomplete for the note block editor.
 *
 * Registers a Gutenberg autocomplete completer that triggers on '#' and
 * suggests existing note_tag terms. New tags are created automatically by
 * the server-side process_hashtags_to_tags hook when the note is saved —
 * no extra API call is needed here for tag creation.
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

	var hashtagCompleter = {
		name: 'digital-garden-hashtag',

		// Scopes the dropdown's wrapper element for CSS targeting.
		className: 'digital-garden-hashtag-completer',

		// Activates this completer whenever '#' is typed inline.
		triggerPrefix: '#',

		// Lets WordPress debounce the options() call so we don't fire a
		// REST request on every single keystroke.
		isDebounced: true,

		/**
		 * Fetches matching note_tag terms for the current query.
		 *
		 * Returns [] (closing the dropdown) when the query is empty or
		 * contains a space — spaces are not valid in hashtags and the empty
		 * result causes Gutenberg to hide the autocomplete panel.
		 *
		 * Results are ordered by usage count so frequently-used tags rise
		 * to the top. A "Create #tag" option is appended when the typed
		 * text has no exact match, letting users coin new tags without
		 * leaving the editor.
		 *
		 * @param {string} query Text typed after the '#' trigger.
		 * @return {Promise<Array>} Resolved list of option objects.
		 */
		options: async function (query) {
			if (!query || query.indexOf(' ') !== -1) {
				return [];
			}

			try {
				const terms = await wp.apiFetch({
					path:
						'/wp/v2/note_tag?search=' +
						encodeURIComponent(query) +
						'&per_page=10&orderby=count&order=desc',
				});

				const options = terms.map(function (term) {
					return { name: term.name, isNew: false };
				});

				// Only offer "Create" when the typed text isn't already
				// an exact tag name — avoids a duplicate entry.
				const exactMatch = terms.some(function (t) {
					return t.name.toLowerCase() === query.toLowerCase();
				});

				if (!exactMatch) {
					options.push({ name: query, isNew: true });
				}

				return options;
			} catch {
				return [];
			}
		},

		/**
		 * Renders the label shown in the dropdown for each option.
		 *
		 * "Create" entries use italic styling (see digital-garden-block-editor.css)
		 * with color: inherit so the text stays readable whether the row is
		 * highlighted (white text on blue) or not (dark text on white).
		 *
		 * @param {Object} option The option object with name and isNew properties.
		 * @return {Element} React element for the dropdown label.
		 */
		getOptionLabel: function (option) {
			if (option.isNew) {
				return el(
					'span',
					{ className: 'digital-garden-hashtag-completer__create' },
					'Create ',
					el('strong', {}, '#' + option.name),
				);
			}
			return el('span', {}, '#' + option.name);
		},

		// Used by Gutenberg's built-in search to filter options client-side
		// as the user continues typing before the debounced fetch returns.
		// @param {Object} option The option object.
		// @return {Array<string>} Keywords to match against the current query.
		getOptionKeywords: function (option) {
			return [option.name];
		},

		// Replaces the '#query' trigger text with '#tagname' in the editor.
		// The full '#' prefix is included because Gutenberg substitutes the
		// entire trigger+query region with this return value.
		// @param {Object} option The selected option object.
		// @return {string} The text to insert in place of the trigger+query.
		getOptionCompletion: function (option) {
			return '#' + option.name;
		},
	};

	// Append to the existing completers array rather than replacing it so
	// any other registered completers (e.g. core slash commands) still work.
	addFilter(
		'editor.Autocomplete.completers',
		'digital-garden/hashtag-completer',
		function (completers) {
			return completers.concat([hashtagCompleter]);
		},
	);
})(window.wp);
