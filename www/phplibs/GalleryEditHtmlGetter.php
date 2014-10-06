<?php
class  GalleryEditHtmlGetter {
    public function  getHTMLCode() {
        $pics_tmp = glob('./images/gallary/sketches/*.*');
        $pics = array_reverse($pics_tmp);
        $picsHtml = '';
        foreach($pics as $index => $file) {
            $file_name = basename($file);
            $picsHtml = $picsHtml.
                "<div class=\"one_element\">
                    <div class=\"pic\"\">
                        <img src=\"{$file}\"/>
                    </div>

                    <div id=\"field_editor_div\">
                        <form id=\"field_editor_form\">
                            <div id=\"rus_desc_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea id=\"rus_desc_input\"></textarea>
                            </div>
                            <div id=\"eng_desc_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea id=\"eng_desc_input\" type=\"text\"></textarea>
                            </div>
                            <div id=\"rate\">
                                <label class=\"field_editor_label\">Rate (start count) </label>
                                <div id=\"rate_radio_group\">
                                    <input id=\"rate_input\" name=\"rate_input\" type=\"radio\" value=\"1\"></input>
                                    <input id=\"rate_input\" name=\"rate_input\" type=\"radio\" value=\"2\"></input>
                                    <input id=\"rate_input\" name=\"rate_input\" type=\"radio\" value=\"3\"></input>
                                </div>
                            </div>
                            <div id=\"position\">
                                <label class=\"field_editor_label\">Position </label>
                                <input id=\"position_input\" type=\"text\"></input>
                            </div>

                        </form>
                    </div>

                    <div class=\"pic_controls controls\">
                        <div class=\"red remove\">
                            <a class=\"remove_pic\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                    </div>
                </div>";
        }
        return  $picsHtml;
    }
}
?>










