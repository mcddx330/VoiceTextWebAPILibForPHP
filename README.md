VoiceTextWebAPILibForPHP
=====================

VoiceTextWebAPILib forPHPは、VoiceText WebAPIをPHPで利用可能にするライブラリです。

**必要なもの**
 - php5-curl

**使い方**

```
require("voicetext_api.php");

$vt = new VoiceTextAPI();

$vt->key = API Key;

$vt->text = 文章;

$vt->speaker = show / haruka / hikari / takeru;

$vt->emote = happiness / anger / sadness;

$vt->level = 1 / 2;

$vt->pitch = 50 - 200;

$vt->speed = 50 - 400;

$vt->volume = 50 - 200;

$vt->savedir = 保存先のディレクトリ(デフォルトは同APIと同じ場所);

$vt->savename = 保存するファイル名(デフォルトは"output.wav)

$res = $vt->run();


```

**結果**

***生成成功時***

 - path : wavまでのパス

 - msg : 不正な値が検出された時に出力（現時点ではショウ君に表情パラメータを付加した時のみ）
***生成失敗時***

 - code : HTTPコード200番以外を受け取った時に出力

 - err : 音量などのパラメータが不正な時に出力

**サンプル**

[ここ](http://github.marbleritz.info/VoiceTextWebAPILibForPHP/)

**ライセンス**

MIT License