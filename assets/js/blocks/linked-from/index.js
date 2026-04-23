(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType('digital-garden/linked-from', {
		title: __('Linked From', 'digital-garden'),
		icon: 'admin-links',
		category: 'widgets',
		attributes: {},

		edit() {
			// eslint-disable-next-line react-hooks/rules-of-hooks
			const blockProps = useBlockProps({
				className: 'digital-garden-linked-from',
			});

			return el(
				'section',
				blockProps,
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
