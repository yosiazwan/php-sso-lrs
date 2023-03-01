<?php

require_once('vendor/autoload.php');

use Cake\Http\Client;
use Cake\Filesystem\File;

$http = new Client();

// logout url
$logout = 'http://ssolrs.lrs.co.id/logout';
$login = 'http://ssolrs.lrs.co.id/login';
$status = 'http://ssolrs.lrs.co.id/status';

// logut jaringan apabila telah login
$http->get($logout); 

// baca halaman login untuk mendapatkan hash password
$getResponse = $http->get($login);
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

// baca konfigurasi username dan password
$file = new File('./user.json');
$user = json_decode($file->read(), true);
$file->close();

// gabungkan password dan hash nya
$string = $chr1 . $user['password'] . $chr2;
$bytes_array = unpack('C*', $string);
$md5 = md5($string);

// login kejaringan dengan username dan password yang telah dihash
$response = $http->post($login, [
    'username' => $user['username'],
    'password' => $md5
]);

// baca halaman status untuk memeriksa apakah telah berhasil login
$response = $http->get($status);
$halamanStatus = $response->getStringBody();
$pos = strpos($halamanStatus, $user['username']);

if ($pos) {
    echo "LRS Network Connected\n";
} else {
    echo "Gagal untuk koneksi\n";
}
?>