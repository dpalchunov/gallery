//den_todo add time gif when uploading picture (some big picture)
var cropperHandlerIsActive = true;

String.prototype.hashCode = function () {
    if (Array.prototype.reduce) {
        return this.split("").reduce(function (a, b) {
            a = ((a << 5) - a) + b.charCodeAt(0);
            return a & a
        }, 0);
    }
    var hash = 0;
    if (this.length === 0) return hash;
    for (var i = 0; i < this.length; i++) {
        var character = this.charCodeAt(i);
        hash = ((hash << 5) - hash) + character;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

$(document).ready(function () {
    addControlsClickHandlers();
    addFieldsChangeHandlers();
    console.log('start handlers');
    addSubmitHandlers();
    setCurrentHashes();


    function randomCalorize() {
        var $areas = $(".one_element");
        $areas.each(function () {
            var delta_color = Math.round(Math.random() * 20);
            console.log(delta_color);
            var x = 210 + delta_color;
            var y = 223 + delta_color;
            var z = 227 + delta_color;
            $(this).css('background-color', 'rgb(' + x + ',' + y + ',' + z + ')');
        });
    }

    function reloadClassificators() {
        $.ajax({
            type: "POST",
            url: "classificator_edit_get_html.php"
        })
            .done(function (msg) {
                $("#classificator").html(msg);
                addControlsClickHandlers();
                addFieldsChangeHandlers();
                addSubmitHandlers();
                setCurrentHashes();
            });
    }

    function removeClHandler(id) {

        $.ajax({
            type: "POST",
            url: "classificator_del_cl.php",
            data: { id: id }
        })
            .done(function (msg) {
                reloadClassificators();
            });
    }

    function removeVlHandler(id) {

        $.ajax({
            type: "POST",
            url: "classificator_del_v.php",
            data: { id: id }
        })
            .done(function (msg) {
                reloadClassificators();
            });
    }


    function saveHandler(formID, hashHolderID) {
        $("#" + formID).submit();
        $(".save[area='" + hashHolderID + "']").hide();
        refreshHashByID(hashHolderID);

        console.log('submit');  //den_debug
    }


    function addControlsClickHandlers() {
        var $removeClButtons = $(".c_remove_href");
        var $removeVlButtons = $(".v_remove_href");

        $removeClButtons.each(function () {
            $(this).click(function () {
                removeClHandler($(this).attr("cl_id"))
            });

            $(this).hover(function () {
                $("#" + $(this).attr("area")).css("background-color", "#D16464");
            }, function () {
                $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
            });

        });

        $removeVlButtons.each(function () {
            $(this).click(function () {
                removeVlHandler($(this).attr("vl_id"))
            });

            $(this).hover(function () {
                $("#" + $(this).attr("area")).css("background-color", "#D16464");
            }, function () {
                $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
            });

        });

        var $cl = $(".c_save_href");
        var $vl = $(".v_save_href");
        var $saveButtons = $cl.add($vl);

        $saveButtons.each(function () {
            $(this).click(function () {
                saveHandler($(this).attr("form_id"), $(this).attr("hash_holder"))
            });

            $(this).hover(function () {
                $("#" + $(this).attr("area")).css("background-color", "#5d9f7a");
            }, function () {
                $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
            });

        })

    }

    function addFieldsChangeHandlers() {
        var $inputs = $(".field_editor_input");

        $inputs.each(function () {
            $(this).keyup(function () {
                console.log('fire');

                var hashHolderID = $(this).attr("hash_holder");
                var oldHash = $("#" + hashHolderID).attr("hash");
                var newHash = calcFormHash(hashHolderID);

                console.log(oldHash + '  ' + newHash);
                if (oldHash != newHash) {
                    $(".save[area='" + hashHolderID + "']").show();
                } else {
                    $(".save[area='" + hashHolderID + "']").hide();
                }
                var header = $('#' + hashHolderID + '_header');
                var engNameID = header.attr('name_holder1');
                var rusNameID = header.attr('name_holder2');
                var engName = $('#' + engNameID);
                var rusName = $('#' + rusNameID);
                header.html($(rusName).attr('value') + ' - ' + $(engName).attr('value'));
            });
        });
    }

    function addSubmitHandlers() {
        console.log('submit handler work');  //den_debug
        var $forms = $(".field_editor_form");

        $forms.each(function () {
            $(this).submit(function (e) {
                e.preventDefault();
                console.log('fire');  //den_debug
                console.log($(this).serialize());  //den_debug
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    success: function (data) {
                        console.log(data);  //den_debug
                    }
                })
            });
        });
    }

    function setCurrentHashes() {
        var $areas = $(".one_element");
        $areas.each(function () {
            refreshHash($(this));
        });
    }


    function refreshHashByID(ID) {
        refreshHash($('#' + ID));
    }

    function refreshHash(hash_holder) {
        var hash = calcFormHash($(hash_holder).attr('id'));
        $(hash_holder).attr('hash', hash);
    }

    function calcFormHash(hash_holder_id) {
        var $fields = $("[hash_holder='" + hash_holder_id + "']");
        var $content = '';
        $fields.each(function () {
            $content += $(this).attr("value");
        });
        var $hash = new String($content).hashCode();
//        console.log($hash);   //den_debug
        return $hash;

    }

});
