(function (wp) {
	const { registerBlockType } = wp.blocks;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/note-completeness', {
		title: 'Completeness',
		icon: 'yes',
		category: 'widgets',
		supports: {
			html: false,
		},

		edit() {
			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = wp.blockEditor.useBlockProps();

			return el(
				'div',
				blockProps,
				el(
					'span',
					{ className: 'digital-garden-note-completeness' },
					__('Sprout', 'digital-garden'),
				),
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
