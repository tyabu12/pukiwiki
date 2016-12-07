<?php
/////////////////////////////////////////////////
// ネットの動画表示プラグイン
// netvideos.inc.php
//
// Copyright(c) 2006 KERBEROS.
// for PukiWiki(http://heeha.ws)
//
// 例
//
// #netvideos("NGrrPReQaOE");
// #netvideos("NGrrPReQaOE",400,326);
// #netvideos("NGrrPReQaOE");
// #netvideos("NGrrPReQaOE",,,center);
// WIDTH,HEIGHT,align(位置)は省略しても大丈夫です。(多分)
//
// 下記のように省略した場合は
// #netvideos("NGrrPReQaOE");
// 結果的に
// #netvideos("NGrrPReQaOE",320,240,left,youtube);
// と同義になります。
//
// 元々の出力例(YouTube)
//
//http://www.youtube.com/watch?v=NGrrPReQaOE
//
//上記を表示したい場合は
//#netvideos("NGrrPReQaOE");
//と入力すれば動画で表示されます。
//
// 元々の出力例(google video)
//
//http://video.google.com/videoplay?docid=-7910649887561614606
//
//上記を表示したい場合は
//#netvideos("-7910649887561614606",,,,googlevideo);
//上記省略表示と同義
//#netvideos("-7910649887561614606",320,240,left,googlevideo);
//
//
// 下記URLで公開されているYOU TUBE版を勝手に修正しただけです。
// 問題があれば即公開中止します。
// http://www.ninjatips.org/index.php?Youtube%C6%B0%B2%E8%C9%BD%BC%A8%A5%D7%A5%E9%A5%B0%A5%A4%A5%F3
// http://pukiwiki.sourceforge.jp/?%E8%87%AA%E4%BD%9C%E3%83%97%E3%83%A9%E3%82%B0%E3%82%A4%E3%83%B3%2Fyoutube.inc.php
//
//変更履歴
//2007-02-20 リリース）




function plugin_netvideos_convert(){
	$args = func_get_args();
	return draw_tag_netvideos($args);
}


function plugin_netvideos_inline(){
	$args = func_get_args();
	return draw_tag_netvideos($args,"TRUE");
}

