
(function( blocks, element ) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;

  registerBlockType( 'digital-garden/note-publish-date', {
    title: 'Note Publish Date',
    icon: 'admin-site',
    category: 'widgets',
    edit: function() {
      return el( 'div', { className: 'digital-garden-note-publish-date' }, 'Note Publish Date' );
    },
    save: function() {
      return null; // Server-side rendered in PHP
    }
  });
})( window.wp.blocks, window.wp.element );
