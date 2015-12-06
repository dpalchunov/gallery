//объявляем глобальные переменные
//количество фотографий , которые можно перебирать на аватарке
var avas;
var avaCount;

var avaPosition=0;
//время анимации смены аватарки
var animateTime = 120;


//content-tools code
function initContentTools() {
    var editor,dialog;
    editor = ContentTools.EditorApp.get();

    editor.init('*[data-editable]', 'data-name');
    ContentTools.StylePalette.add([
        new ContentTools.Style('Align left', 'align-left', ['img']),
        new ContentTools.Style('Align right', 'align-right', ['img'])
    ]);
    ContentTools.Tools.Heading.tagName="h2";
    ContentTools.Tools.Subheading.tagName="h3";

    editor.bind('save', function (regions) {
        var name, payload;

        // Set the editor as busy while we save our changes
        this.busy(true);

        // Collect the contents of each region into a FormData instance
        payload = new FormData();
        for (name in regions) {
            if (regions.hasOwnProperty(name)) {
                payload.append(name, regions[name]);
            }
        }
        payload.append("action","save_events");
        console.log(payload);
        // Send the update content to the server to be saved

        centerLoading();
        $('#loader').show();

        $.ajax({
            url: "events_page.php",
            cache: false,
            type: "POST",
            shouldRetry: 3,
            data: payload,
            ProcessData:false,
            processData: false,
            contentType: false
        }).done(function (msg) {

                editor.busy(false);
                new ContentTools.FlashUI('ok');
                $('#loader').hide();
            })
            .fail(function (msg) {
                editor.busy(false);
                new ContentTools.FlashUI('no');
                $('#loader').hide();
            });
    });


    ContentTools.IMAGE_UPLOADER = imageUploader;
}

function getCurAvaPath() {
    return avas[window.avaPosition - 1];
}

function getNextAvaPath() {

    if (window.avaPosition == window.avaCount) {
        window.avaPosition = 1;
    } else {
        window.avaPosition++;
    }
    return window.avas[window.avaPosition - 1];
}

function getPrevAvaPath() {
    if (window.avaPosition == 1) {
        window.avaPosition = window.avaCount;
    } else {
        window.avaPosition--;
    }
    return window.avas[window.avaPosition - 1];
}

function loadAvas() {
    var action = "get_avas_array";
    $.ajax({
        method: "POST",
        shouldRetry: 3,
        url: "about_edit.php",
         data: {action:action},
        async:false
    }).done(function(data,y,jqXHR) {
            if (action != jqXHR.getResponseHeader('action')) {
                loadAvas();
                return;
            }
            try {
                window.avas = $.parseJSON(data);
            } catch(e) {
                //console.error("response parse error while post about_edit.php:get_avas_array");
            }
            window.avaCount = window.avas.length;
            window.avaPosition = 1;
            setup_avas();
        });
}

function avaAnimation() {
    //прячем тень
    $("#shaddow").animate({opacity: 'hide'}, animateTime);
    //показываем DIV заново
    $("#ava_img").animate({width: 'toggle'}, animateTime);
    //показываем тень
    $("#shaddow").animate({opacity: 'show'}, animateTime);
}


$(document).ready(function () {
    loadAvas();
    initContentTools();
    destructor = destructor;

});

function setup_avas() {
    if (window.avaCount > 1) {
        $("#ava_img").click(function () {
            var nextAvaPath = getNextAvaPath();
            //сначала убираем DIV
            $("#ava_img").animate({height: 'toggle'},
                animateTime,
                function () {
                    $("#ava_img").attr("src", nextAvaPath);

                }
            );
            avaAnimation();
        });
        $("#ava_img").attr("src", getCurAvaPath());
    } else if (window.avaCount == 1) {
        $("#ava_img").attr("src", getCurAvaPath());

    } else {
        $("#slider").hide();

    }
}

function destructor() {
    $(".mc_el").remove();
}

function imageUploader(dialog) {
    var image, xhr, xhrComplete, xhrProgress;

    // Set up the event handlers

    dialog.bind('imageUploader.cancelUpload', function () {
        // Cancel the current upload

        // Stop the upload
        if (xhr) {
            xhr.upload.removeEventListener('progress', xhrProgress);
            xhr.removeEventListener('readystatechange', xhrComplete);
            xhr.abort();
        }

        // Set the dialog to empty
        dialog.state('empty');
    });




    dialog.bind('imageUploader.fileReady', function (file) {
        // Upload a file to the server
        var formData;

        // Define functions to handle upload progress and completion
        xhrProgress = function (ev) {
            // Set the progress for the upload
            dialog.progress((ev.loaded / ev.total) * 100);
        }

        xhrComplete = function (ev) {
            var response;

            // Check the request is complete
            if (ev.target.readyState != 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrProgress = null
            xhrComplete = null

            // Handle the result of the upload
            if (parseInt(ev.target.status) == 200) {
                // Unpack the response (from JSON)
                console.log(ev.target.responseText);
                response = JSON.parse(ev.target.responseText);

                // Store the image details
                image = {
                    size: response.size,
                    url: response.url
                };

                // Populate the dialog
                dialog.populate(image.url, image.size);

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog state to uploading and reset the progress bar to 0
        dialog.state('uploading');
        dialog.progress(0);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('myfile', file);
        formData.append('action', 'upload_img')

        // Make the request
        xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', xhrProgress);
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', '/events_edit.php', true);
        xhr.send(formData);
    });

    dialog.bind('imageUploader.save', function () {
        var crop, cropRegion, formData;

        // Define a function to handle the request completion
        xhrComplete = function (ev) {
            // Check the request is complete
            if (ev.target.readyState !== 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrComplete = null

            // Free the dialog from its busy state
            dialog.busy(false);

            // Handle the result of the rotation
            if (parseInt(ev.target.status) === 200) {
                // Unpack the response (from JSON)
                console.log(ev.target.responseText);
                var response = JSON.parse(ev.target.responseText);

                // Trigger the save event against the dialog with details of the
                // image to be inserted.
                dialog.save(
                    response.url,
                    response.size,
                    {
                        'alt': response.alt,
                        'data-ce-max-width': image.size[0]
                    });

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog to busy while the rotate is performed
        dialog.busy(true);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('url', image.url);
        formData.append('action', 'save_img')

        // Set the width of the image when it's inserted, this is a default
        // the user will be able to resize the image afterwards.
        formData.append('width', 600);

        // Check if a crop region has been defined by the user
        if (dialog.cropRegion()) {
            console.log(JSON.stringify(dialog.cropRegion()));
            formData.append('crop', JSON.stringify(dialog.cropRegion()));
        }

        // Make the request
        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', '/events_edit.php', true);
        xhr.send(formData);
    });

}



