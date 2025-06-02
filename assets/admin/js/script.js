const $ = jQuery.noConflict();

const bsGallery = {
  galleryRowTemplate: (data) => {
    const rowId = $("#glryBody .row").length;
    const btnClass = "button button-default dashicons w-auto h-auto mb-2 ";

    return `<div class="row m-0 w-100 pb-3 border-bottom" id="grow${rowId}">
                <div class="col-3 px-0">
                    <span class="prvImg text-center d-block">
                        <img class="w-75" id="img${rowId}" src="${data.url}"/>
                    </span>
                    <input type="hidden" class="file_id" value="${data.id}" name="files[${rowId}][file_id]"/>
                    <input type="hidden" class="file_url" value="${data.url}" name="files[${rowId}][file_url]"/>
                    <input type="hidden" class="file_mime" value="${data.mime}" name="files[${rowId}][file_mime]"/>
                </div>
                <div class="col-7 px-2">
                    <input name="files[${rowId}][file_title]" type="text" value="${bsGallery.stripSlashes(
      data.title
    )}" class="d-block w-100 mb-1 regular-text grtitle" placeholder="File Title"/>
                    <textarea name="files[${rowId}][file_caption]" rows="6" class="resize-none d-block w-100 grcaption" placeholder="File Description">${
                      bsGallery.stripSlashes(data.caption)
    }</textarea>
                </div>
                <div class="px-2" style="align-self: center;">
                    <button type="button" name="Upload" data-rowid="${rowId}" onclick="bsGallery.upload(this)" data-action="edit" class="${btnClass} dashicons-edit"></button>
                    <button type="button" name="Active/Inactive" data-rowid="${rowId}" onclick="bsGallery.status(${rowId})" class="${btnClass} dashicons-no-alt"></button>
                    <button type="button" name="Trash" data-rowid="${rowId}" onclick="bsGallery.trash(${rowId})" class="${btnClass} dashicons-trash"></button>
                </div>
            </div>`;
  },

  status: (rowId) => {
    console.log("status", rowId);
  },

  trash: (rowId) => {
    $(`#grow${rowId}`).remove();
  },

  stripSlashes: (str) => {
    return str.replace(new RegExp("\\\\", "g"), "");
  },

  upload: (ele) => {
    /* File Uploading Code */
    let fileFrame = "";
    ele = $(ele);

    /** If the media frame already exists, reopen it. */
    if (fileFrame) {
      fileFrame.open();
      return false;
    }

    /** Create the media frame. */
    fileFrame = wp.media.frames.fileFrame = wp.media({
      title: "BSF-Gallery",
      button: {
        text: $(this).data("uploader_button_text"),
      },
      multiple:
        !!ele.hasClass(
          "multiple"
        ) /** Set to true to allow multiple files to be selected */,
    });

    /** When a file is selected, run a callback. */
    fileFrame.on("select", function () {
      const attachment = fileFrame.state().get("selection").toJSON();
      let rowId = ele.attr("data-rowid");

      if (ele.attr("data-action") === "edit") {
        $(`#grow${rowId} .prvImg img`).attr("src", attachment[0].url);
        $(`#grow${rowId} input.file_url`).val(attachment[0].url);
        $(`#grow${rowId} input.file_id`).val(attachment[0].id);
        $(`#grow${rowId} input.file_mime`).val(attachment[0].mime);
        $(`#grow${rowId} input.grimgid`).val(attachment[0].id);
        $(`#grow${rowId} input.grtitle`).val(attachment[0].title);
        $(`#grow${rowId} input.grcaption`).val(attachment[0].caption);
      } else if (ele.attr("data-field")) {
        $("#thumbnail-prev").attr("src", attachment[0].icon);
        $(ele.attr("data-field")).val(attachment[0].id);
      } else {
        rowId = $("#glryBody tr").length;
        $.each(attachment, function (id, val) {
          $("#glryBody").append(bsGallery.galleryRowTemplate(val));
        });
      }
      // addSortingAbility();
    });
    /* / Finally, open the modal */
    fileFrame.open();
    /* File Uploading Code */
  },
  // /** save gallery */
  // $('button#save_bsf_gallery').on('click', function(){
  //     var formData = $('#form_bsf_gallery').serialize();
  //     console.log(formData);
  // });
  //
};
