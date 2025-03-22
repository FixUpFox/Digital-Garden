(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/active-filter', {
      title: 'Active Filter',
      icon: 'visibility',
      category: 'widgets',
      parent: [ 'digital-garden/container' ],

      edit: function(props) {
          const blockProps = useBlockProps();
          return el('div', blockProps, 'Active Filter');
      },

      save: function() {
          return null;
      }
  });
})(window.wp);
