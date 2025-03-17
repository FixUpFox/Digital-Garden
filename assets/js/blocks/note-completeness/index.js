
(function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'digital-garden/note-completeness', {
        title: 'Note Completeness',
        icon: 'admin-site',
        category: 'widgets',
        edit: function() {
            return el( 'div', { className: 'digital-garden-note-completeness' }, 'Note Completeness' );
        },
        save: function() {
            return null; // Server-side rendered in PHP
        }
    });
})( window.wp.blocks, window.wp.element );
