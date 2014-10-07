<?php
class  GalleryEditHtmlGetter {
    public function  getHTMLCode() {
        $pics_tmp = glob('./images/gallary/sketches/*.*');
        $pics = array_reverse($pics_tmp);
        $picsHtml = '';
        foreach($pics as $index => $file) {
            $info = pathinfo($file);
            $file_name = basename($file);
            $file_base = basename($file,'.'.$info['extension']);
            $picsHtml = $picsHtml.
                "<div id=\"area_{$file_base}\" class=\"one_element\" hash=\"-219551920\">
                    <div class=\"pic\"\">
                        <img src=\"{$file}\"/>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove_pic red\" area=\"area_{$file_base}\">
                            <a class=\"remove_href\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save_pic green\" area=\"area_{$file_base}\">
                            <a class=\"save_href\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" > save</a>
                        </div>
                    </div>
                    <div class=\"field_editor_div\">
                        <form class=\"field_editor_form\">
                            <div class=\"rus_desc_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea class=\"rus_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\"></textarea>
                            </div>
                            <div class=\"eng_desc_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea class=\"eng_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\" ></textarea>
                            </div>
                            <div class=\"rate\">
                                <label class=\"field_editor_label\">Rate (start count) </label>
                                <div class=\"rate_radio_group\">
                                    <label class=\"rate_radio_label_label\">1 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"1\" hash_holder=\"area_{$file_base}\" ></input>
                                    <label class=\"rate_radio_label_label\">2 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"2\" hash_holder=\"area_{$file_base}\" ></input>
                                    <label class=\"rate_radio_label_label\">3 </label>
                                    <input class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"3\" hash_holder=\"area_{$file_base}\" ></input>
                                </div>
                            </div>
                            <div class=\"position\">
                                <label class=\"field_editor_label\">Position </label>
                                <input class=\"position_input field_editor_input\"  type=\"text\" hash_holder=\"area_{$file_base}\" ></input>
                            </div>

                        </form>
                    </div>
                </div>";
        }
        return  $picsHtml;
    }
}
?>










