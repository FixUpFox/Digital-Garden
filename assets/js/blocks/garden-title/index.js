(function( blocks, element, blockEditor ) {
  var el = element.createElement;
  var RichText = blockEditor.RichText;

  blocks.registerBlockType( 'digital-garden/garden-title', {
    title: 'Garden Title',
    icon: 'heading',
    category: 'widgets',
    parent: [ 'digital-garden/container' ],
    attributes: {
      content: {
        type: 'string'
      }
    },
    edit: function( props ) {
      const { attributes, setAttributes } = props;
      const { content } = attributes;

      return el( 'div', {},
        el( RichText, {
          tagName: 'h2',
          className: 'digital-garden-title',
          value: content || "",
          onChange: function( newContent ) {
          console.log("Updating content to:", newContent);
            setAttributes( { content: newContent } );
          },
          placeholder: 'Enter Garden Title...'
        })
      );
    },
    save: function() {
      return null; // Server-rendered in PHP
    }
  });
})( window.wp.blocks, window.wp.element, window.wp.blockEditor );
