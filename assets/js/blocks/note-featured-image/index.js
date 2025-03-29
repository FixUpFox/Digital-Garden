(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-featured-image', {
    title: 'Featured Image',
    icon: 'format-image',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        'Featured image will be rendered here in the front-end.'
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
