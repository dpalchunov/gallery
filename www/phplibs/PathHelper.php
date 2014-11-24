<?php
/**
 * Created by IntelliJ IDEA.
 * User: dpalchunov
 * Date: 23/11/14
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */

class PathHelper
{

    public static function splitPath($path)
    {
        $pieces = explode("/", $path);
        return $pieces;
    }

    public static function joinPath()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists(get_class(), $f = 'joinPath' . $i)) {
            return call_user_func_array(array(get_class(), $f), $a);
        }

    }

    public static function joinPath3(array $arr, $leftBorder, $length)
    {
        $sliced_arr = array_slice($arr, $leftBorder, $length);
        $res = join('/', $sliced_arr);
        return $res;
    }

    public static function joinPath2(array $arr, $leftBorder)
    {
        $sliced_arr = array_slice($arr, $leftBorder);
        $res = join('/', $sliced_arr);
        return $res;
    }


    public static function joinPath1(array $arr)
    {
        $res = self::joinPath($arr, 0);
        return $res;
    }

    public static function cut_root($path)
    {
        $sp = self::splitPath($path);
        $res = self::joinPath($sp, 1);
        return $res;
    }

}