function draw_tag_netvideos($args,$inline = FALSE)
{
	if ($args < 1) return FALSE;

	$name = rawurlencode(trim($args[0]));
	$width = htmlspecialchars(trim($args[1]));
	$height = htmlspecialchars(trim($args[2]));
	$align = htmlspecialchars(trim($args[3]));
	$service = htmlspecialchars(trim($args[4]));
	$high = rawurlencode(trim($args[5]));
	$css = rawurlencode(trim($args[6]));
	//print "<hr>{$service}<hr>";

	//高画質モードなら
	if($high == 'high'){
		$high_tag = '&ap=%2526fmt%3D22';
	}else{
		$high_tag = '';
	}

	//もしインライン型なら
	if($inline){
		$element = 'span';
	}else{
		$element = 'div';
	}

	if($width == "" or preg_match("|\D|","$width"))
         {
	   $width = "320";
	 }

	if($height == "" or preg_match("|\D|","$height"))
         {
	   $height = "240";
	 }

	//rightまたはcenter以外の文字列または指定しなかった場合はleftに
	if($align == "right"){
		$align = "right";
	}elseif($align == "center"){
		$align = "center";
	}else{
		$align = "left";
	}

	//style自体を用意
	$style = 'style="text-align: ' . $align . ';"';
	if($align === "left" || $css === "true"){  //left指定とcssオンリーモードの場合はstyle属性は無し
		$style = '';
	}

	$align_class = $align;   //cssのclassに位置指定情報も一応付加



	if($service == "guba"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
			<embed src="http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/{$name}/flash.flv&isEmbeddedPlayer=true" quality="best" bgcolor="#FFFFFF" menu="true" width="{$width}px" height="{$height}px" name="root" id="root" align="middle" scaleMode="auto" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
			</embed>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif( $service == "dmotion" || $service == "dailymotion"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
			<object width="{$width}" height="{$height}">
				<param name="movie" value="http://www.dailymotion.com/swf/video/{$name}"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowScriptAccess" value="always"></param>
				<param name="wmode" value="transparent"></param>
				<embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/{$name}" width="{$width}" height="{$height}" wmode="transparent" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif( $service == "toget" || $service == "togetter"){

		//幅と高さtogetterは独自
		$width = htmlspecialchars(trim($args[1]));
		if($width == "" or preg_match("|\D|","$width")){
		   $width = "auto";
		}else{
			$width = $width . 'px';
		}

		$height = htmlspecialchars(trim($args[2]));
		if($height == "" or preg_match("|\D|","$height")){
		   $height = "auto";
		}else{
			$height = $height . 'px';
		}

		//style自体を用意 togetterはちょっと構造違うので個別
		$style = "height:{$height}; width:{$width};";

		if($align === "left"){
			$style .= 'margin-right:auto;';
		}elseif($align === "center"){
			$style .= 'margin:auto;';
		}elseif($align === "right"){
			$style .= 'margin-left:auto;';
		}

		//$style .= 'background-color: #F9F9F9;';

		if($css === "true"){  //cssオンリーモードの場合はstyle属性は無し
			$style = '';
		}

		$body = <<< EOF
		<{$element} style="{$style}" class="netvideo {$align_class}">
			<script src="http://togetter.com/js/parts.js"></script><script>tgtr.ExtendWidget({id:'{$name}',url:'http://togetter.com/'});</script>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service == "vimeo"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
			<object width="{$width}" height="{$height}">
				<param name="allowfullscreen" value="true" />
				<param name="allowscriptaccess" value="always" />
				<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id={$name}&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" />
				<embed src="http://vimeo.com/moogaloop.swf?clip_id={$name}&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{$width}" height="{$height}">
				</embed>
			</object>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service == "veoh"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
			<object width="{$width}" height="{$height}" id="veohFlashPlayer" name="veohFlashPlayer">
				<param name="movie" value="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.3.8.1003&permalinkId={$name}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous"></param>
				<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
				<embed src="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.3.8.1003&permalinkId={$name}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed>
			</object>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service == "zoome"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
		<embed name=zp pluginspage=http://www.macromedia.com/go/getflashplayer align=middle src=http://www.zoome.jp/swf/zpmmdiap.swf width={$width} height={$height} type=application/x-shockwave-flash allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" flashvars="baseDom=&amp;baseXML={$name}&amp;newThumb=1" quality="high">
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service == "nico"){
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
		<script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/{$name}"></script>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service == "pandora"){
		$pandora = split('::' , urldecode($name));	//パンドラはユーザIDも必要なので ユーザID::動画ID という形式で来る
		$userid = htmlspecialchars($pandora['0']);
		$name = htmlspecialchars($pandora['1']);
		$body = <<< EOF
		<{$element} {$style} class="netvideo {$align_class}">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="{$width}" height="{$height}" id="movie" align="middle">
			<param name="quality" value="high" />
			<param name="movie" value="http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid={$userid}&prgid={$name}&countryChk=jp&skin=1" />
			<param name="allowScriptAccess" value="always" /> <param name="allowFullScreen" value="true" /> <param name="wmode" value="transparent" />
			<embed src="http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid={$userid}&prgid={$name}&countryChk=jp&skin=1" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" width="{$width}" height="{$height}" />
		</object>
		</{$element}>
EOF;
		return $body . "\n";

	}elseif($service != "googlevideo"){
	   $url = 'http://www.youtube.com/v/';
	   //print "<hr>{$url}<hr>";

	}else{
	   $url = 'http://video.google.com/googleplayer.swf?docId=';
	   //print "<hr>{$url}<hr>";
	}

	$body = '<' . "$element" . " class=\"netvideo {$align_class}\" " . $style . '>
	<object type="application/x-shockwave-flash" data="' . $url . "$name" . "{$high_tag}&fs=1&hl=ja" . '" width="' . $width . '" height="' . $height . '">
	<param value="true" name="allowFullScreen"/>
	<param name="movie" value="' . "$url" . "$name" . "{$high_tag}&fs=1&hl=ja" . '"/></object></' . "$element" . '>';


	return $body . "\n";

}


?>
