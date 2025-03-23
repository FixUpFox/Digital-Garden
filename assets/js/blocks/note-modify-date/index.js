(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { RichText, MediaUpload, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-modify-date', {
    title: 'Modify Date',
    icon: 'update',
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
        el( RichText, {
          tagName: 'div',
          className: 'digital-garden-note-modify-date',
          value: attributes.content || '',
          onChange: ( newContent ) => setAttributes( { content: newContent } ),
          placeholder: 'Enter Modify Date...'
        })
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
