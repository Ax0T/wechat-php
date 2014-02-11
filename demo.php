<?php
include "ax2.wechat.class.php";
include "ax2.session.class.php";

function logm($msg)
{
      sae_set_display_errors(false);//关闭信息输出
      sae_debug($msg);//记录日志
      sae_set_display_errors(true);//记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
};

$options = array(
                'token'=>'yourtoken', //填写你设定的key
                'debug'=>true,
                'logcallback'=>'logm'
        );

$weObj = new Wechat($options);
$weObj->valid();
$type = $weObj->getRev()->getRevType();

$ws=new Session($weObj->getRevFrom());

switch($type) {
        case Wechat::MSGTYPE_TEXT:
                        $rr=$ws->get('test');
                        if($rr===false) $ws->add('test',$weObj->getRevContent());
                        $ws->set('test',$weObj->getRevContent());
                        $weObj->text('last msg:'.$rr)->reply();
                        exit;
                        break;
        case Wechat::MSGTYPE_EVENT:
                        {
                                $e=$weObj->getRevEvent();
                                if($e['event']=='subscribe')
                                  $weObj->text('welcome')->reply();
                                if($e['event']=='unsubscribe')
                                  logm('unsubscribe');
                        }
                        break;
        case Wechat::MSGTYPE_IMAGE:
                        $weObj->text("Pic rev")->reply();
                        exit;
                        break;
        case Wechat::MSGTYPE_VIDEO:
                        $weObj->text("video rev")->reply();
                        exit;
                        break;
        case Wechat::MSGTYPE_VOICE:
                        $weObj->text("voice rev")->reply();
                        exit;
                        break;
        case Wechat::MSGTYPE_LOCATION:
                        $weObj->text("location rev")->reply();
                        exit;
                        break; 
        case Wechat::MSGTYPE_LINK:
                        $weObj->text("link rev")->reply();
                        exit;
                        break;                       
        default:
                        $weObj->text("help info")->reply();
}

