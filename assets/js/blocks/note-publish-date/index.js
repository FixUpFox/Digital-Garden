(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps } = wp.blockEditor;
	const el = wp.element.createElement;
	const { __ } = wp.i18n;

	registerBlockType("digital-garden/note-publish-date", {
		title: "Publish Date",
		icon: "calendar",
		category: "widgets",
		attributes: {
			textAlign: { type: "string", default: "left" },
			fontWeight: { type: "string", default: "normal" },
		},

		edit: function () {
			const blockProps = useBlockProps({
				className: "digital-garden-note-publish-date",
			});

			return el(
				"div",
				blockProps,
				__("Published May 12, 2024", "digital-garden"),
			);
		},

		save: function () {
			return null;
		},
	});
})(window.wp);
