<?php
require_once 'phplibs/PictureObjManager.php';

class  VideoHelper
{

    public function  getVideoEditHTMLCode($active_page)
    {
        $vid_man = new VideoObjManager();
        $vids = $vid_man->selectPage($active_page);
        $vidsHtml = '';

        foreach ($vids as $vidObj) {
            $id = $vidObj->getID();
            $thumb = $vidObj-> generateThumbPath();
            $video_name = $vidObj-> getFileName();


            $position = $vidObj->getPosition();
            $rusDesc = $vidObj->getDescription('rus');
            $engDesc = $vidObj->getDescription('eng');

            $info = pathinfo($thumb);
            $file_name = basename($thumb);

            $file_base = basename($thumb, '.' . $info['extension']);

            $vidsHtml = $vidsHtml .
                "<div id=\"area_{$file_base}\" class=\"one_element\">
                    <div class=\"pic\"\">
                        <img src=\"{$thumb}\"/>
                    </div>
                     <div class=\"controls\">
                        <div class=\"control remove_pic red\" area=\"area_{$file_base}\">
                            <a class=\"remove_href\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" video_name=\"{$video_name}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                        <div class=\"control save_pic green\" area=\"area_{$file_base}\">
                            <a class=\"save_href\" pic_id =\"{$id}\" area=\"area_{$file_base}\" file_name=\"{$file_name}\" href=\"javascript: void(0)\" form_id=\"form_{$file_base}\" > save</a>
                        </div>
                    </div>
                    <div class=\"field_editor_div\">
                        <form id=\"form_{$file_base}\" class=\"field_editor_form\" action=\"gallery_edit.php\">
                            <input name=\"id\" type=\"hidden\" value=\"{$id}\">
                            <input name=\"action\" type=\"hidden\" value=\"edit_update_vid\">
                            <div class=\"rus_desc_div\">
                                <label class=\"field_editor_label\">Desc in russian </label>
                                <textarea name=\"rus_desc\" class=\"rus_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$rusDesc</textarea>
                            </div>
                            <div class=\"eng_desc_div\">
                                <label class=\"field_editor_label\">Desc in english </label>
                                <textarea name=\"eng_desc\" class=\"eng_desc_input field_editor_input\" hash_holder=\"area_{$file_base}\" >$engDesc</textarea>
                            </div>
                            <div class=\"position\">
                                <label class=\"field_editor_label\">Position </label>
                                <input name=\"position\" class=\"position_input field_editor_input\"  type=\"text\" hash_holder=\"area_{$file_base}\" value=\"$position\"></input>
                            </div>
                </form>
        </div>
    </div>";
        }
        return $vidsHtml;
    }

    public function  getVideosArray()
    {
        $vid_man = new VideoObjManager();
        $videos = $vid_man->selectAllVideos();
        return $videos;
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
        $vid_man = new VideoObjManager();
        $per_page = 5;
        $cnt = $vid_man->getCount();
        if (($cnt % $per_page) == 0) {
            $pages_cnt = $cnt / $per_page;
        } else {
            $pages_cnt = floor($cnt / $per_page) + 1;
        }
        return $pages_cnt;
    }

    public function getLabelsArray($lang)
    {
        $vm = new VideoObjManager();
        $vidArray = $vm -> selectAllVideos();
        if ($vidArray != null) {
            $res = $this->getVideosLabels($vidArray, $lang);
        } else {
            $res = array();
        }
        return $res;
    }

    private function getVideosLabels($videos, $lang)
    {
        if (!(sizeof($videos) > 0)) {
            return '';
        };

        $all_labels = array();
        foreach ($videos as $video) {
            $id = $video->getID();
            $desc = $video->getDescription($lang);
            $all_labels["video_".$id] = $desc;
        }

        return $all_labels;
    }
}

?>










