jQuery( document ).ready(function($) {
    $( '.code-editor' ).each( function () {
        var $el = $( this ),
            $textarea = $el.prev( 'textarea' ),
            editor;
        editor = ace.edit( this.id );
        editor.setTheme( "ace/theme/" + 'monokai' );
        editor.getSession().setMode( "ace/mode/" + $el.data( 'language' ) );
        editor.getSession().on( 'change', function () {
            $textarea.val( editor.getSession().getValue() ).trigger( 'change' );
        } );
    } );  
});
