<?php
//グーグルスプレッドシートのデータを関数化する
function getData() {
	require __DIR__. '/vendor/autoload.php';

	//ダウンロードしたファイル
	$keyFile = __DIR__. "/linebot-4d3669a28a66.json";//取得したサービスキーのパスを指定

	$client = new Google_Client();//Googleクライアントインスタンスを作成
	$client->setScopes([//スコープを以下の内容でセット
		\Google_Service_Sheets::SPREADSHEETS,
		\Google_Service_Sheets::DRIVE,]);
	$client->setAuthConfig($keyFile);//サービスキーをセット

	$sheet = new Google_Service_Sheets($client);//シートを操作するインスタンス
	$sheet_id = '1rtim-UCUhFGs5wFoMHSHI7tuB36aJwSDfrKQXXwCEkE';//対象のスプレッドシートのIDを指定
	$range = 'test!A1:C1575';//取得範囲を指定（dataシートのA1〜B8）
	$response = $sheet->spreadsheets_values->get($sheet_id, $range);
	$values = $response->getValues();//帰ってきたresponseから値を取得
	return $values;
}

// 気分による分岐
if ($message['text'] === 'スタミナがつく料理') {
	$feeling_name = $message['text'];
} elseif ($message['text'] === '二日酔いに効く料理') {
	$feeling_name = $message['text'];
} elseif ($message['text'] === '食欲が出る料理') {
	$feeling_name = $message['text'];
} elseif ($message['text'] === '風邪気味に効く料理') {
	$feeling_name = $message['text'];
}

//返ってきた値を変数に格納
$values = getData();
//スプレッドシート内の値を検索するために最初にforeach
foreach ($values as $value) {
	$value['category_name'] = $value[0];
	$value['category_id'] = $value[1];
	$value['feeling_name'] = $value[2];
	unset ($value[0], $value[1], $value[2]);
	if (strpos($value['feeling_name'], $feeling_name) !== false) {
		$ids[] = $value;
	}
}

if ($ids) {
	require_once('makeCarousel.php');
}
?>
