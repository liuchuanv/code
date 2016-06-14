<?php
/**
 * Created by PhpStorm.
 * User: liuchuanwei
 * Date: 2016/6/5
 * Time: 20:39
 */

/**
 * 递归重组节点信息多维数组
 * @param  [array] $node [要处理的节点数组:二维数组]
 * @param  [int]   $pid  [父级ID]
 * @return [array]       [树状结构的节点体系:多维数组]
 */
//function node_merge($node,$pid=0){
//    $arr=array();
//    foreach ($node as $v) {
//        if ($v['pid']==$pid) {
//            $v['child']=node_merge($node,$v['id']);
//            $arr[]=$v;
//        }
//    }
//    return $arr;
//}