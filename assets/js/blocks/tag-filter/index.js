(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/tag-filter', {
      title: 'Tag Filter',
      icon: 'filter',
      category: 'widgets',
      parent: [ 'digital-garden/container' ],

      edit: function(props) {
          const blockProps = useBlockProps();
          return el('div', blockProps, 'Tag Filter');
      },

      save: function() {
          return null;
      }
  });
})(window.wp);
