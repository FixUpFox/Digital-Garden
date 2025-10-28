(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;
  const { __ } = wp.i18n;

  registerBlockType('digital-garden/note-completeness', {
    title: 'Completeness',
    icon: 'yes',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    supports: {
      html: false,
    },

    edit: function(props) {
      const blockProps = wp.blockEditor.useBlockProps();

      return el(
        'div',
        blockProps,
        el(
          'span',
          { className: 'digital-garden-note-completeness' },
          __('Sprout', 'digital-garden')
        )
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
