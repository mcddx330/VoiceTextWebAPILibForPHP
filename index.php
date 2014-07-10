<?php
require 'vendor/autoload.php';

require_once("lib/voicetext_api.php");
require_once("lib/key.php");

function _h($t){
  htmlspecialchars_decode($t, ENT_NOQUOTES);
  return($t);
}

$app = new \Slim\Slim(array('templates.path' => './view'));

$app->get('/', function () use($app) {
  $app->render("top.php",array("res"=>null));
});

$app->post('/', function() use($app){
  global $key;
  $r = $app->request();

  $vt = new VoiceTextAPI();
  $vt->key = $key;
  $vt->text = _h($r->post("text"));
  $vt->speaker = _h($r->post("speaker"));
  $vt->emote = _h($r->post("emotion"));
  $vt->level = _h($r->post("emotion_level"));
  $vt->pitch = _h($r->post("pitch"));
  $vt->speed = _h($r->post("speed"));
  $vt->volume = _h($r->post("volume"));
  $vt->savedir = "./wav/";
  //$vt->savename = "out.wav";
  $vt->savename = date("Ymd_His")."_".$vt->speaker.".wav";

  $res = $vt->run();

  if(isset($res["path"])){
    exec("lame ".$res["path"]." ".$res["path"].".mp3");
  }

  $_POST = array();
  $app->render("top.php",array("res"=>$res));
});

$app->run();
?>