<?php

class  FileLoader {
    public function uploadFiles($files,$output_url) {

            $ret = array();

            if(!is_array($files["name"])) //single file
            {
                move_uploaded_file($files["tmp_name"],$output_url.$files["persist_name"]);
                $ret[]= $output_url.$files["persist_name"];
            }
            else  //Multiple files, file[]
            {
                $fileCount = count($files["name"]);
                for($i=0; $i < $fileCount; $i++)
                {
                    $fileName = $files["name"][$i];
                    move_uploaded_file($files["tmp_name"][$i],$output_url.$fileName);
                    $ret[]= $output_url.$fileName;
                }

            }
            return $ret;
    }




}
?>