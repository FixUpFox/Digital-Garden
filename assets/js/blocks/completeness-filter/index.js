
(function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'digital-garden/completeness-filter', {
        title: 'Completeness Filter',
        icon: 'admin-site',
        category: 'widgets',
        edit: function() {
            return el( 'div', { className: 'digital-garden-completeness-filter' }, 'Completeness Filter' );
        },
        save: function() {
            return null; // Server-side rendered in PHP
        }
    });
})( window.wp.blocks, window.wp.element );
