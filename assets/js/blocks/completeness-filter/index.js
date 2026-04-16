(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/completeness-filter', {
		title: __('Completeness Filter', 'digital-garden'),
		icon: 'yes-alt',
		category: 'widgets',
		parent: [
			'digital-garden/container',
			'core/group',
			'core/row',
			'core/column',
		],

		edit: function CompletenessFilterEdit() {
			const blockProps = useBlockProps({
				className:
					'digital-garden-block-preview digital-garden-completeness-filter__preview',
			});

			const localized = window.digitalGardenCompleteness || {};
			const localizedOptions = Array.isArray(localized.options)
				? localized.options
				: [];
			const options =
				localizedOptions.length > 0
					? localizedOptions
					: [
							{ value: 'seedling', label: __('Seedling', 'digital-garden') },
							{ value: 'sprout', label: __('Sprout', 'digital-garden') },
							{ value: 'sapling', label: __('Sapling', 'digital-garden') },
							{ value: 'evergreen', label: __('Evergreen', 'digital-garden') },
						];

			const allLabel =
				localized.allLabel || __('Completeness', 'digital-garden');
			const ariaLabel =
				localized.ariaLabel ||
				__('Filter notes by completeness', 'digital-garden');

			return el(
				'div',
				blockProps,
				el(
					'div',
					{
						className: 'digital-garden-completeness-filter',
						'aria-hidden': 'true',
					},
					el(
						'select',
						{
							className: 'digital-garden-filter-select',
							'aria-label': ariaLabel,
						},
						[
							el('option', { value: '', key: 'all' }, allLabel),
							...options.map((option) =>
								el(
									'option',
									{ value: option.value, key: option.value },
									option.label,
								),
							),
						],
					),
				),
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
