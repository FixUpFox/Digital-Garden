( function( blocks, element, blockEditor ) {
		var el = element.createElement;
		var InnerBlocks = blockEditor.InnerBlocks;

		blocks.registerBlockType( 'digital-garden/container', {
				title: 'Digital Garden Container',
				icon: 'index-card',
				category: 'widgets',

				edit: function( props ) {
						return el(
								'div',
								{ className: 'digital-garden-container' },
								el( InnerBlocks, {
										allowedBlocks: [
												'digital-garden/garden-title',
												'digital-garden/tag-filter',
												'digital-garden/completeness-filter',
												'digital-garden/active-filter',
												'digital-garden/search',
												'digital-garden/note-block'
										],
										template: [
												[ 'digital-garden/garden-title' ],
												[ 'digital-garden/tag-filter' ],
												[ 'digital-garden/completeness-filter' ],
												[ 'digital-garden/active-filter' ],
												[ 'digital-garden/search' ],
												[ 'digital-garden/note-block' ]
										],
										templateLock: false  // Optional: Set to 'all' to prevent removing/reordering
								})
						);
				},

				save: function() {
						return el(
								'div',
								{ className: 'digital-garden-container' },
								el( InnerBlocks.Content )
						);
				}

		});
})( window.wp.blocks, window.wp.element, window.wp.blockEditor );
