(function( blocks, element, blockEditor ) {
	var el = element.createElement;
	var RichText = blockEditor.RichText;

	blocks.registerBlockType( 'digital-garden/garden-title', {
			title: 'Garden Title',
			icon: 'heading',
			category: 'widgets',
			attributes: {
					content: {
							type: 'string',
							source: 'html',
							selector: 'h2'
					}
			},
			edit: function( props ) {
					return el(
							RichText,
							{
									tagName: 'h2',
									value: props.attributes.content,
									onChange: function( newContent ) {
											props.setAttributes( { content: newContent } );
									},
									placeholder: 'Enter Garden Title...'
							}
					);
			},
			save: function() {
					return null; // Server-rendered in PHP
			}
	});
})( window.wp.blocks, window.wp.element, window.wp.blockEditor );
