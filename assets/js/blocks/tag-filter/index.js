(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { createElement: el, useMemo } = wp.element;
	const { useSelect } = wp.data;
	const { Spinner, PanelBody, RadioControl } = wp.components;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/tag-filter', {
		title: __('Tag Filter', 'digital-garden'),
		icon: 'filter',
		category: 'widgets',
		parent: [
			'digital-garden/container',
			'core/group',
			'core/row',
			'core/column',
		],

		attributes: {
			sortOrder: { type: 'string', default: 'alphabetical' },
		},

		edit: function TagFilterEdit({ attributes, setAttributes }) {
			const { sortOrder } = attributes;

			const blockProps = useBlockProps({
				className:
					'digital-garden-block-preview digital-garden-tag-filter__preview',
			});

			const query = useMemo(
				() => ({
					per_page: 50,
					hide_empty: false,
					orderby: 'name',
					order: 'asc',
				}),
				[],
			);

			const { terms, isResolving } = useSelect(
				(select) => {
					const coreStore = select('core');
					const records = coreStore.getEntityRecords(
						'taxonomy',
						'note_tag',
						query,
					);
					const resolving = !coreStore.hasFinishedResolution(
						'getEntityRecords',
						['taxonomy', 'note_tag', query],
					);

					return {
						terms: records,
						isResolving: resolving,
					};
				},
				[query],
			);

			const sortedTerms = useMemo(() => {
				if (!Array.isArray(terms)) {
					return terms;
				}
				if (sortOrder === 'count') {
					return [...terms].sort((a, b) => (b.count || 0) - (a.count || 0));
				}
				return [...terms].sort((a, b) => a.name.localeCompare(b.name));
			}, [terms, sortOrder]);

			let content;

			if (isResolving && !Array.isArray(terms)) {
				content = el(
					'div',
					{ className: 'digital-garden-filter-placeholder' },
					el(Spinner, {
						className: 'digital-garden-filter-placeholder__spinner',
					}),
					el(
						'span',
						{ className: 'digital-garden-filter-placeholder__label' },
						__('Loading tags…', 'digital-garden'),
					),
				);
			} else if (Array.isArray(sortedTerms) && sortedTerms.length) {
				content = el(
					'ul',
					{
						className:
							'digital-garden-filter-list digital-garden-filter-list--tags',
					},
					sortedTerms.map((term) =>
						el(
							'li',
							{
								className: 'digital-garden-filter-list__item',
								key: term.id || term.slug,
							},
							el(
								'span',
								{ className: 'digital-garden-filter-button' },
								el(
									'span',
									{ className: 'digital-garden-filter-button__label' },
									term.name,
								),
								el(
									'span',
									{ className: 'digital-garden-filter-count' },
									`(${term.count || 0})`,
								),
							),
						),
					),
				);
			} else {
				content = el(
					'p',
					{ className: 'digital-garden-filter__empty' },
					__('No tags available yet.', 'digital-garden'),
				);
			}

			return el(
				'div',
				blockProps,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __('Sort Order', 'digital-garden'), initialOpen: true },
						el(RadioControl, {
							label: __('Sort tags by', 'digital-garden'),
							selected: sortOrder,
							options: [
								{
									label: __('Alphabetical', 'digital-garden'),
									value: 'alphabetical',
								},
								{ label: __('Note count', 'digital-garden'), value: 'count' },
							],
							onChange(value) {
								setAttributes({ sortOrder: value });
							},
						}),
					),
				),
				el(
					'fieldset',
					{ className: 'digital-garden-tag-filter', 'aria-hidden': 'true' },
					el('legend', null, __('Filter by tags', 'digital-garden')),
					content,
				),
			);
		},

		save() {
			return null;
		},
	});
})(window.wp);
