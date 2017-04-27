<?php
use Beanbun\Beanbun;

require_once __DIR__ . '/vendor/autoload.php';

$beanbun = new Beanbun;
$beanbun->name = 'niaoyun';
$beanbun->count = 5;
$beanbun->seed = 'https://www.niaoyun.com/help/user/';
$beanbun->max = 30;
$beanbun->logFile = __DIR__ . '/niaoyun_access.log';
$beanbun->urlFilter = [
    '/https:\/\/www.niaoyun.com\/help\/user\/(\d+).html/',
];

// 设置队列
$beanbun->setQueue('memory', [
    'host' => '127.0.0.1',
    'port' => '2207',
]);

$beanbun->setDownloader(null, ['verify' => false]);

$beanbun->afterDownloadPage = function ($beanbun) {
    file_put_contents(__DIR__ . '/' . md5($beanbun->url) . '.html', $beanbun->page);
};
$beanbun->start();