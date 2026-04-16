(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { InnerBlocks, useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/note-block', {
		title: 'Note Block',
		icon: 'sticky',
		category: 'widgets',
		supports: {
			html: false,
			reusable: false,
		},
		parent: [
			'digital-garden/container',
			'core/group',
			'core/row',
			'core/column',
		],

		edit(props) {
			const blockProps = useBlockProps({
				style: props.attributes.style,
			});

			const TEMPLATE = [
				['digital-garden/note-title'],
				['digital-garden/note-content'],
				['digital-garden/note-tags'],
				['digital-garden/note-completeness'],
				['digital-garden/note-featured-image'],
				[
					'core/columns',
					{},
					[
						['core/column', {}, [['digital-garden/note-publish-date']]],
						['core/column', {}, [['digital-garden/note-modify-date']]],
					],
				],
			];

			return el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'digital-garden-note digital-garden-note--preview' },
					el(
						'p',
						{ className: 'digital-garden-note-preview__hint' },
						__(
							'Adjust the blocks below to change how each note is displayed.',
							'digital-garden',
						),
					),
					el(InnerBlocks, {
						template: TEMPLATE,
						templateLock: false,
					}),
				),
			);
		},
		save() {
			const blockProps = useBlockProps.save();
			return el('div', blockProps, el(InnerBlocks.Content));
		},
	});
})(window.wp);
