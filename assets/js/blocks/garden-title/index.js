(function(wp) {
  const { registerBlockType } = wp.blocks;
  const {
    RichText,
    BlockControls,
    AlignmentToolbar,
    useBlockProps
  } = wp.blockEditor;

  const {
    ToolbarGroup,
    ToolbarButton
  } = wp.components;

  const el = wp.element.createElement;

  registerBlockType('digital-garden/garden-title', {
    title: 'Garden Title',
    icon: 'heading',
    category: 'widgets',
    parent: [ 'digital-garden/container' ],

    attributes: {
      content: { type: 'string' },
      textAlign: { type: 'string', default: 'left' },
      level: { type: 'number', default: 2 }
    },

    edit: function(props) {
      const { attributes, setAttributes } = props;
      const { content, textAlign, level } = attributes;

      const blockProps = useBlockProps();

      return el(
        'div',
        blockProps,
        // Block Controls Toolbar
        el(BlockControls, {},
          el(AlignmentToolbar, {
            value: textAlign,
            onChange: function(newAlign) {
              setAttributes({ textAlign: newAlign });
            }
          }),
          el(ToolbarGroup, {},
            [1, 2, 3, 4, 5, 6].map(function(headingLevel) {
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

        // RichText Field
        el(RichText, {
          tagName: 'h' + level,
          className: 'digital-garden-title',
          style: { textAlign: textAlign },
          value: content,
          onChange: function(newContent) {
            setAttributes({ content: newContent });
          },
          placeholder: 'Enter garden title...'
        })
      );
    },

    save: function() {
      return null;
    }
  });
})(window.wp);
