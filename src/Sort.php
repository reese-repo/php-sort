<?php
/**
 * Author Tinker
 * Date 17-9-11
 * Time 下午4:25
 */


namespace tinker\sort;


class Sort
{
    public static function quickSort($array)
    {
        if (count($array[0]) <= 1) {
            return $array;
        }

        $middle = $array[0];
        $leftArray = [];
        $rightArray = [];

        foreach ($array as $value) {
            if ($value > $middle) {
                $rightArray[] = $value;
            } else {
                $leftArray[] = $value;
            }
        }

        $leftArray = self::quickSort($leftArray);
        $rightArray = self::quickSort($rightArray);

        return array_merge($leftArray, $middle, $rightArray);
    }

    public static function mergeSort($array)
    {
        $count = count($array);
        if ($count < 2) {
            return $array;
        }

        $middle = ceil($count / 2);
        $tmp = array_chunk($array,  $middle);

        $leftArray = self::mergeSort($tmp[0]);
        $rightArray = self::mergeSort($tmp[1]);

        $reg = [];
        while (count($leftArray) && count($rightArray)) {
            if ($leftArray[0] < $rightArray[0]) {
                $reg[] = array_shift($leftArray);
            } else {
                $reg[] = array_shift($rightArray);
            }
        }

        return array_merge($reg, $leftArray, $rightArray);
    }

    protected function swap(&$x, &$y)
    {
        $t = $x;
        $x = $y;
        $y = $t;
    }

    protected function maxHeapify(&$arr, $start, $end)
    {
        // 建立父节点指标和子节点指标
        $dad = $start;
        $son = $dad * 2 + 1;
        if ($son >= $end) //若子节点指标超过范围直接跳出函数
            return;

        // 先比较两个子节点大小，选择最大的
        if ($son + 1 < $end && $arr[$son] < $arr[$son + 1]) {
            $son++;
        }

        // 如果父节点小于子节点时，交换父子内容再继续子节点和孙节点比较
        if ($arr[$dad] <= $arr[$son]) {
            self::swap($arr[$dad], $arr[$son]);
            self::maxHeapify($arr, $son, $end);
        }
    }

    public static function heapSort($arr)
    {
        $len = count($arr);

        //初始化，i从最后一个父节点开始调整
        for ($i = floor($len / 2); $i >= 0; $i--) {
            self::maxHeapify($arr, $i, $len);
        }

        //先将第一个元素和已排好元素前一位做交换，再从新调整，直到排序完毕
        for ($i = $len - 1; $i > 0; $i--) {
            self::swap($arr[0], $arr[$i]);
            self::maxHeapify($arr, 0, $i);
        }
        return $arr;
    }
}