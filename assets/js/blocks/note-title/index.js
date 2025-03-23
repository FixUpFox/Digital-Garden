(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-title', {
    title: 'Note Title',
    icon: 'heading',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      textAlign: { type: 'string', default: 'left' },
      fontSize: { type: 'string', default: 'normal' }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el('div',
        blockProps,
        el('h3', {
          style: {
            textAlign: attributes.textAlign,
            fontSize: attributes.fontSize === 'large' ? '2rem' : '1rem'
          }
        }, 'Example Note Title')
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
