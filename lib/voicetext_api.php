<?php
	/* 
		PHP上でVoiceText CloudAPIを使用する際に必要最低限なものを詰め込みました。

		key : APIキー
		text : 喋らせたいテキスト（200文字まで）
		speaker : 喋らせたいキャラクタ名
		emote : 表情
		level : 表情レベル
		pitch : 発話のピッチ
		speed : 読む速さ
		volume : 発話の音量
		savedir : 保存先のディレクトリ名
		savename : wavファイルの保存名

		savedirとsavenameを分けているのは、日付などの値でディレクトリやファイルを指定して保存したい時等の為に用意しています。

		2014.07.10 dimbow. @mcddx330
	*/

	class VoiceTextAPI{
		/* APIで使うパラメータ */
		public $key = "";
		public $text = "";
		public $speaker = "";
		public $emote = "";
		public $level = "";
		public $pitch = "";
		public $speed = "";
		public $volume = "";
		public $savedir = "";
		public $savename = "";
		
		public function run(){
			//VoiceText CloudAPIのURL
			$apiurl = "https://api.voicetext.jp/v1/tts";

			//保存ディレクトリを指定していない場合は、このクラスPHPのあるディレクトリ直下に。
			if(mb_strlen($this->savedir)==0){
				$this->savedir = "./";
			}else{
				if(!is_dir($this->savedir)){
					mkdir($this->savedir,0755);
				}
			}
			//ファイル名を指定していない場合は、"output.wav"として保存。
			if(mb_strlen($this->savename)==0){
				$this->savename = "output.wav";
				unlink($this->savedir."output.wav");
			}
			//スピーカーが仮に設定されていなかった場合は、ショウ君を選ぶ
			if(mb_strlen($this->speaker)==0){
				$this->speaker = "show";
			}
			//ショウ君が選ばれている時に表情、表情レベルパラメータが選ばれている場合は無効化する
			if(isset($this->emote)==true && $this->speaker==="show"){
				$this->emote=null;
				$this->level=null;
				$msg = "ショウ君には表情、表情レベルの調整がかけられないため、デフォルト値で処理しました。";
			}else{
				$msg = null;
			}
			if(isset($this->text) && mb_strlen($this->text)>200){
				$err = "発話させたい文章が200文字を超えています。";
			}
			elseif(isset($this->pitch) && ($this->pitch<50 || $this->pitch>200)){
				$err = "発話のピッチは50%から200%の間にしてください。";
			}
			elseif(isset($this->speed) && ($this->speed<50 || $this->speed>400)){
				$err = "読む速さは50%から400%の間にしてください。";
			}
			elseif(isset($this->volume) && ($this->volume<50 || $this->volume>200)){
				$err = "発話の音量は50%から200%の間にしてください。";
			}

			if(isset($err)){
				return(array("err"=>$err));
			}else{
				//パラメータを配列に格納
				$que = array(
					     "text"=>$this->text,
				 	     "speaker"=>$this->speaker,
					     "emotion"=>$this->emote,
					     "emotion_level"=>$this->level,
					     "pitch"=>$this->pitch,
					     "speed"=>$this->speed,
					     "volume"=>$this->volume
					    );
				$ch = curl_init();

				//cURLのオプション整理
				$opts = [CURLOPT_URL=>$apiurl,
							      CURLOPT_SSL_VERIFYPEER=>false,
							      CURLOPT_USERPWD=>"$this->key:",
							      CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
							      CURLOPT_RETURNTRANSFER=>true,
							      CURLOPT_HEADER=>true,
							      CURLOPT_VERBOSE=>true,
							      CURLOPT_POSTFIELDS=>http_build_query($que)];
				curl_setopt_array($ch, $opts);
				//レスポンス内容
				$out = curl_exec($ch);
				//レスポンスデータのヘッダ情報
				$info = curl_getinfo($ch);
				curl_close($ch);
				if($info["http_code"]==200){
					//生成に成功した時にwavファイルを吐き出し、パスを返す
					$wavdata = mb_substr($out,$info["header_size"],mb_strlen($out)-$info["header_size"]);
					file_put_contents($this->savedir.$this->savename,$wavdata);
					$ret = array("path"=>$this->savedir.$this->savename);
					$ret["msg"] = $msg;
				}else{
					//生成に失敗した場合はHTTPコードを返す
					$ret = array("code"=>$info["http_code"]);
				}
				return ($ret);
			}
		}
	}
?>