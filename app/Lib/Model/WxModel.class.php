<?php
/**
 * 微信数据模型
 */
class WxModel extends Model
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    private function getTpl($type="text"){
        if($type == "text"){
            $tpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
                </xml>";
        }elseif($type == "txp"){
            $tpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                </Articles>
                </xml> ";
        }else{
            $tpl = '';
        }
        return $tpl;
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){               
          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
			if(!empty( $keyword ))
            {            
                $textReplay = D('Text')->where("content='".$keyword."'")->getField('replay');
                $newsReplay = D('Txp')->where("keyword='".$keyword."'")->find();
                //print_r($newsReplay);exit;
            	if(!empty($textReplay)){
            		$contentStr = $textReplay;
                    $msgType = "text";
                    $tpl = $this->getTpl();
                    $resultStr = sprintf($tpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            	}elseif(!empty($newsReplay)){
                    $msgType = "txp";
                    $tpl = $this->getTpl("txp");
                    $resultStr = sprintf($tpl, $fromUsername, $toUsername, $time, $msgType,
                        $newsReplay['title'], $newsReplay['description'], $newsReplay['pic'], $newsReplay['url']);
                }else{
                    $contentStr = "nothing";
                    $msgType = "text";
                    $tpl = $this->getTpl();
                    $resultStr = sprintf($tpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                }
                echo $resultStr;
            }else {
    	       echo "nothing";
    	       exit;
            }
        }else{
            echo "nothing";
            exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}