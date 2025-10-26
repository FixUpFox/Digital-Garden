(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-tags', {
    title: 'Tags',
    icon: 'tag',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      content: { type: 'string' }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        'Tags will be rendered here in the front-end.'
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
