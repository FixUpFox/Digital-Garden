(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { RichText, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/garden-title', {
      title: 'Garden Title',
      icon: 'heading',
      category: 'widgets',
      parent: [ 'digital-garden/container' ],

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
                  tagName: 'h2',
                  className: 'digital-garden-title',
                  value: attributes.content || '',
                  onChange: ( newContent ) => setAttributes( { content: newContent } ),
                  placeholder: 'Enter garden title...'
              })
          );
      },

      save: function() {
          return null;
      }
  });
})(window.wp);
