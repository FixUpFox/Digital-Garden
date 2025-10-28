(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { InnerBlocks, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/container', {
    title: 'Digital Garden Container',
    icon: 'index-card',
    category: 'widgets',

    edit: function(props) {
      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        el( InnerBlocks, {
          allowedBlocks: [
            'digital-garden/garden-title',
            'digital-garden/tag-filter',
            'digital-garden/completeness-filter',
            'digital-garden/active-filter',
            'digital-garden/search',
            'digital-garden/note-block',
            'core/group',
            'core/row',
          ],
          templateInsertUpdatesSelection: true,
          template: [
            [ 'digital-garden/garden-title' ],
            [ 'digital-garden/tag-filter' ],
            [
              'core/group',
              { className: 'digital-garden-archive-filters' },
              [
                [ 'digital-garden/active-filter' ],
                [ 'digital-garden/completeness-filter' ],
                [ 'digital-garden/search' ],
              ]
            ],
            [ 'digital-garden/note-block' ],
          ],
          templateLock: false
        })
      );
    },

    save: function() {
      const blockProps = useBlockProps.save();
      return el(
        'div',
        blockProps,
        el( InnerBlocks.Content )
      );
    }
  });
})(window.wp);
