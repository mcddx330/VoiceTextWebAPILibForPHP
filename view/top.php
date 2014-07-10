<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>VoiceText APIラッパーテスト</title>
</head>
<body>
    <form id="vtform" method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>">    
    <div><label for="text">テキスト</label></div>
    <div><input id="text" name="text" type="text" maxlength="200" value="おはようございます、なんだな。" size=50/> 
    <div><label for="speaker">話者 </label>
    <div>
        <option value="show" selected="selected">ショウ</option>
            <select id="speaker" name="speaker"> 
            <option value="show" >ショウ</option>
            <option value="haruka" >はるか</option>
            <option value="hikari" >ひかり</option>
            <option value="takeru" >たける</option>
        </select>
    </div>

    <div><label for="emotion">表情</label></div>
    <div>
        <select id="emotion" name="emotion"> 
    	    <option value="happiness">喜び</option>
    	    <option value="anger">怒り</option>
    	    <option value="sadness">悲しみ</option>
        </select>
    </div>

    <div><label for="emotion_level">表情レベル</label></div>
    <div>
        <select id="emotion_level" name="emotion_level"> 
    	    <option value="1">1</option>
    	    <option value="2">2</option>
        </select>
    </div>

    <div><label for="pitch">ピッチ</label></div>
    <div>
        <select id="pitch" name="pitch"> 
    	    <option value="50">50%</option>
    	    <option value="80">80%</option>
    	    <option value="100" selected>100%</option>
    	    <option value="125">125%</option>
    	    <option value="150">150%</option>
    	    <option value="200">200%</option>
        </select>
    </div>

    <div><label for="speed">速度</label></div>
    <div>
        <select id="speed" name="speed"> 
    	    <option value="50">50%</option>
    	    <option value="100" selected>100%</option>
    	    <option value="125">125%</option>
    	    <option value="150">150%</option>
    	    <option value="200">200%</option>
        </select>
    </div>

    <div><label for="volume">音量</label></div>
    <div>
        <select id="volume" name="volume"> 
    	    <option value="50">50%</option>
    	    <option value="80">80%</option>
    	    <option value="100" selected>100%</option>
    	    <option value="125">125%</option>
    	    <option value="150">150%</option>
    	    <option value="200">200%</option>
        </select>
    </div>
    <div><input type="submit" name="submit" value="Submit" /></div>
    </form>
  <hr>
  <p>結果... 
    <?php
      if(isset($res["msg"])){
        echo "不正な値 : ".$res["msg"];
      }elseif(isset($res["err"])){
        echo "エラー : ".$res["err"];
      }elseif(isset($res["code"])){
        echo "レスポンスエラー : ".$res["code"];
      }elseif(isset($res["path"])){
        echo "正常終了";
      }else{
        echo "なし";
      }
    ?>
  </p>
  <p><a href="<?=$res['path'];?>"><?=$res['path'];?></a></p>
    <?php
      if(isset($res["path"])){
echo <<< PLAY
              <object type="application/x-shockwave-flash" data="dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="dewplayer.swf" /> <param name="flashvars" value="mp3={$res['path']}.mp3&amp;showtime=1" /> </object>
PLAY;
      }
    ?>


</body>
</html>
