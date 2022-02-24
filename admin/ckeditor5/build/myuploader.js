class MyUploadAdapter {
    constructor( loader ) {
        // CKEditor 5's FileLoader instance.
        this.loader = loader;

        // URL where to send files.
        this.url = 'operations/new-img.php'; // image upload to server php code
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }


    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open( 'POST', this.url ,true);
        xhr.responseType = 'json';
    }


    _initListeners( resolve, reject,file ) {
        let file_name = file.name;
        let file_path = "/assets/images/"; // UPDATE here
        let file_location = file_path+file.name; // image upload link

        if(fileExists(file_location)){ // if file exist, add number after the file name like a.png to a-1.png
            if (file.type == "image/png") {
                var file_type = ".png";
            } else if (file.type == "image/jpeg") {
                var file_type = ".jpeg";
            } else if (file.type == "image/jpg") {
                var file_type = ".jpg";
            }
            let k = 1;
            let temp;
            while(k){
                temp = file_name.replace(file_type,"");
                temp = temp+"-"+k+file_type;
                file_location = file_path+temp; // image upload link
                if(!fileExists(file_location)){
                    k=0;
                }
                else {
                    k++;
                }
            }
        }


        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = 'Couldn\'t upload file:' + ` ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            /*if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }*/
            //console.log(response);
            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            
            resolve( {
                default: file_location
            } );
        } );

        xhr.upload.addEventListener( 'progress', evt => {
            if ( evt.lengthComputable ) {
                loader.uploadTotal = evt.total;
                loader.uploaded = evt.loaded;
            }
        } );
    }

    // Prepares the data and sends the request.
    _sendRequest(file) {
        const data = new FormData();
        //console.log(this.loader.file);
        data.append('upload', file );
    //csrf_token CSRF protection
        //data.append('csrf_token', requestToken);

        this.xhr.send( data );
    }
}

function fileExists(url) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', url, false);
    xhr.send();
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}