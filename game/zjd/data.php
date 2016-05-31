<?php

$prize_arr = array( 
    '0' => array('id'=>1,'prize'=>'ƽ�����','v'=>3), 
    '1' => array('id'=>2,'prize'=>'�������','v'=>5), 
    '2' => array('id'=>3,'prize'=>'�����豸','v'=>10), 
    '3' => array('id'=>4,'prize'=>'4G����','v'=>12), 
    '4' => array('id'=>5,'prize'=>'Q��10Ԫ','v'=>20), 
    '5' => array('id'=>6,'prize'=>'�´�û׼������Ŷ','v'=>50), 
); 
 
foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
} 
 
$rid = getRand($arr); //���ݸ��ʻ�ȡ����id 
$res['msg'] = ($rid==6)?0:1; //���Ϊ0��û�� 
$res['prize'] = $prize_arr[$rid-1]['prize']; //�н��� 
echo json_encode($res); 
 
//������� 
function getRand($proArr) { 
    $result = ''; 
 
    //����������ܸ��ʾ��� 
    $proSum = array_sum($proArr); 
 
    //��������ѭ�� 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
 
    return $result; 
} 

?>