(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, RangeControl } = wp.components;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/related-notes', {
		title: __('Related Notes', 'digital-garden'),
		icon: 'networking',
		category: 'widgets',
		attributes: {
			maxItems: { type: 'integer', default: 5 },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { maxItems } = attributes;

			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				className: 'digital-garden-related-notes',
			});

			return el(
				'section',
				blockProps,
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{
							title: __('Related Notes Settings', 'digital-garden'),
							initialOpen: true,
						},
						el(RangeControl, {
							label: __('Maximum items', 'digital-garden'),
							value: maxItems,
							onChange: (val) => setAttributes({ maxItems: val }),
							min: 1,
							max: 20,
						}),
					),
				),
				el(
					'p',
					{ className: 'digital-garden-related-notes__placeholder' },
					__(
						'Related notes will appear here based on shared tags and backlinks.',
						'digital-garden',
					),
				),
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
