(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, RangeControl, TextControl } = wp.components;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/note-breadcrumbs', {
		title: __('Note Breadcrumbs', 'digital-garden'),
		icon: 'list-view',
		category: 'widgets',
		attributes: {
			heading: { type: 'string', default: 'Recently Viewed Notes' },
			maxSteps: { type: 'integer', default: 5 },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { heading, maxSteps } = attributes;

			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				className: 'digital-garden-breadcrumbs-editor',
			});

			return el(
				'nav',
				blockProps,
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{
							title: __('Breadcrumbs Settings', 'digital-garden'),
							initialOpen: true,
						},
						el(TextControl, {
							label: __('Heading', 'digital-garden'),
							value: heading,
							onChange: (val) => setAttributes({ heading: val }),
						}),
						el(RangeControl, {
							label: __('Maximum steps', 'digital-garden'),
							help: __(
								'How many visited notes to remember.',
								'digital-garden',
							),
							value: maxSteps,
							onChange: (val) => setAttributes({ maxSteps: val }),
							min: 1,
							max: 20,
						}),
					),
				),
				el(
					'p',
					{ className: 'digital-garden-breadcrumbs-editor__placeholder' },
					__(
						'Recently visited notes will appear here for each visitor, based on their browser history.',
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
