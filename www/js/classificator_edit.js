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
    addControlsClickHandlers('*');
    addFieldsChangeHandlers('*');
    console.log('start handlers');
    addSubmitHandlers('*');
    setCurrentHashes('*');


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
                addControlsClickHandlers('*');
                addFieldsChangeHandlers('*');
                addSubmitHandlers('*');
                setCurrentHashes('*');
            });
    }

    function removeClHandler(id) {

        $.ajax({
            type: "POST",
            url: "classificator_del_cl.php",
            data: { id: id }
        })
            .done(function (msg) {
                $('#classificator_area_' + id + '_header').remove();
                $('#classificator_area_' + id).remove();
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


    function addClChildHandler() {
        $.ajax({
            type: "POST",
            url: "classificator_add_cl_child.php",
            data: { parent_id: id, eng_name: '', rus_name: '' }
        })
            .done(function (msg) {
                reloadClassificators();
            });
    }

    function addClHandler(addBefore) {
        $.ajax({
            type: "POST",
            url: "classificator_add_cl.php",
            data: { eng_name: 'test', rus_name: 'test' }
        })
            .done(function (new_cl_id) {
                $.ajax({
                    type: "POST",
                    url: "classificator_edit_get_cl_html.php",
                    data: { id: new_cl_id }
                })
                    .done(function (msg) {
                        console.log('start');
                        console.log(msg);
                        console.log(addBefore)
                        $('#' + addBefore).before(msg);
                        addControlsClickHandlers("*[target='classificator_area_" + new_cl_id + "']");
                        addFieldsChangeHandlers("*[hash_holder='classificator_area_" + new_cl_id + "']");
                        setCurrentHashes('#classificator_area_' + new_cl_id);
                        addSubmitHandlers('#classificator_form_' + new_cl_id);


                    });
            });
    }


    function addVlChildHandler() {
        $.ajax({
            type: "POST",
            url: "classificator_add_vl_child.php",
            data: { parent_id: id, eng_value: '', rus_value: ''  }
        })
            .done(function (msg) {
                reloadClassificators();
            });
    }


    function addControlsClickHandlers(filterString) {
        var $removeClButtons = $(".c_remove_href").filter(filterString);
        var $removeVlButtons = $(".v_remove_href").filter(filterString);
        var $cl = $(".c_save_href").filter(filterString);
        var $vl = $(".v_save_href").filter(filterString);
        var $addChildClButtons = $(".c_add_child_href").filter(filterString);
        var $addChildVlButtons = $(".v_add_child_href").filter(filterString);
        var $addClButtons = $(".c_add_href").filter(filterString);

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
        var $saveButtons = $cl.add($vl);


        $saveButtons.each(function () {
            $(this).click(function () {
                saveHandler($(this).attr("form_id"), $(this).attr("target"))
            });

            $(this).hover(function () {
                $("#" + $(this).attr("area")).css("background-color", "#5d9f7a");
            }, function () {
                $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
            });

        });

        $addClButtons.each(function () {
            $(this).click(function () {
                addClHandler($(this).attr('add_before'))
            });
        });

        $addChildClButtons.each(function () {
            $(this).click(function () {
                addClChildHandler($(this).attr('cl_id'))
            });
        })

        $addChildVlButtons.each(function () {
            $(this).click(function () {
                addVlChildHandler($(this).attr('vl_id'))
            });
        });


    }

    function addFieldsChangeHandlers(filterString) {
        var $inputs = $(".field_editor_input").filter(filterString);

        console.log(filterString);
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
                var header = $('#' + hashHolderID + '_header')
                var header_text = header.find('.header_text');
                var engNameID = header.attr('name_holder1');
                var rusNameID = header.attr('name_holder2');
                var engName = $('#' + engNameID);
                var rusName = $('#' + rusNameID);
                header_text.html($(rusName).attr('value') + ' - ' + $(engName).attr('value'));
            });
        });
    }

    function addSubmitHandlers(filter) {
        console.log('submit handler work');  //den_debug
        var $forms = $(".field_editor_form").filter(filter);

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

    function setCurrentHashes(filter) {
        var $areas = $(".one_element").filter(filter);
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
