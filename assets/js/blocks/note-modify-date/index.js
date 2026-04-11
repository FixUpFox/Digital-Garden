(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;
  const { __ } = wp.i18n;

  registerBlockType('digital-garden/note-modify-date', {
    title: 'Modify Date',
    icon: 'update',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      textAlign: { type: 'string', default: 'left' },
      fontWeight: { type: 'string', default: 'normal' }
    },

    edit: function() {
      const blockProps = useBlockProps({
        className: 'digital-garden-note-modify-date',
      });

      return el(
        'div',
        blockProps,
        __('Updated June 02, 2024', 'digital-garden')
      );
    },

		save: function() {
      return null;
    }
  });
})(window.wp);
