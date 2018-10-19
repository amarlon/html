var FormDropzone = function () {

    var $dome_uploading_btn = $('.done-uploading-btn');
    var $spinner = $dome_uploading_btn.parent().find('.fa-spin');
    var $gallery_info_form = $('#gallery-info-form') ;
    $gallery_info_form.hide();

    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzone = {

                addRemoveLinks: true,
                acceptedFiles: '.bmp,.gif,.jpg,.jpeg,.png,.BMP,.GIF,.JPG,.JPEG,.PNG',

                init: function() {

                    thisDropzone = this;

                    $.getJSON('/ajax/account/get_gallery_images/'+$('#user-id').val(), function(data){

                        //console.log(data);

                        if( data ){

                            $.each(data, function(key,value){

                                var image = { name: '', size: value.bytes, id : value.id, public_id : value.public_id};

                                thisDropzone.options.addedfile.call(thisDropzone, image);

                                thisDropzone.options.thumbnail.call(thisDropzone, image, value.image);

                                $gallery_info_form.show();

                            });

                        } else {
                            $gallery_info_form.hide();
                        }

                    });

                    this.on("removedfile", function(file) {

                        $dome_uploading_btn.hide();
                        $spinner.show();

                        var message = {'public_id' : file.public_id};

                        $.ajax({
                            type: 'POST',
                            url: '/ajax/account/remove_gallery_image/'+file.id,
                            data : message,
                            success : function(data){
                                $dome_uploading_btn.show();
                                $spinner.hide();
                                if( data.message ) {
                                    alert(data.message);
                                }
                            },
                            error   :   function(xhr, status, error) {
                                $dome_uploading_btn.show();
                                $spinner.hide();
                                alert('Oops! Something went wrong. Please contact our admin if you\'re having problems deleting photos.');
                            }
                        });

                    });


                    this.on("addedfile", function(file) {

                        $spinner.show();
                        $dome_uploading_btn.hide();

                        /*// Create the remove button
                         var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");

                         // Capture the Dropzone instance as closure.
                         var _this = this;

                         // Listen to the click event
                         removeButton.addEventListener("click", function(e) {
                         // Make sure the button click doesn't submit the form:
                         e.preventDefault();
                         e.stopPropagation();

                         // Remove the file preview.
                         _this.removeFile(file);
                         // If you want to the delete the file on the server as well,
                         // you can do the AJAX request here.
                         });

                         // Add the button to the file preview element.
                         file.previewElement.appendChild(removeButton);*/
                    });

                    this.on("complete", function(file, response) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                            $spinner.hide();
                            $dome_uploading_btn.fadeIn();
                            $gallery_info_form.show();
                        }
                    });

                    this.on("success", function(file, response) {
                        //$dome_uploading_btn.fadeIn();
                    });

                    this.on("processing", function(file, response) {

                    });
                }
            }
        }
    };
}();