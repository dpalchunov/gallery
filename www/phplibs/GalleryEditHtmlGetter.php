<?php
require_once 'phplibs/PictureObjManager.php';

class  GalleryEditHtmlGetter
{

    public function  getHTMLCode()
    {
        $pic_man = new PictureObjManager();
        $cl_man = new ClassificatorManager();
        $pics = $pic_man->selectAllPics();
        $picsHtml = '';
        $cls = $cl_man->selectAllClassificators();

        foreach ($pics as $picObj) {
            $id = $picObj->getID();
            $sketchPath = $picObj->getSketchPath();
            $rate = $picObj->getRate();
            $rels = $picObj->getClassification();
            $cl_path = $this->relToPath($rels);

            $rate1 = '';
            $rate2 = '';
            $rate3 = '';
            if ($rate == 1) {
                $rate1 = "checked";
            };
            if ($rate == 2) {
                $rate2 = "checked";
            };
            if ($rate == 3) {
                $rate3 = "checked";
            };

            $position = $picObj->getPosition();
            $rusDesc = $picObj->getDescription('rus');
            $engDesc = $picObj->getDescription('eng');

            $info = pathinfo($sketchPath);
            $file_name = basename($sketchPath);

            $file_base = basename($sketchPath, '.' . $info['extension']);
            $picsHtml = $picsHtml .
                "<div id=\"area_{$file_base}\" class=\"one_element\">
                    <div class=\"pic\"\">
                        <img src=\"{$sketchPath}\"/>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove_pic red\" area=\"area_{$file_base}\">
                            <a class=\"remove_href\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save_pic green\" area=\"area_{$file_base}\">
                            <a class=\"save_href\" pic_id =\"{$id}\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" form_id=\"form_{$file_base}\" > save</a>
                        </div>
                    </div>
                    <div class=\"field_editor_div\">
                        <form id=\"form_{$file_base}\" class=\"field_editor_form\" action=\"gallery_update_pic.php\">
                            <input name=\"id\" type=\"hidden\" value=\"{$id}\">
                            <div class=\"rus_desc_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea name=\"rus_desc\" class=\"rus_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$rusDesc</textarea>
                            </div>
                            <div class=\"eng_desc_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea name=\"eng_desc\" class=\"eng_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$engDesc</textarea>
                            </div>
                            <div class=\"rate\">
                                <label class=\"field_editor_label\">Rate (start count) </label>
                                <div class=\"rate_radio_group\">
                                    <label class=\"rate_radio_label_label\">1 </label>
                                    <input name=\"rate\" class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"1\" hash_holder=\"area_{$file_base}\" $rate1></input>
                                    <label class=\"rate_radio_label_label\">2 </label>
                                    <input name=\"rate\" class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"2\" hash_holder=\"area_{$file_base}\" $rate2></input>
                                    <label class=\"rate_radio_label_label\">3 </label>
                                    <input name=\"rate\" class=\"rate_input field_editor_input\"  name=\"rate_input\" type=\"radio\" value=\"3\" hash_holder=\"area_{$file_base}\" $rate3></input>
                                </div>
                            </div>
                            <div class=\"position\">
                                <label class=\"field_editor_label\">Position </label>
                                <input name=\"position\" class=\"position_input field_editor_input\"  type=\"text\" hash_holder=\"area_{$file_base}\" value=\"$position\"></input>
                            </div>"
                . $this->getClsHTMLCode($cls, $cl_path, $file_base) .
                "</form>
        </div>
    </div>";
        }
        return $picsHtml;
    }

    public function getClsHTMLCode($cls, $cl_path, $file_base)
    {
        $html_code = " <div class=\"classification_div\" >";
        foreach ($cls as $cl) {
            $id = $cl->getID();
            $html_code = $html_code .
                "<div class=\"cl_ref\">
                    <label class=\"cl_label field_editor_label\">{$cl->getEngName()}</label>
                    <input name=\"cl_{$id}\" db_id=\"{$id}\" class=\"cl_text_edit field_editor_input\" type=\"text\" hash_holder=\"area_{$file_base}\" value=\"{$cl_path[$id]}\"></input>
                </div>
                ";
        }
        $html_code = $html_code . "</div>";
        return $html_code;
    }

    private function relToPath($rels)
    {
        $cl_path = array();
        foreach ($rels as $rel) {
            $path = PathHelper::cut_root($rel->getPath());
            $cl_path[$rel->getClId()] = $path;
        }
        return $cl_path;
    }

    public function getPaginationHtml($active_page)
    {
        $pic_man = new PictureObjManager();
        $pic_per_page = 5;
        $cnt = $pic_man->getCount();
        $cnt = 11;
        if (($cnt % $pic_per_page) == 0) {
            $pages_cnt = $cnt / $pic_per_page;
        } else {
            $pages_cnt = floor($cnt / $pic_per_page) + 1;
        }
        $pages = '';
        if ($active_page > 1) {
            $pages = "<div class=\"page_div\"><a href=\" \"><<</a></div>";
        }
        for ($i = 1; $i <= $pages_cnt; $i++) {
            if ($active_page == $i) {
                $active = ' active ';

            } else {
                $active = '';
            }
            $pages = $pages . "<div class=\"page_div{$active}\"><a href=\" \">{$i}</a></div>";
        }
        if ($active_page <> $pages_cnt) {
            $pages = $pages . "<div class=\"page_div\"><a href=\" \">>></a></div>";
        }
        return $pages;
    }
}

?>










