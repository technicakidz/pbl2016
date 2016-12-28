<?php
require 'vendor/autoload.php';
use Goutte\Client;
$client = new Client();

$url = '*****対象のURLが入ります*****';
$crawler = $client->request('GET',$url);

// 押して検索するボタン
$form = $crawler->selectButton('search')->form();

// 検索したいキーワード
$searchParameters = [
    'keyword'       => '*****検索したいキーワードが入ります*****',
    'searchtarget'  => 'BK',
];

// キーワード検索結果の取得
$crawler = $client->submit($form, $searchParameters);

// 抽出情報の絞込
$test = $crawler->filter('div.bib-list-check ol li.book-item')->each(
    function($element) {
        if(count($element->filter('p.item-title a'))){
            // $rslt['title'] = $result['title']    = $element->filter('p.item-title a')->text();
            $rslt['title']  = str_replace(
                array("\r\n", "\r", "\n"),'',$element->filter('p')->eq(0)->text());
            $rslt['author'] = str_replace(
                array("\r\n", "\r", "\n"),'',$element->filter('p')->eq(1)->text());
            $rslt['place']  = str_replace(
                array("\r\n", "\r", "\n"),'',$element->filter('p')->eq(2)->text());
            return $rslt;
    }
});
print_r($test);
