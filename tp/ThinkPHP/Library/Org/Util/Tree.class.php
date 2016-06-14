<?php
/**
* 通用的树型类，可以生成任何树型结构
*/
namespace Org\Util;

class Tree
{
    static public $treeList = array();

    static public function create($data, $pid = 0){
        foreach($data as $k=>$v){
            if($v['pid'] == $pid){
                self::$treeList[] = $v;
                unset($data[$k]);
                self::create($data, $v['id']);
            }
        }
        return self::$treeList;
    }
}
?>