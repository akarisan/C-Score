<?php
//SESSION化
session_start();

//アップロード処理
$tempfile = $_FILES['file']['tmp_name'];    #仮ファイル置き場取得
$filename = $_FILES['file']['name'];        #ファイル名取得

//TEMPから同フォルダ内にJSON移動
if (is_uploaded_file($tempfile)) {
    if ( move_uploaded_file($tempfile , $filename )) {
	echo "OK";
    } else {
        echo "FAILED";
    }
} else {
    echo "NOENTRY";
} 

//文字列読み込み
$json = file_get_contents('c-score.json');

//BOM削除
$json = substr($json,2);

//ダブルクオーテーション変換
$json = str_replace('&quot;','"',$json);

//文字列コンバート
$json = mb_convert_encoding($json,'UTF-8','UTF-16LE');

//連想配列化
$array = json_decode($json, true);


//配列から参考・空白削除
$classes = array();
$competitors = array();

foreach($array as $arr_classes => $arr_class){
    $class_arr = array();
    $competitor_arr = array();
    $class_rank = 0;
    $class_team = "";
    $class_name = $arr_classes;
    foreach($arr_class as list($class_rank,$class_team,$class_competitor)){
        if($class_rank === "参" or $class_rank === "" or $class_team === ""){
            
        }else{
            $class_rank = intval($class_rank); array_push($class_arr,array($class_team,$class_rank));
            array_push($competitor_arr,array($class_rank,$class_competitor,$class_team));
        }
    }
    $classes = $classes + array($arr_classes => $class_arr);
    $competitors = $competitors + array($arr_classes => $competitor_arr);
}
print_r($competitors);

//更新前のスコア挿入
require_once('before_point_move.php');

//チームごとのポイント化呼び出し
require_once('rank_input.php');

//選手の登録
require_once('competitor_input.php');
?>