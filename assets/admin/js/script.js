var $ = jQuery.noConflict();

const bsGallery = {
    galleryRowTemplate: (data) => {
        var rowId = $('#glryBody .row').length;
        return `<div class="row px-3" id="grow`+ rowId +`">
                    <div class="col-2">
                        <span class="prvImg w-100 text-center d-block">
                            <img class="w-75" id="img`+ rowId +`" src="`+ data.url +`"/>
                        </span>
                        <input type="hidden" class="file_id" value="`+ data.id +`" name="files[`+ rowId +`][file_id]"/>
                        <input type="hidden" class="file_url" value="`+ data.url +`" name="files[`+ rowId +`][file_url]"/>
                        <input type="hidden" class="file_mime" value="`+ data.mime +`" name="files[`+ rowId +`][file_mime]"/>
                    </div>
                    <div class="col-6">
                        <input name="files[`+ rowId +`][file_title]" type="text" value="`+ data.title +`" class="d-block w-100 mb-1 regular-text grtitle" placeholder="File Title"/>
                        <textarea name="files[`+ rowId +`][file_caption]" rows="3" class="d-block w-100 grcaption" placeholder="File Description">`+ data.caption +`</textarea>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" data-rowid="`+ rowId +`" onclick="bsGallery.upload(this)" data-action="edit" class="dashicons py-0 w-auto h-auto dashicons-edit"></button>
                        <button type="button" data-rowid="`+ rowId +`" onclick="bsGallery.status(`+ rowId +`)" class="dashicons dashicons-no-alt w-auto h-auto py-0"></button>
                        <button type="button" data-rowid="`+ rowId +`" onclick="bsGallery.trash(`+ rowId +`)" class="dashicons dashicons-trash w-auto h-auto py-0"></button>
                    </div>
                    <hr class="w-100" />
                </div>`;
    },

    status: (rowId) => {
        console.log('status', rowId)
    },

    trash: (rowId) => {
        $('#grow'+rowId).remove();
    },

    upload: (ele) => {
        /* File Uploading Code */
        var i = 0,
            file_frame = '',
            id = '',
            img = '';
            ele = $(ele);

        /** If the media frame already exists, reopen it.*/
        if (file_frame) {
            file_frame.open();
            return false;
        }

        /** Create the media frame.*/
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'BSF-Gallery',
            button: {
                text: $(this).data('uploader_button_text'),
            },
            multiple: (ele.hasClass('multiple') ? true : false) /** Set to true to allow multiple files to be selected*/
        });

        /** When a file is selected, run a callback. */
        file_frame.on('select', function ()
        {
            var attachment = file_frame.state().get('selection').toJSON();
            var rowId = ele.attr('data-rowid');

            if (ele.attr('data-action') == 'edit')
            {
                $('#grow'+rowId+' .prvImg img').attr('src', attachment[0].url);
                $('#grow'+rowId+' input.file_id').val(attachment[0].id);
                $('#grow'+rowId+' input.file_mime').val(attachment[0].mime);
                $('#grow'+rowId+' input.grimgid').val(attachment[0].id);
                $('#grow'+rowId+' input.grtitle').val(attachment[0].title);
                $('#grow'+rowId+' input.grcaption').val(attachment[0].caption);
            }
            else if (ele.attr('data-field'))
            {
                $('#thumbnail-prev').attr('src', attachment[0].icon);
                $(ele.attr('data-field')).val(attachment[0].id);
            }
            else
            {
                rowId = $('#glryBody tr').length;
                $.each(attachment, function(id, val){
                    $('#glryBody').append(bsGallery.galleryRowTemplate(val));
                });
            }
            //addSortingAbility();
        });
        /*/ Finally, open the modal*/
        file_frame.open();
        /* File Uploading Code */
    }
    // /** save gallery */
    // $('button#save_bsf_gallery').on('click', function(){
    //     var formData = $('#form_bsf_gallery').serialize();
    //     console.log(formData);
    // });
    //
    // /** bsf trash row */
    // $('.bsfTrashRow').on('click', function(){
    //     $('#grow'+$(this).data('rowid')).remove();
    // });
}