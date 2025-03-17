
(function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'digital-garden/note-featured-image', {
        title: 'Note Featured Image',
        icon: 'admin-site',
        category: 'widgets',
        edit: function() {
            return el( 'div', { className: 'digital-garden-note-featured-image' }, 'Note Featured Image' );
        },
        save: function() {
            return null; // Server-side rendered in PHP
        }
    });
})( window.wp.blocks, window.wp.element );
