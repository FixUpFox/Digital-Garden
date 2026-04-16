(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, BlockControls, AlignmentToolbar } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/note-content', {
		title: 'Note Content',
		icon: 'media-text',
		category: 'widgets',
		attributes: {
			postId: { type: 'number' },
			textAlign: { type: 'string', default: 'left' },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { textAlign } = attributes;

			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				style: { textAlign },
			});

			return el(
				'div',
				blockProps,
				el(
					BlockControls,
					{},
					el(AlignmentToolbar, {
						value: textAlign,
						onChange: (newAlign) => setAttributes({ textAlign: newAlign }),
					}),
				),
				el('div', { className: 'digital-garden-note-content' }, [
					el(
						'p',
						{ key: 'p1' },
						__(
							'This is a short excerpt from your note. Use this space to introduce the idea you are exploring.',
							'digital-garden',
						),
					),
					el(
						'p',
						{ className: 'digital-garden-note-content__more', key: 'p2' },
						__('Continue reading →', 'digital-garden'),
					),
				]),
			);
		},
		save(props) {
			const blockProps = useBlockProps.save({
				style: { textAlign: props.attributes.textAlign },
			});
			return el('div', blockProps, 'Note Content (full post content)');
		},
	});
})(window.wp);
