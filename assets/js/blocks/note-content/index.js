(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-content', {
    title: 'Note Content',
    icon: 'media-text',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    edit: function() {
      const blockProps = useBlockProps();
      return el('div', blockProps, 'Note Content (full post content)');
    },
    save: () => null
  });
})(window.wp);
