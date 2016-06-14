<?php
/**
 * Created by PhpStorm.
 * User: liuchuanwei
 * Date: 2016/6/4
 * Time: 20:08
 */
namespace Admin\Model;
use Think\Model\RelationModel;
class NodeModel extends RelationModel {
    protected $_link = array(
        'Node' => array(
            'mapping_type'  =>  self::HAS_MANY,
            'mapping_name'  =>  'nodes',
            'mapping_order' =>  'sort',
            'parent_key'    =>  'pid',
            'condition'     =>  'type!=4'
        )
    );
}