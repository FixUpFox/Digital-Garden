
(function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'digital-garden/search', {
        title: 'Search',
        icon: 'admin-site',
        category: 'widgets',
        edit: function() {
            return el( 'div', { className: 'digital-garden-search' }, 'Search' );
        },
        save: function() {
            return null; // Server-side rendered in PHP
        }
    });
})( window.wp.blocks, window.wp.element );
