(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { RichText, BlockControls, AlignmentToolbar, useBlockProps } =
		wp.blockEditor;

	const { ToolbarGroup, ToolbarButton } = wp.components;

	const el = wp.element.createElement;

	registerBlockType('digital-garden/garden-title', {
		title: 'Garden Title',
		icon: 'heading',
		category: 'widgets',
		parent: [
			'digital-garden/container',
			'core/group',
			'core/row',
			'core/column',
		],

		attributes: {
			content: { type: 'string' },
			textAlign: { type: 'string', default: 'left' },
			level: { type: 'number', default: 2 },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { content, textAlign, level } = attributes;

			const blockProps = useBlockProps();

			return el(
				'div',
				blockProps,
				// Block Controls Toolbar
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
						[1, 2, 3, 4, 5, 6].map(function (headingLevel) {
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

				// RichText Field
				el(RichText, {
					tagName: 'h' + level,
					className: 'digital-garden-title',
					style: { textAlign },
					value: content,
					onChange(newContent) {
						setAttributes({ content: newContent });
					},
					placeholder: 'Enter garden title...',
				}),
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
