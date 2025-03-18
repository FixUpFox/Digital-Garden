
(function( blocks, element ) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;

  registerBlockType( 'digital-garden/note-title', {
    title: 'Note Title',
    icon: 'admin-site',
    category: 'widgets',
    edit: function() {
      return el( 'div', { className: 'digital-garden-note-title' }, 'Note Title' );
    },
    save: function() {
      return null; // Server-side rendered in PHP
    }
  });
})( window.wp.blocks, window.wp.element );
