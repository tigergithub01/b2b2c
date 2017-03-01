<?php
// Do a POST
$data="<xml><appid><![CDATA[wx2bfbd48633b358a1]]></appid>
<bank_type><![CDATA[CMB_DEBIT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[N]]></is_subscribe>
<mch_id><![CDATA[1266869501]]></mch_id>
<nonce_str><![CDATA[e140dbab44e01e699491a59c9978b924]]></nonce_str>
<openid><![CDATA[o_3BEw7bcm5lQ5g0ENFlAvvWntw4]]></openid>
<out_trade_no><![CDATA[so20161027000098172-12345]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[AB7BEEA0C0EEAA45724978115CEE93FD]]></sign>
<time_end><![CDATA[20150829004209]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[APP]]></trade_type>
<transaction_id><![CDATA[1007850014201508290734160336]]></transaction_id>
</xml>";

//$data = array('name' => 'Dennis', 'surname' => 'Pallett');

// $cul_url = 'http://'.$_SERVER['HTTP_HOST'].'/notify/wx/sdk/wxNotify.php';
$cul_url = 'http://'.$_SERVER['HTTP_HOST'].'/vip/api/member/order/so-sheet-pay-notify/wx-notify';

// create a new curl resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL,$cul_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// grab URL, and print
curl_exec($ch);
curl_close($ch);

exit();