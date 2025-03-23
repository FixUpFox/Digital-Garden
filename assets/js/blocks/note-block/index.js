(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { InnerBlocks, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-block', {
    title: 'Note Block',
    icon: 'sticky',
    category: 'widgets',
    parent: [ 'digital-garden/container' ],

    attributes: {
      layoutStyle: { type: 'string', default: 'list' } // or 'grid', etc.
    },

    edit: function(props) {
      const blockProps = useBlockProps();
      const TEMPLATE = [
        [ 'digital-garden/note-title' ],
        [ 'digital-garden/note-tags' ],
        [ 'digital-garden/note-completeness' ],
        [ 'digital-garden/note-featured-image' ],
        [ 'digital-garden/note-publish-date' ],
        [ 'digital-garden/note-modify-date' ]
      ];

      return el(
        'div',
        blockProps,
        el('p', {}, 'Note Block Layout: Arrange the fields below'),
        el(InnerBlocks, {
          allowedBlocks: [
            'digital-garden/note-title',
            'digital-garden/note-tags',
            'digital-garden/note-completeness',
            'digital-garden/note-featured-image',
            'digital-garden/note-publish-date',
            'digital-garden/note-modify-date'
          ],
          template: TEMPLATE,
          templateLock: false
        })
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
