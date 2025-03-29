(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { RichText, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

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

      return wp.element.createElement(
        'div',
        blockProps,
        'Completeness will be rendered here in the front-end.'
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
