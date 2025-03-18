
(function( blocks, element ) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;

  registerBlockType( 'digital-garden/note-modify-date', {
    title: 'Note Modify Date',
    icon: 'admin-site',
    category: 'widgets',
    edit: function() {
      return el( 'div', { className: 'digital-garden-note-modify-date' }, 'Note Modify Date' );
    },
    save: function() {
      return null; // Server-side rendered in PHP
    }
  });
})( window.wp.blocks, window.wp.element );
