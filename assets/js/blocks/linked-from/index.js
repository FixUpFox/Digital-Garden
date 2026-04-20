(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl } = wp.components;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/linked-from', {
		title: __('Linked From', 'digital-garden'),
		icon: 'admin-links',
		category: 'widgets',
		attributes: {
			heading: { type: 'string', default: 'Linked From' },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { heading } = attributes;

			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				className: 'digital-garden-linked-from',
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
							title: __('Linked From Settings', 'digital-garden'),
							initialOpen: true,
						},
						el(TextControl, {
							label: __('Heading', 'digital-garden'),
							value: heading,
							onChange: (val) => setAttributes({ heading: val }),
						}),
					),
				),
				el(
					'h2',
					{ className: 'digital-garden-linked-from__heading' },
					heading,
				),
				el(
					'p',
					{ className: 'digital-garden-linked-from__placeholder' },
					__(
						'Notes that link to this note will appear here.',
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
