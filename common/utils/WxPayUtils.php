<?php

namespace app\common\utils;


class WxPayUtils{
	
	/**
	 * Generate a nonce string
	 *
	 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=4_3
	 */
	function generateNonce()
	{
		return md5(uniqid('', true));
	}
	
	/**
	 * Get a sign string from array using app key
	 *
	 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=4_3
	 */
	function calculateSign($arr, $key)
	{
		ksort($arr);
	
		$buff = "";
		foreach ($arr as $k => $v) {
			if ($k != "sign" && $k != "key" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
	
		$buff = trim($buff, "&");
	
		return strtoupper(md5($buff . "&key=" . $key));
	}
	
	/**
	 * Get xml from array
	 */
	function getXMLFromArray($arr)
	{
		$xml = "<xml>";
		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= sprintf("<%s>%s</%s>", $key, $val, $key);
			} else {
				$xml .= sprintf("<%s><![CDATA[%s]]></%s>", $key, $val, $key);
			}
		}
	
		$xml .= "</xml>";
	
		return $xml;
	}
	
	/**
	 * Generate a prepay id
	 *
	 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=9_1
	 */
	function generatePrepayId($app_id, $mch_id, $app_key, $body, $total_fee, $notify_url)
	{
		$params = array(
				'appid'            => $app_id,
				'mch_id'           => $mch_id,
				'nonce_str'        => $this->generateNonce(),
				'body'             => $body,
				'out_trade_no'     => time(),
				'total_fee'        => $total_fee,
				'spbill_create_ip' => '8.8.8.8',
				'notify_url'       => $notify_url,
				'trade_type'       => 'APP',
		);
	
		// add sign
		$params['sign'] = $this->calculateSign($params, $app_key);
	
		// create xml
		$xml = $this->getXMLFromArray($params);
	
	
	
		// send request
		$ch = curl_init();
	
		curl_setopt_array($ch, array(
				CURLOPT_URL            => "https://api.mch.weixin.qq.com/pay/unifiedorder",
				CURLOPT_POST           => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER     => array('Content-Type: text/xml'),
				CURLOPT_POSTFIELDS     => $xml,
				CURLOPT_SSL_VERIFYPEER => false
		));
	
		$result = curl_exec($ch);
		//var_dump(curl_error($ch));
		curl_close($ch);
	
		// get the prepay id from response
		$xml = simplexml_load_string($result);
		//var_dump($result);
		return (string)$xml->prepay_id;
	}
	
}