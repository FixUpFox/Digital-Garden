(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-publish-date', {
    title: 'Publish Date',
    icon: 'calendar',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      textAlign: { type: 'string', default: 'left' },
      fontSize: { type: 'number', default: 16 },
      fontWeight: { type: 'string', default: 'normal' }
    },

    edit: function() {
      const blockProps = useBlockProps({
        className: 'digital-garden-note-publish-date',
      });

      return el(
        'div',
        blockProps,
        'Publish Date Placeholder'
      );
    },

		save: function() {
      return null;
    }
  });
})(window.wp);
