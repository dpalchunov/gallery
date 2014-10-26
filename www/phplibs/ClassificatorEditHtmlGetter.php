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
                 <div id=\"classificator_area_{$id}_header\" class=\"one_element_header\" name_holder1=\"cl_rus_input_{$id}\" name_holder2=\"cl_eng_input_{$id}\">
                    {$engName} - {$rusName}
                 </div>
                 <div id=\"classificator_area_{$id}\" class=\"one_element\">
                    <div class=\"field_editor_div\">
                        <form id=\"classificator_form_{$id}\" class=\"field_editor_form\" action=\"classificator_update.php\">
                            <input name=\"id\" type=\"hidden\" value=\"$id\">
                            <div class=\"eng_name_div\">
                                <input id=\"cl_eng_input_{$id}\" type=\"text\" autocomplete=\"off\" name=\"eng_name\" class=\"eng_value_input field_editor_input\" hash_holder=\"classificator_area_{$id}\"  value=\"{$engName}\"></input>
                                <label class=\"field_editor_label\">eng </label>
                            </div>
                            <div class=\"rus_name_div\">
                                <input id=\"cl_rus_input_{$id}\" type=\"text\" autocomplete=\"off\" name=\"rus_name\" class=\"rus_value_input field_editor_input\" hash_holder=\"classificator_area_{$id}\"  value=\"{$rusName}\" ></input>
                                <label class=\"field_editor_label\">rus </label>
                            </div>
                        </form>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove red\" area=\"classificator_area_{$id}\">
                            <a class=\"c_remove_href\" area=\"classificator_area_{$id}\" cl_id=\"{$id}\" hash_holder=\"classificator_area_{$id}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div  class=\"control save green\" area=\"classificator_area_{$id}\">
                            <a class=\"c_save_href\" area=\"classificator_area_{$id}\" cl_id=\"{$id}\" href=\"javascript: void(0)\" hash_holder=\"classificator_area_{$id}\" form_id=\"classificator_form_{$id}\" > save</a>
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
            $v_id = $vl->getID();

            $rusValue = $vl->getRusValue();
            $engValue = $vl->getEngValue();

            $vsHtml = $vsHtml .
                "<div id=\"values_area_{$v_id}\" class=\"one_element\">
                    <div class=\"field_editor_div\">
                        <form id=\"classificator_value_form_{$v_id}\" class=\"field_editor_form\" action=\"classificator_value_update.php\">
                            <input name=\"id\" type=\"hidden\" value=\"$v_id\">
                            <div class=\"eng_name_div\">
                                <input name=\"eng_value\" autocomplete=\"off\" class=\"eng_value_input field_editor_input\" hash_holder=\"values_area_{$v_id}\" value=\"{$engValue}\" ></input>
                                <label class=\"field_editor_label\">eng </label>
                            </div>
                            <div class=\"rus_name_div\">
                                <input name=\"rus_value\" autocomplete=\"off\" class=\"rus_value_input field_editor_input\" hash_holder=\"values_area_{$v_id}\" value=\"{$rusValue}\"></input>
                                <label class=\"field_editor_label\">rus</label>
                            </div>
                        </form>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove red\" area=\"values_area_{$v_id}\">
                            <a class=\"v_remove_href\" area=\"values_area_{$v_id}\" vl_id=\"{$v_id}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save green\" area=\"values_area_{$v_id}\">
                            <a class=\"v_save_href\" area=\"values_area_{$v_id}\" vl_id=\"{$v_id}\" href=\"javascript: void(0)\" hash_holder=\"values_area_{$v_id}\" form_id=\"classificator_value_form_{$v_id}\" > save</a>
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










