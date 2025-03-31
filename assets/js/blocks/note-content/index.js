(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps, BlockControls, AlignmentToolbar } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-content', {
    title: 'Note Content',
    icon: 'media-text',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      postId: { type: 'number' },
      textAlign: { type: 'string', default: 'left' }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const { textAlign } = attributes;

      const blockProps = useBlockProps({
        style: { textAlign: textAlign }
      });

      return el(
        'div',
        blockProps,
        el(BlockControls, {},
          el(AlignmentToolbar, {
            value: textAlign,
            onChange: (newAlign) => setAttributes({ textAlign: newAlign })
          })
        ),
        'Note Content (full post content)'
      );
    },
    save: function(props) {
      const blockProps = useBlockProps.save({
        style: { textAlign: props.attributes.textAlign }
      });
      return el('div', blockProps, 'Note Content (full post content)');
    }
  });
})(window.wp);
