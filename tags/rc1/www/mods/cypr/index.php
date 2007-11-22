<?php
/*
 * Created on FLEX 17.04.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if ( !function_exists('file_put_contents') && !defined('FILE_APPEND') ) {
   $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
    $f = @fopen($n, $mode);
    if ($f === false) {
        return 0;
    } else {
        if (is_array($d)) $d = implode($d);
        $bytes_written = fwrite($f, $d);
        fclose($f);
        return $bytes_written;
    }
   }
function getCyr($url){
	if (!strstr('http://', $url)) { $url='http://'.$url; }
	if(file_exists($_SERVER["DOCUMENT_ROOT"].'/storage/File/cypr.xml')){
		$secs = time() - filectime($_SERVER["DOCUMENT_ROOT"].'/storage/File/cypr.xml');
		if($secs > 360) {
			$profile = file_get_contents("http://bar-navig.yandex.ru/u?ver=2&url=$url&show=1&post=1");
			file_put_contents($_SERVER["DOCUMENT_ROOT"].'/storage/File/cypr.xml',$profile);
		}else{
			$profile = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/storage/File/cypr.xml');
		}
	}else{
		$profile = file_get_contents("http://bar-navig.yandex.ru/u?ver=2&url=$url&show=1&post=1");
		file_put_contents($_SERVER["DOCUMENT_ROOT"].'/storage/File/cypr.xml',$profile);
	}
	$xml = new SimpleXMLElement($profile);
	$attr = $xml->tcy->attributes();	
	return $attr;
}
#########################################
//settings - host and user agent
$googlehost='toolbarqueries.google.com';
$googleua='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5';

//convert a string to a 32-bit integer
function StrToNum($Str, $Check, $Magic) {
    $Int32Unit = 4294967296;  // 2^32

    $length = strlen($Str);
    for ($i = 0; $i < $length; $i++) {
        $Check *= $Magic; 	
        //If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31), 
        //  the result of converting to integer is undefined
        //  refer to http://www.php.net/manual/en/language.types.integer.php
        if ($Check >= $Int32Unit) {
            $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
            //if the check less than -2^31
            $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
        }
        $Check += ord($Str{$i}); 
    }
    return $Check;
}

//genearate a hash for a url
function HashURL($String) {
    $Check1 = StrToNum($String, 0x1505, 0x21);
    $Check2 = StrToNum($String, 0, 0x1003F);

    $Check1 >>= 2; 	
    $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
    $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
    $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);	
	
    $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
    $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
	
    return ($T1 | $T2);
}

//genearate a checksum for the hash string
function CheckHash($Hashnum) {
    $CheckByte = 0;
    $Flag = 0;

    $HashStr = sprintf('%u', $Hashnum) ;
    $length = strlen($HashStr);
	
    for ($i = $length - 1;  $i >= 0;  $i --) {
        $Re = $HashStr{$i};
        if (1 === ($Flag % 2)) {              
            $Re += $Re;     
            $Re = (int)($Re / 10) + ($Re % 10);
        }
        $CheckByte += $Re;
        $Flag ++;	
    }

    $CheckByte %= 10;
    if (0 !== $CheckByte) {
        $CheckByte = 10 - $CheckByte;
        if (1 === ($Flag % 2) ) {
            if (1 === ($CheckByte % 2)) {
                $CheckByte += 9;
            }
            $CheckByte >>= 1;
        }
    }

    return '7'.$CheckByte.$HashStr;
}

//return the pagerank checksum hash
function getch($url) { return CheckHash(HashURL($url)); }

//return the pagerank figure
function getpr($url) {
	global $googlehost,$googleua;
	if (!preg_match('/^(http:\/\/)?([^\/]+)/i', $url)) { $url='http://'.$url; }
	$ch = getch($url);
	$fp = fsockopen($googlehost, 80, $errno, $errstr, 30);
	if ($fp) {
	   $out = "GET /search?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
	   //echo "<pre>$out</pre>\n"; //debug only
	   $out .= "User-Agent: $googleua\r\n";
	   $out .= "Host: $googlehost\r\n";
	   $out .= "Connection: Close\r\n\r\n";
	
	   fwrite($fp, $out);
	   
	   //$pagerank = substr(fgets($fp, 128), 4); //debug only
	   //echo $pagerank; //debug only
	   while (!feof($fp)) {
			$data = fgets($fp, 128);
			//echo $data;
			$pos = strpos($data, "Rank_");
			if($pos === false){} else{
				$pr=substr($data, $pos + 9);
				$pr=trim($pr);
				$pr=str_replace("\n",'',$pr);
				return $pr;
			}
	   }
	   //else { echo "$errstr ($errno)<br />\n"; } //debug only
	   fclose($fp);
	}
}
#############################
$url = $_SERVER["HTTP_HOST"];
$cyr = getCyr($url);
$smarty->assign("pr",getpr($url));
$smarty->assign("cyr",$cyr);
$smarty->assign("url",$url);
$mod_template = "index.tpl";
//$smarty->display("cypr/index.tpl");
//exit;

?>
