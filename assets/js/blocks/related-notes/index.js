(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, RangeControl, TextControl } = wp.components;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/related-notes', {
		title: __('Related Notes', 'digital-garden'),
		icon: 'networking',
		category: 'widgets',
		attributes: {
			maxItems: { type: 'integer', default: 5 },
			heading: { type: 'string', default: 'Related Notes' },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { maxItems, heading } = attributes;

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
						el(TextControl, {
							label: __('Heading', 'digital-garden'),
							value: heading,
							onChange: (val) => setAttributes({ heading: val }),
						}),
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
					'h2',
					{ className: 'digital-garden-related-notes__heading' },
					heading,
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
