<?php
require_once 'phplibs/PictureObjManager.php';

class  ClassificatorEditHtmlGetter
{
    public function  getHTMLCode()
    {
        $cl_man = new ClassificatorManager();
        $cls = $cl_man->selectAllClassificators();
        $clsHtml = '';
        foreach ($cls as $cl) {
            $id = $cl->getID();

            $rusName = $cl->getRusName();
            $engName = $cl->getEngName();

            $clsHtml = $clsHtml .
                "
                 <div id=\"area_{$id}_header\" class=\"one_element_header\">
                    {$engName} - {$rusName}
                 </div>
                 <div id=\"area_{$id}\" class=\"one_element\">
                    <div class=\"field_editor_div\">
                        <form id=\"form_{$id}\" class=\"field_editor_form\" action=\"gallery_update_pic.php\">
                            <input name=\"id\" type=\"hidden\" value=\"$id\">
                            <div class=\"rus_name_div\">
                                <input type=\"text\" name=\"rus_desc\" class=\"rus_value_input field_editor_input\" hash_holder=\"area_{$id}\" value=\"{$rusName}\" ></input>
                                <label class=\"field_editor_label\">rus </label>
                            </div>
                            <div class=\"eng_name_div\">
                                <input type=\"text\" name=\"eng_desc\" class=\"eng_value_input field_editor_input\" hash_holder=\"area_{$id}\" value=\"{$engName}\"></input>
                                <label class=\"field_editor_label\">eng </label>
                            </div>
                        </form>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove red\" area=\"area_{$id}\">
                            <a class=\"remove_href\" area=\"area_{$id}\" cl_id=\"{$id}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save green\" area=\"area_{$id}\">
                            <a class=\"save_href\" area=\"area_{$id}\" cl_id=\"{$id}\" href=\"javascript: void(0)\" form_id=\"form_{$id}\" > save</a>
                        </div>
                    </div>
                    <div class=\"values\">" .
                $this->getValuesHtmlCode($cl->getValues())
                . "</div>
                </div>";
        }
        return $clsHtml;
    }

    public function  getValuesHtmlCode(array $vls)
    {

        $vsHtml = '';
        foreach ($vls as $vl) {
            $id = $vl->getID();

            $rusValue = $vl->getRusValue();
            $engValue = $vl->getEngValue();

            $vsHtml = $vsHtml .
                "<div id=\"area_{$id}\" class=\"one_element\">
                    <div class=\"field_editor_div\">
                        <form id=\"form_{$id}\" class=\"field_editor_form\" action=\"gallery_update_pic.php\">
                            <input name=\"id\" type=\"hidden\" value=\"$id\">
                            <div class=\"rus_name_div\">
                                <input name=\"rus_value\" class=\"rus_value_input field_editor_input\" hash_holder=\"area_{$id}\" value=\"{$rusValue}\"></input>
                                <label class=\"field_editor_label\">rus</label>
                            </div>
                            <div class=\"eng_name_div\">
                                <input name=\"eng_value\" class=\"eng_value_input field_editor_input\" hash_holder=\"area_{$id}\" value=\"{$engValue}\" ></input>
                                <label class=\"field_editor_label\">eng </label>
                            </div>
                        </form>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove red\" area=\"area_{$id}\">
                            <a class=\"remove_href\" area=\"area_{$id}\" cl_id=\"{$id}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save green\" area=\"area_{$id}\">
                            <a class=\"save_href\" area=\"area_{$id}\" cl_id=\"{$id}\" href=\"javascript: void(0)\" form_id=\"form_{$id}\" > save</a>
                        </div>
                    </div>
                    <div class=\"values\">" .
                $this->getValuesHtmlCode($vl->getValues())
                . "</div>
                </div>";
        }
        return $vsHtml;
    }

}

?>










