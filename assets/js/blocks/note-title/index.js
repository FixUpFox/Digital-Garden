(function(wp) {
  const { registerBlockType } = wp.blocks;
  const {
    useBlockProps,
    BlockControls,
    AlignmentToolbar
  } = wp.blockEditor;

  const {
    ToolbarGroup,
    ToolbarButton
  } = wp.components;

  const el = wp.element.createElement;

  registerBlockType('digital-garden/note-title', {
    title: 'Note Title',
    icon: 'heading',
    category: 'widgets',
    parent: [ 'digital-garden/note-block' ],

    attributes: {
      textAlign: { type: 'string', default: 'left' },
      level: { type: 'number', default: 3 }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const { textAlign, level } = attributes;

      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        el(BlockControls, {},
          el(AlignmentToolbar, {
            value: textAlign,
            onChange: function(newAlign) {
              setAttributes({ textAlign: newAlign });
            }
          }),
          el(ToolbarGroup, {},
            [2, 3, 4, 5, 6].map(function(headingLevel) {
              return el(ToolbarButton, {
                label: 'H' + headingLevel,
                isPressed: level === headingLevel,
                onClick: function() {
                  setAttributes({ level: headingLevel });
                },
                key: headingLevel
              }, 'H' + headingLevel);
            })
          )
        ),

        el('h' + level, {
          style: { textAlign: textAlign },
          className: 'digital-garden-note-title-preview'
        }, 'Example Note Title')
      );
    },
    save: () => null
  });
})(window.wp);
