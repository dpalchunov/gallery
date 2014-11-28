<?php
/**
 * Created by IntelliJ IDEA.
 * User: dpalchunov
 * Date: 23/11/14
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */

class ImageHelper
{

    public static function addBgAndShadow($srcFilePath)
    {


        $background = new ImagickPixel("#d2dfe3");
        $shadow_color = new ImagickPixel("black");

        try {

            $im = new Imagick($srcFilePath);
            $im->setImageFormat("png");

            $border = 25;
            $d = $im->getImageGeometry();
            $w = $d['width'];
            $h = $d['height'];
            if ($w < $h) {
                $min_d = $w;
            } else {
                $min_d = $h;
            }

            $sigma = ($border) / 4;
            $pic_w_offset = $border;
            $pic_h_offset = $border;
            $shad_w_offset = $border - 2 * $sigma;
            $shad_h_offset = $border - 2 * $sigma;


            $shadow = $im->clone();
            $shadow->setImageBackgroundColor($shadow_color);
            $shadow->shadowImage(90, $sigma, 0, 0);
            $canvas = new Imagick();
            $canvas->newImage($w + 2 * $border, $h + 2 * $border, $background);


            $canvas->compositeImage($shadow, imagick::COMPOSITE_OVER, $shad_w_offset, $shad_h_offset);
            $canvas->blurImage($sigma, 10);
            $canvas->compositeImage($im, imagick::COMPOSITE_OVER, $pic_w_offset, $pic_h_offset);

            $canvas->setImageFormat('png');

            $canvas->writeImage($srcFilePath);


            $canvas->clear();
            $canvas->destroy();

            return 'ok';

        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage() . "";
        }

    }

}




