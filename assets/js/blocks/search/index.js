(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/search', {
		title: __('Search', 'digital-garden'),
		icon: 'search',
		category: 'widgets',
	parent: ['digital-garden/container', 'core/group', 'core/row'],

		edit: function SearchEdit() {
			const blockProps = useBlockProps({
				className: 'digital-garden-block-preview digital-garden-search__preview',
			});

			return el(
				'div',
				blockProps,
				el(
					'form',
					{
						className: 'digital-garden-search-form',
						role: 'search',
					},
					[
						el(
							'label',
							{
								className: 'digital-garden-search__label',
								htmlFor: 'digital-garden-search-preview-field',
							},
							__('Search notes', 'digital-garden')
						),
						el('input', {
							id: 'digital-garden-search-preview-field',
							className: 'digital-garden-search__field',
							type: 'search',
							placeholder: __('Search notes…', 'digital-garden'),
							readOnly: true,
						}),
						el(
							'button',
							{ className: 'digital-garden-search__submit', type: 'button' },
							__('Search', 'digital-garden')
						),
					]
				)
			);
		},

		save: function () {
			return null;
		},
	});
})(window.wp);
