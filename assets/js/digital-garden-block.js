(function (blocks, element, editor, components, data) {
	const { registerBlockType } = blocks;
	const { createElement } = element;
	const { useSelect } = data;

	registerBlockType('digital-garden/archive', {
		title: 'Digital Garden Archive',
		icon: 'book',
		category: 'widgets',
		edit: function () {
			const tags = (typeof digitalGardenData !== 'undefined') ? digitalGardenData.tags : [];
			return createElement(
				'div',
				null,
				[
					createElement(
						'p',
						null,
						'Digital Garden Archive - This block displays an archive of all notes.'
					),
					tags.length > 0 &&
					createElement(
						'div',
						{ className: 'digital-garden-tags' },
						tags.map(tag =>
							createElement(
								'button',
								{ className: 'digital-garden-tag-button', 'data-tag': tag.slug },
								tag.name
							)
						),
						createElement(
							'button',
							{ className: 'digital-garden-clear-button' },
							'Clear'
						)
					)
				]
			);
		},
		save: function () {
			return null; // Rendered server-side
		}
	});
})(window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components, window.wp.data);
