<?php

require_once('vendor/autoload.php');

use Cake\Http\Client;
use Cake\Filesystem\File;

$http = new Client();
$logout = 'http://ssolrs.lrs.co.id/logout';
$http->get($logout);

$url = 'http://ssolrs.lrs.co.id/login';
$getResponse = $http->get($url);
$getBody = $getResponse->getStringBody();

$pos = strpos($getBody, 'hexMD5');
$string = substr($getBody, $pos,114);
$string = str_replace('hexMD5(', '', $string);
$string = str_replace("'", '', $string);
$string1 = substr($string, 0,4);
$string2 = substr($string,39);

$octdec = octdec($string1);
$chr1 = chr($octdec);
$chr2 = '';
$explode = explode('\\', $string2);
unset($explode[0]);

foreach($explode as $chr){
    $c = '\\'.$chr;
    $octdec = octdec($c);
    //debug($octdec);
    $chr2 .= chr($octdec);
}

$file = new File('/home/yosi/user.json');
$user = json_decode($file->read(), true);
$file->close();

$string = $chr1 . $user['password'] . $chr2;
$bytes_array = unpack('C*', $string);
$md5 = md5($string);
$response = $http->post($url, [
    'username' => $user['username'],
    'password' => $md5
]);
if($response){
    echo "LRS Network Connected\n";
}

?>