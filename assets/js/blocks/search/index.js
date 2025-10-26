(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/search', {
    title: 'Search',
    icon: 'search',
    category: 'widgets',
    parent: [ 'digital-garden/container' ],

    edit: function(props) {
      const blockProps = useBlockProps();
      return el('div', blockProps, 'Search Block');
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
