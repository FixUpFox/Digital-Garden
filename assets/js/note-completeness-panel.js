(function (wp) {
	const { registerPlugin } = wp.plugins;
	const { PluginDocumentSettingPanel } = wp.editor;
	const { SelectControl } = wp.components;
	const { useSelect, useDispatch } = wp.data;
	const { __ } = wp.i18n;
	const el = wp.element.createElement;

	const options = (window.digitalGardenCompleteness || {}).options || [];

	function NoteCompletenessPanel() {
		const meta = useSelect(function (select) {
			return select('core/editor').getEditedPostAttribute('meta') || {};
		});

		const { editPost } = useDispatch('core/editor');

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'digital-garden-completeness',
				title: __('Note Completeness', 'digital-garden'),
				className: 'digital-garden-completeness-panel',
			},
			el(SelectControl, {
				value: meta.note_completeness || '',
				options: options,
				onChange: function (value) {
					editPost({ meta: { note_completeness: value } });
				},
				__nextHasNoMarginBottom: true,
			}),
		);
	}

	registerPlugin('digital-garden-completeness', {
		render: NoteCompletenessPanel,
	});
})(window.wp);
