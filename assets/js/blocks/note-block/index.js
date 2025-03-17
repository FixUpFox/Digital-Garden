
(function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'digital-garden/note-block', {
        title: 'Note Block',
        icon: 'admin-site',
        category: 'widgets',
        edit: function() {
            return el( 'div', { className: 'digital-garden-note-block' }, 'Note Block' );
        },
        save: function() {
            return null; // Server-side rendered in PHP
        }
    });
})( window.wp.blocks, window.wp.element );
