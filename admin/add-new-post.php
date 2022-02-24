<title>CKeditor5 with Custom PHP Image Uploader</title> 
    <script src="ckeditor5/build/ckeditor.js"></script>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <h3 class="page-title">Create New File</h3>
            </div>
        </div>
        <!-- End Page Header -->
        <form id="new-post-add" class="add-new-post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!-- Add New Post Form   -->
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            <div class="ck-editor-container">
                                <div id="editor"></div> <!-- This is your editor, if you want to change id (#editor) change it from other files too -->
                            </div>
                        </div>
                    </div>
                    <!-- / Add New Post Form -->
                </div>
                <div class="col-lg-3 col-md-12">
                    <button type="button" class="btn btn-sm btn-accent ml-auto" onclick="newPost('create');">
                        Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        /* post form data with ajax and post source code with post_content variable. you have to use source code plugin and if you have a trouble with posting data, first check the source code path */
        function newPost(action){
            $("#new-post-add > div > div.col-lg-9.col-md-12 > div:nth-child(1) > div > div > div.ck.ck-reset.ck-editor.ck-rounded-corners > div.ck.ck-editor__top.ck-reset_all > div > div.ck.ck-sticky-panel__content > div > div > button.ck.ck-button.ck-source-editing-button.ck-off.ck-button_with-text").trigger("click");
            var post_content = document.querySelector('#new-post-add > div > div.col-lg-9.col-md-12 > div:nth-child(1) > div > div > div.ck.ck-reset.ck-editor.ck-rounded-corners > div.ck.ck-editor__main > div.ck-source-editing-area');
            post_content = post_content.dataset.value;
            $("#new-post-add > div > div.col-lg-9.col-md-12 > div:nth-child(1) > div > div > div.ck.ck-reset.ck-editor.ck-rounded-corners > div.ck.ck-editor__top.ck-reset_all > div > div.ck.ck-sticky-panel__content > div > div > button.ck.ck-button.ck-source-editing-button.ck-on.ck-button_with-text").trigger("click");
            var veri = $("#new-post-add")[0];
            var formData = new FormData(veri);
            formData.append('post_content',post_content);
            formData.append('post_action',action);
            event.preventDefault();
            $.ajax({
                type:"post",
                url:"operations/new-post.php", // change with your php file
                processData: false,
                contentType: false,
                data:formData,
                success:function(sonuc){
                    $("#newPostResult").html((sonuc));
                }
            });
        }
    </script>
    <script src="ckeditor5/build/myuploader.js"></script>
    <script src="ckeditor5/scripts/app/app-new-post.js"></script>