(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, BlockControls, AlignmentToolbar } = wp.blockEditor;

	const { __ } = wp.i18n;

	const { ToolbarGroup, ToolbarButton } = wp.components;

	const el = wp.element.createElement;

	registerBlockType('digital-garden/note-title', {
		title: 'Note Title',
		icon: 'heading',
		category: 'widgets',
		attributes: {
			textAlign: { type: 'string', default: 'left' },
			level: { type: 'number', default: 3 },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { textAlign, level } = attributes;

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
						onChange(newAlign) {
							setAttributes({ textAlign: newAlign });
						},
					}),
					el(
						ToolbarGroup,
						{},
						[2, 3, 4, 5, 6].map(function (headingLevel) {
							return el(
								ToolbarButton,
								{
									label: 'H' + headingLevel,
									isPressed: level === headingLevel,
									onClick() {
										setAttributes({ level: headingLevel });
									},
									key: headingLevel,
								},
								'H' + headingLevel,
							);
						}),
					),
				),

				el(
					'h' + level,
					{
						style: { textAlign },
						className: 'digital-garden-note-title',
					},
					__('Example Note Title', 'digital-garden'),
				),
			);
		},
		save(props) {
			const { attributes } = props;
			const { textAlign, level } = attributes;
			const blockProps = useBlockProps.save({
				style: { textAlign },
			});

			return el('h' + level, blockProps, 'Example Note Title');
		},
	});
})(window.wp);
