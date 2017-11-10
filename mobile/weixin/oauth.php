<?php
require(dirname(__FILE__) . '/api.class.php');
require(dirname(__FILE__) . '/wechat.class.php');

//多微信帐号支持
$weixinconfig = $db->getRow ( "SELECT * FROM " . $GLOBALS['yp']->table('weixin_config') . " WHERE `id` = 1" );
//多微信帐号支持
$id = intval($_GET['id']);
$oid = intval($_GET['oid']);

if($id > 0){
	$otherconfig = $db->getRow ( "SELECT * FROM " . $GLOBALS['yp']->table('weixin_config') . " WHERE `id` = $id" );
	if($otherconfig){
		$weixinconfig['token'] = $otherconfig['token'];
		$weixinconfig['appid'] = $otherconfig['appid'];
		$weixinconfig['appsecret'] = $otherconfig['appsecret'];
	}
}
$weixin = new core_lib_wechat($weixinconfig);
if($_GET['code']){
	$json = $weixin->getOauthAccessToken();
	if($json['openid']){
		$user_info = $GLOBALS['db']->getRow("select * from " . $GLOBALS['yp']->table('users') . " where fake_id='{$json['openid']}'");
		if($user_info ){
			$username = $user_info ['user_name'];
			$GLOBALS['user']->set_session($username);
			$GLOBALS['user']->set_cookie($username,1);
			update_user_info();  //更新用户信息
			recalculate_price(); //重新计算购物车中的商品价格
		}
	}
	$url = $api->dir."/mobile/user.php";
	if($oid > 0){
		$url = $db->getOne ( "SELECT weburl FROM " . $GLOBALS['yp']->table('weixin_oauth') . "
 WHERE `oid` = $oid" );
		$db->query("update " . $GLOBALS['yp']->table('weixin_oauth') . "
 set click=click+1 WHERE `oid` = $oid ");
	}
	header("Location:$url");exit;
}
$url = $GLOBALS['yp']->url()."/oauth.php?id={$id}&oid={$oid}";
$url = $weixin->getOauthRedirect($url,1,'snsapi_base');
header("Location:$url");exit;