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
                     <div id=\"controls\" class=\"pic_controls controls red remove\">
                        <a class=\"remove_pic\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" > remove</a>
                    </div>
                    <div class=\"field_editor_div\">
                        <form class=\"field_editor_form\">
                            <div class=\"rus_desc_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea class=\"rus_desc_input field_editor_input\"></textarea>
                            </div>
                            <div class=\"eng_desc_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea class=\"eng_desc_input field_editor_input\" type=\"text\" class=\"\"></textarea>
                            </div>
                            <div class=\"rate\">
                                <label class=\"field_editor_label\">Rate (start count) </label>
                                <div class=\"rate_radio_group\">
                                    <label class=\"rate_radio_label_label\">1 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"1\"></input>
                                    <label class=\"rate_radio_label_label\">2 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"2\"></input>
                                    <label class=\"rate_radio_label_label\">3 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"3\"></input>
                                </div>
                            </div>
                            <div class=\"position\">
                                <label class=\"field_editor_label\">Position </label>
                                <input class=\"position_input field_editor_input\"  type=\"text\"></input>
                            </div>

                        </form>
                    </div>
                </div>";
        }
        return  $picsHtml;
    }
}
?>










