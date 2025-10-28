(function(wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps } = wp.blockEditor;
  const el = wp.element.createElement;
  const { __ } = wp.i18n;

  registerBlockType('digital-garden/note-tags', {
    title: 'Tags',
    icon: 'tag',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      content: { type: 'string' }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        el(
          'div',
          { className: 'digital-garden-note-tags' },
          [
            el('span', { className: 'note-tag', key: 'tag1' }, __('gardening', 'digital-garden')),
            el('span', { className: 'note-tag', key: 'tag2' }, __('learning', 'digital-garden')),
            el('span', { className: 'note-tag', key: 'tag3' }, __('reference', 'digital-garden'))
          ]
        )
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
