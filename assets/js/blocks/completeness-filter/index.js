(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;

  registerBlockType('digital-garden/completeness-filter', {
    title: 'Completeness Filter',
    icon: 'yes-alt',
    category: 'widgets',
    parent: [ 'digital-garden/container' ],

    edit: function(props) {
      const blockProps = useBlockProps();
      return el('div', blockProps, 'Completeness Filter');
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
