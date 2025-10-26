(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/active-filter', {
		title: __('Active Filter', 'digital-garden'),
		icon: 'visibility',
		category: 'widgets',
	parent: ['digital-garden/container', 'core/group', 'core/row'],

		edit: function ActiveFilterEdit() {
			const blockProps = useBlockProps({
				className: 'digital-garden-block-preview digital-garden-active-filter__preview',
			});

			return el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'digital-garden-active-filter', 'aria-hidden': 'true' },
					el(
						'select',
						{
							className: 'digital-garden-filter-select digital-garden-active-filter__select',
							'aria-label': __('Order notes by', 'digital-garden'),
						},
						[
							el('option', { value: 'published', key: 'published' }, __(
								'Recently published',
								'digital-garden'
							)),
							el('option', { value: 'modified', key: 'modified' }, __(
								'Recently updated',
								'digital-garden'
							)),
						]
					)
				)
			);
		},

		save: function () {
			return null;
		},
	});
})(window.wp);
