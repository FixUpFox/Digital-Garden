(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { InnerBlocks, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-block', {
      title: 'Note Block',
      icon: 'sticky',
      category: 'widgets',
      parent: [ 'digital-garden/container' ],

      edit: function(props) {
          const blockProps = useBlockProps();
          return el(
              'div',
              blockProps,
              el( InnerBlocks, {
                  allowedBlocks: [
                      'digital-garden/note-title',
                      'digital-garden/note-completeness',
                      'digital-garden/note-tags',
                      'digital-garden/note-featured-image',
                      'digital-garden/note-publish-date',
                      'digital-garden/note-modify-date'
                  ]
              })
          );
      },

      save: function() {
          const blockProps = useBlockProps.save();
          return el('div', blockProps, el( InnerBlocks.Content ));
      }
  });
})(window.wp);
