<?php
/**
 * 微信接口控制器
 * @author zhong
 * @version 2014.07.24
 */
class WxAction extends BaseAction
{
	public function api()
	{
		$wxObj = D('Wx');
		$wxObj->responseMsg();
	}
}