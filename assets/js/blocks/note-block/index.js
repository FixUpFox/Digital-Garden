(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { InnerBlocks, useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-block', {
    title: 'Note Block',
    icon: 'sticky',
    category: 'widgets',
    supports: {
        html: false,
        reusable: false,
    },
    parent: [ 'digital-garden/container' ],

    edit: function(props) {
      const blockProps = useBlockProps({
        style: props.attributes.style
      });

      const TEMPLATE = [
        [ 'digital-garden/note-title' ],
        [ 'digital-garden/note-content' ],
        [ 'digital-garden/note-tags' ],
        [ 'digital-garden/note-completeness' ],
        [ 'digital-garden/note-featured-image' ],
        [
          'core/columns', {}, [
            [ 'core/column', {}, [
              [ 'digital-garden/note-publish-date' ]
            ] ],
            [ 'core/column', {}, [
              [ 'digital-garden/note-modify-date' ]
            ] ]
          ]
        ]
      ];

      return el(
        'div',
        blockProps,
        el('p', {}, 'Note Block Layout: Arrange the fields below'),
        el(InnerBlocks, {
          template: TEMPLATE,
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
