# php-sso-lrs
Auto koneksi ke SSO LRS dengan menggunakan Plugin <b>Http Client</b> CakePHP 4

## Requirements
- Jaringan Internal LRS yang membutuhkan SSO Login untuk mengakses internet
- php-cli
- Requirement for install CakePHP 4
  - PHP: Min 7.4
  - PHP Extension: php-mbstring, php-intl
- Composer

## Cara Penggunaan

1. Masuk ke project folder
2. install php modules dengan <code>install composer</code>
3. ganti/sesuaikan username dan password SSO LRS di <code>user.json</code>
4. Koneksi ke jaringan dengan <code>php connect-sso-lrs.php</code>
