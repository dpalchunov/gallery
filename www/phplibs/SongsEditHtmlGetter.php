<?php
require_once 'phplibs/SongsObjManager.php';

class  SongsEditHtmlGetter
{

    public function  getHTMLCode($active_page)
    {
        $man = new SongsObjManager();
        $objs = $man->selectSongsPage($active_page);
        $objsHtml = '';

        foreach ($objs as $obj) {
            $id = $obj->getID();
            $runame = $obj->getDescription('rus');
            $engame = $obj->getDescription('eng');
            $path = $obj->getPath();

            $info = pathinfo($path);
            $file_name = basename($path);

            $file_base = basename($path, '.' . $info['extension']);
            $objsHtml = $objsHtml .
                "<div id=\"area_{$file_base}\" class=\"one_element\">
                    <div class=\"song\"\">
                        <img src=\"{$path}\"/>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove_song red\" area=\"area_{$file_base}\">
                            <a class=\"remove_href\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" song_id=\"{$id}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save_song green\" area=\"area_{$file_base}\">
                            <a class=\"save_href\" song_id =\"{$id}\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" song_id=\"{$id}\" href=\"javascript: void(0)\" form_id=\"form_{$file_base}\" > save</a>
                        </div>
                    </div>
                    <div class=\"field_editor_div\">
                        <form id=\"form_{$file_base}\" class=\"field_editor_form\" action=\"songs_edit.php\">
                            <input name=\"id\" type=\"hidden\" value=\"{$id}\">
                            <input name=\"action\" type=\"hidden\" value=\"edit_update_song\">
                            <div class=\"rusname_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea name=\"rus_desc\" class=\"rusname_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$runame</textarea>
                            </div>
                            <div class=\"engname_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea name=\"eng_desc\" class=\"engname_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$engame</textarea>
                            </div>
                </form>
        </div>
    </div>";
        }
        return $objsHtml;
    }

    public function getPaginationHtml($active_page)
    {
        $pages_cnt = $this -> getPageCount();
        $pages = '';
        $pages = $pages . "<div id =\"active_page\" actve_page=\"{$active_page}\"></div>";
        if ($active_page > 1) {
            $page = $active_page - 1;
            $pages = $pages . "<div class=\"page_div\"><a class=\"page_href\" value=\"{$page}\" href=\"javascript: void(0)\"><<</a></div>";
        } else {
            $pages = $pages . "<div class=\"page_div\"></div>";
        }

        for ($i = 1; $i <= $pages_cnt; $i++) {
            if ($active_page == $i) {
                $active = ' active';

            } else {
                $active = '';
            }
            $pages = $pages . "<div class=\"page_div\" page=\"{$i}\" ><a class=\"page_href{$active}\" value=\"{$i}\" href=\"javascript: void(0)\">{$i}</a></div>";
        }
        if ($active_page <> $pages_cnt) {
            $page = $active_page + 1;
            $pages = $pages . "<div class=\"page_div\"><a class=\"page_href\" value=\"{$page}\" href=\"javascript: void(0)\">>></a></div>";
        }
        return $pages;
    }

    public function getPageCount(){
        $song_man = new SongsObjManager();
        $song_per_page = 5;
        $cnt = $song_man->getCount();
        if (($cnt % $song_per_page) == 0) {
            $pages_cnt = $cnt / $song_per_page;
        } else {
            $pages_cnt = floor($cnt / $song_per_page) + 1;
        }
        return $pages_cnt;
    }
}

?>










