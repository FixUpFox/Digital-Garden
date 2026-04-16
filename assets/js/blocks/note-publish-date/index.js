(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl } = wp.components;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	const sitePublishDateFormat = wp.date.getSettings().formats.date || 'F j, Y';

	registerBlockType('digital-garden/note-publish-date', {
		title: 'Publish Date',
		icon: 'calendar',
		category: 'widgets',
		attributes: {
			prefix: { type: 'string', default: 'Published' },
			dateFormat: { type: 'string', default: sitePublishDateFormat },
		},

		edit(props) {
			const { attributes, setAttributes } = props;
			const { prefix, dateFormat } = attributes;

			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				className: 'digital-garden-note-publish-date',
			});

			let previewDate;
			try {
				previewDate = wp.date.format(dateFormat, new Date());
			} catch (e) {
				previewDate = new Date().toLocaleDateString();
			}

			const previewText = prefix
				? prefix + '\u00a0' + previewDate
				: previewDate;

			return el(
				'div',
				blockProps,
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{
							title: __('Date Settings', 'digital-garden'),
							initialOpen: true,
						},
						el(TextControl, {
							label: __('Prefix', 'digital-garden'),
							value: prefix,
							onChange: (val) => setAttributes({ prefix: val }),
						}),
						el(TextControl, {
							label: __('Date Format', 'digital-garden'),
							value: dateFormat,
							help: __(
								'PHP date format string. Example: F j, Y → May 12, 2024',
								'digital-garden',
							),
							onChange: (val) => setAttributes({ dateFormat: val }),
						}),
					),
				),
				previewText,
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
