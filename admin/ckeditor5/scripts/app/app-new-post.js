/* Custom Image Uploader Plugin */
function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        return new MyUploadAdapter( loader );
    };
}

ClassicEditor
    .create( document.querySelector('#editor'),{ // if your editor id/class different, change #editor to your editor id/class
        extraPlugins: [ MyCustomUploadAdapterPlugin]
    } )

    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
