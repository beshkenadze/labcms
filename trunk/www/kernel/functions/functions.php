<?php
//подключаем класс для отправки почты
include dirname(__FILE__).'/mail/htmlMimeMail.php';

//боремся с magic_quotes
   function stripslashes_deep($value)
   {
       if( is_array($value) )
       {
             $value = array_map('stripslashes_deep', $value);
       }
       elseif ( !empty($value) && is_string($value) )
       {
             $value = stripslashes($value);
       }
       return $value;
   }

// Небольшая вспомогательная функция, выводящая сообщение
// в окно браузера и останавливающая выполнение скрипта
function puterror($msg, $debug=false)
{
	 echo "<p>".$msg."</p>";
 if ($debug || access("admin"))
 {
	 echo "<b>Error: ".mysql_error()."<b><br>";
	 echo "<pre>";
         if (substr(PHP_VERSION, 0, 1)==5) debug_print_backtrace();
         else   var_dump(debug_backtrace());
	 echo "</pre>";
 }
 exit();
}


///////////
// функция показывающай ошибку 404
function error404()
{
	global $smarty, $config;
	Header("HTTP/1.x 404 Not Found");
	Header("Date: " . gmdate("D, d M Y H:i:s") . " GMT");
	Header("Content-Type: text/html; charset=utf-8");
	$smarty->display("errors/404.tpl");

 exit;
}

////
// определение всех родителей
function full_path($id)
{
 global $core, $db;
//запрашиваем полную структуру дерева
 $result=$db->select("SELECT tree_id, parent_id FROM ?_tree");
 foreach($result as $tmp)
 {
  $tree[$tmp['tree_id']]=$tmp['parent_id'];
 }
$level=array($id);
 do
 {
  $level[]=$tree[$id];
  $id=$tree[$id];
 }
 while ($tree[$id]);

 $core['level']=array_reverse($level);
}


//функция определяющая права на модули
function rules()
{
 global $smarty, $user_info, $db, $config;
 //если пользователь является суперадмином, то даем ему все возможные права
 if ($user_info['group_id']==1)
 {
  return array(true);
 }
 else
 {
  //запрашиваем права на модуль для конкретной группы или универсальные права для всех групп (guest).
if (!is_array($_SESSION['access'][$acc['module_id']]))
{
 $result=$db->select("SELECT module_id, permis FROM ?_access  WHERE (group_id=? OR group_id=0) ORDER BY group_id", $user_info['group_id']);
 foreach($result as $acc)
 {
  $access[$acc['module_id']]=explode(",", $acc['permis']);
 }
 $_SESSION['access']=$access;
}
else
{
 $access=$_SESSION['access'];
}


 }
 return $access;
}


/**
 * функция определяющая права доступа к функциям
 *
 * @param string $rules
 * @return boolean
 * @author Loki
 */
function access($rules)
{
 global $core;
 //если суперадмин, то все права у него есть.
 if ($core['access'][0]) return true;
 $rules=explode(",", $rules);
 foreach ($rules as $rule)
 {
  if (!in_array(trim($rule), $core['access'][$core['inc']['module_id']])) return false;
 }
 return true;
}

//функция авторизации и проверки на принадлежность группе
function auth()
{
 global $tbl_users, $db;
  if(!$_SESSION['user_id'])
  {
   $_SESSION['user_id']=-1;	  //если пользователь не определен, то это гость
   $_SESSION['hash_key']=md5($_SERVER['REMOTE_ADDR'].$_SERVER["HTTP_USER_AGENT"]);
  }
  else
  {
   //если сессию потырили, делаем посетителя гостем
   if ($_SESSION['hash_key']!=md5($_SERVER['REMOTE_ADDR'].$_SERVER["HTTP_USER_AGENT"]))
    {
     $_SESSION['user_id']=-1; //до перезагрузки он будет числится гостем
    }
  }

  //блок авторизации через куки.
  if(($_SESSION['user_id']==-1) && $_COOKIE['login'] && $_COOKIE['pass'])
  {
   $user_info=check_login($_COOKIE['login'], $_COOKIE['pass'], true);
  }

if (!is_array($_SESSION['user_info']))
{
  //данных в массиве все еще нет, то запрашиваем данные имеющегося id
   $user_info=$db->selectRow("SELECT * FROM ?_users WHERE user_id=?", $_SESSION['user_id']);
$_SESSION['user_info']=$user_info;
}
else
{
$user_info=$_SESSION['user_info'];
}
 return $user_info;
}
//функция проверки логина и пароля
function check_login($login, $pass, $cookie=false)
{
	global $tbl_users, $tbl_groups, $db;
	if (!$cookie) $pass=md5($pass);
	$result=$db->select("SELECT * FROM ?_users WHERE login=? AND pass=? AND status = 1", $login, $pass);
	if (count($result)==1)
	{
		$_SESSION['user_info']=$user_info=$result[0];
		$_SESSION['user_id']=$user_info['user_id'];
		$_SESSION['hash_key']=md5($_SERVER['REMOTE_ADDR'].$_SERVER["HTTP_USER_AGENT"]);
		setcookie('login', $user_info['login'], time()+60*60*24*365, "/");
		setcookie('pass', $user_info['pass'], time()+60*60*24*365, "/");
		unset($_SESSION['user_info']['pass']);
		return $user_info;
	}
	return false;
}

/**
 * функция проверяет должен ли быть сброс сессии и производит его, если нужно
 *
 * @param none
 * @return none
 * @author Loki
 */
function reset_session()
{
$reset=glob($_SERVER['DOCUMENT_ROOT']."/kernel/configs/*.reset");
$last_reset = basename($reset[0], ".reset");
	if ($_SESSION['last_reset']!=$last_reset){
		$tmp['user_id']=$_SESSION['user_id'];
		$tmp['hash_key']=$_SESSION['hash_key'];
		$tmp['last_reset']=$last_reset;
		//обнуляем все данные сессии кроме залогиненности юзера
		$_SESSION=$tmp;
	}
}

/**
 * функция устанавливает дату последнего обновления параметров
 *
 * @param none
 * @return none
 * @author Loki
 */
function reset_session_set()
{
	$last_reset=glob($_SERVER['DOCUMENT_ROOT']."/kernel/configs/*.reset");
	$new_name = time();
	if(!file_exists($last_reset[0])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/kernel/configs/$new_name.reset","");
	}else{
		$old_name = basename($last_reset[0], ".reset");	
		rename($_SERVER['DOCUMENT_ROOT']."/kernel/configs/$old_name.reset", $_SERVER['DOCUMENT_ROOT']."/kernel/configs/$new_name.reset");
	}
	
	
}



/**
 * функция готовит параметры для подключения модуля
 *
 * @param array
 * @return int
 * @author Loki
 */
function include_modules($result_mod)
{
  global $config, $smarty, $core;

//если нулевой элемент null или отсутствует и пользователь не суперадмин и это компонент - выводим ошибку
   if (!$core['access'][$result_mod['module_id']][0] && $result_mod['component'] && !$core['access'][0]) error404();
   elseif (!$core['access'][$result_mod['module_id']][0] && !$core['access'][0]) return false; //если на модуль нет прав, то и нефиг дальше его обрабатывать.

      //подключаем  css для данного модуля
	if($css=glob(TEMPLATE_PATH.$config['skin']."/".$result_mod['module']."css/*.css"))
	{
		foreach($css as $css_item)
		{
			$smarty->append('css', array("path"=>$result_mod['module']."css/".basename($css_item), "media"=>basename($css_item, ".css")));
		}
	}
	 //подключаем JS для конкретного модуля
	if($js=glob(TEMPLATE_PATH.$config['skin']."/".$result_mod['module']."js/*.js"))
	foreach($js as $js_item)
	{
		$smarty->append('js', $result_mod['module']."js/".basename($js_item));
	}
 return $result_mod['module_id'];
}
/**
 * рекурсивно копирует каталог $sourse в  $destination
 *
 * @param text, text
 * @return
 * @author Loki
 * в настоящий момент не используется. Если не понадобится - надо удалить.
 */
function recurse_copy($sourse, $destination)
{
	$error="";
	if (!file_exists($destination))
	{
		@chmod(dirname($destination), 0777);
		if (!@mkdir($destination)) return "Не удалось создать директорию $destination";
		chmod($destination, 0777);
	}
		$files = scandir($sourse);
	foreach($files as $file)
	{
		if ($file!="." && $file!="..")
		{
			if (is_file($sourse.$file))
			{
				if (!file_exists($destination.$file))
				{
					if (!@copy($sourse.$file, $destination.$file)) return "Не удалось скопировать файл $destination$file";
				}
			}
			else
			{
				$error=recurse_copy($sourse.$file."/", $destination.$file."/");
				if ($error) return $error;
			}
		}
	}
}


/**
 * функция закидывает отработавший модуль в шаблон, в зависимости от его типа
 *
 * @param text, int
 * @return
 * @author Loki
 */
function assign_module($mod_template, $module_name, $component=0)
{
	global $smarty, $config;
	//проверяем существует ли шаблон для данного модуля
	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/".$module_name.$mod_template))
		{
			if ($config['debug_mode'])	echo "<p>Шаблон ".$module_name.$mod_template." для скина ".$config['skin']." отсутствует! Пытаемся использовать шаблон от скина default</p>";
			$default_dir="../default/";
		}

	//если модуль многофайловый, то добавляем его данные в переменную $_component, в противном случае в переменную $_имя_модуля
	if ($component)
	{
		$smarty->assign('_component', $smarty->fetch($default_dir.$module_name.$mod_template));
	}
	else
	{
		$smarty->assign("_module_".substr($module_name, 0, -1), $smarty->fetch($default_dir.$module_name.$mod_template));
	}
}
/*********************************************
Функции управления контентом
**********************************************/

function text_string($text, $search_string="", $mode=0) //0 - прямой вызов, 1 - вложенный
{
	$text=htmlspecialchars(trim($text));

	if ($search_string) $text=highlight($text, $search_string);

	$text=str_replace("\t", " ", $text);

	if (!$mode)
	{
		$text=nl2br($text);
		$text=preg_replace_callback('#([^<>]*)(<[^>]+>)?#', 'trim_long_text', $text);
	}
	return $text;
}
function bbcode($text, $search_string="", $mode=0) //0 - прямой вызов, 1 - вложенный
{
	$text=text_string($text, $search_string, 1);
	$bb_tags   = array('/\[u\](.*?)\[\/u\]/si',
						 '/\[i\](.*?)\[\/i\]/si',
						 '/\[b\](.*?)\[\/b\]/si');

	$html_tags = array('<u>\1</u>',
						 '<i>\1</i>',
						 '<b>\1</b>');

	$text=preg_replace($bb_tags, $html_tags, $text);

	if (!$mode)
	{
		$text=nl2br($text);
		$text=preg_replace_callback('#([^<>]*)(<[^>]+>)?#', 'trim_long_text', $text);
	}
	return $text;
}
function bbcode_all($text, $search_string="")
{
  $text=bbcode($text, $search_string, 1);
  //$text=preg_replace('#(\[url\].*?)script:(.*?\[/url\])#si', '$1 script:$2', $text);
  $text=preg_replace('#(\[url=&quot;.*?)script:(.*?&quot;\])#si', '$1 script:$2', $text);

  //$text=preg_replace('#(\s|^)(((?:ftp|https?)://)?(?i:[a-z0-9](?:[\-a-z0-9]*[a-z0-9])?\.)+(?-i:[a-z]{2,5}\b)(?::\d+)?(?:/[\w\.\-=_\?&\#;]*)*)(\s|$)#e', '\'$1<a href="\'.((\'$3\')?"":"http://").\'$2">$2</a>$4\'', $text);
  $text=preg_replace_callback('#(?:[^\];]|^)((?:ftp|https?)://(?:[a-z0-9](?:[\-a-z0-9]*[a-z0-9])?\.)+(?:[a-z]{2,5})(?::\d+)?(?:/[\w\.\-=_\?&\#;]*)*)(?:[^\]])#', 'trim_long_link', $text);
  //$text=preg_replace('#\[url\](.*?)\[/url\]#si', '<a href="\1">\1</a>', $text);
  $text=preg_replace_callback('#\[url=&quot;(.*?)&quot;\](.*?)\[/url\]#si', 'trim_long_link', $text);

  $text=preg_replace('#(\[img\].*?)script:(.*?\[/img\])#si', '$1 script:$2', $text);
  $text=preg_replace('#\[img\](.*?)\[/img\]#si', '<div class="crop"><img src="\1"></div>', $text);

  $quotes=substr_count($text, "[/q]");
  for ($i=0; $i<$quotes; $i++)
  {
   $text=preg_replace('#\[q\](.*?)\[/q\]#si', '<div class="quote">\1</div>', $text);
   $text=preg_replace('#\[q=&quot;(.*?)&quot;\][\s]*(.+?)\[/q\]#si', '<div class="quote"><span>\1 пишет:</span><br />\2</div>', $text);
  }

  $text=preg_replace_callback('#([^<>]*)(<[^>]+>)?#', 'trim_long_text', $text);

  $text=nl2br($text);
  return $text;
}
/**
 * оформление ссылок в виде <a href="http://link.ru">длинно..звание</a>
 *
 * @param array
 * @return string
 * @author Loki
 */
function trim_long_link($match)
{
	global $config;
	$url=$match[1];
	$text=$match[2];
	if (!$text)	$text=$url;
	if (mb_strlen($text)>$config['bbcode_link_length'] && $config['bbcode_link_length']) 
	{
		$limit1=intval($config['bbcode_link_length']*0.75);
		$limit2=intval($config['bbcode_link_length']*0.25);
		$text=preg_replace('/^(.{'.$limit1.'}).*(.{'.$limit2.'})$/u','$1...$2',$text);
	}

	if (strpos($url, "http://")!==0 && strpos($url, "https://")!==0 && strpos($url, "ftp://")!==0 && !$match[2])
	{
		$url="http://".$url;
	}
	return ' <a target="_blank" href="'.$url.'">'.$text.'</a> ';
}
/**
 * обрезка длишком длинных слов
 *
 * @param array
 * @return string
 * @author Loki
 */
function trim_long_text($match)
{
	global $config;
	if ($config['bbcode_word_length']) $match[1]=preg_replace('/(\w{'.($config['bbcode_word_length']*2).'})/u', '$1 ', $match[1]);
	return $match[1].$match[2];
}

 function resizeimg($filename, $smallimage, $w, $h)
  {
    // определим коэффициент сжатия изображения, которое будем генерить
    $ratio = $w/$h;
    // получим размеры исходного изображения
    $size_img = getimagesize($filename);
    // Если размеры меньше, то масштабирования не нужно
    if (($size_img[0]<$w) && ($size_img[1]<$h))
    {
     copy($filename, $smallimage);
     return true;
    }
    // получим коэффициент сжатия исходного изображения
    $src_ratio=$size_img[0]/$size_img[1];

    // Здесь вычисляем размеры уменьшенной копии, чтобы при масштабировании сохранились
    // пропорции исходного изображения
    if ($ratio<$src_ratio)
    {
      $h = $w/$src_ratio;
    }
    else
    {
      $w = $h*$src_ratio;
    }
    // создадим пустое изображение по заданным размерам
    $dest_img = imagecreatetruecolor($w, $h);
    $white = imagecolorallocate($dest_img, 255, 255, 255);
    if ($size_img[2]==2)  $src_img = imagecreatefromjpeg($filename);
    else if ($size_img[2]==1) $src_img = imagecreatefromgif($filename);
    else if ($size_img[2]==3) $src_img = imagecreatefrompng($filename);

    // масштабируем изображение     функцией imagecopyresampled()
    // $dest_img - уменьшенная копия
    // $src_img - исходной изображение
    // $w - ширина уменьшенной копии
    // $h - высота уменьшенной копии
    // $size_img[0] - ширина исходного изображения
    // $size_img[1] - высота исходного изображения
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
    // сохраняем уменьшенную копию в файл
    if ($size_img[2]==2)  imagejpeg($dest_img, $smallimage, 80);
    else if ($size_img[2]==1) imagegif($dest_img, $smallimage);
    else if ($size_img[2]==3) imagepng($dest_img, $smallimage);
    // чистим память от созданных изображений
    imagedestroy($dest_img);
    imagedestroy($src_img);
    return true;
  }
  function upload_img_file ($album_path, $config_tn)
  {
   global $errors;
   $file_ext=array(1 => 'gif', 2 => 'jpg', 3 => 'png');
   $filetype=getimagesize($_FILES['file_name']['tmp_name']);
   if ($filetype[2]<1 || $filetype[2]>3) { $errors[]="Недопустимый формат файла"; return false;}
   $new_name=md5(time()).".".$file_ext[$filetype[2]];

   if (!move_uploaded_file ($_FILES['file_name']['tmp_name'], $_SERVER["DOCUMENT_ROOT"].$album_path.$new_name)) {$errors[]="Ошибка загрузки файла"; return false;}

$ready_files[]=$_SERVER["DOCUMENT_ROOT"].$album_path.$new_name;

   //делаем превьюху
      foreach($config_tn as $tn)
{
        if(!resizeimg($_SERVER["DOCUMENT_ROOT"].$album_path.$new_name, $_SERVER["DOCUMENT_ROOT"].$album_path.$tn['path'].$new_name, $tn['w'], $tn['h']))
	{
foreach ($ready_files as $to_del)
{
	 unlink($to_del);
}
	 $errors[]="Ошибка генерации превью";
	 return false;
	}
$ready_files[]=$_SERVER["DOCUMENT_ROOT"].$album_path.$tn['path'].$new_name;
}
	return $new_name;
  }
//класс для выделения корня слова
class Lingua_Stem_Ru
{
    var $VERSION = "0.02";
    var $Stem_Caching = 0;
    var $Stem_Cache = array();
    var $VOWEL = '/аеиоуыэюя/';
    var $PERFECTIVEGROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/';
    var $REFLEXIVE = '/(с[яь])$/';
    var $ADJECTIVE = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|еых|ую|юю|ая|яя|ою|ею)$/';
    var $PARTICIPLE = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/';
    var $VERB = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/';
    var $NOUN = '/(а|ев|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|и|ы|ь|ию|ью|ю|ия|ья|я)$/';
    var $RVRE = '/^(.*?[аеиоуыэюя])(.*)$/';
    var $DERIVATIONAL = '/[^аеиоуыэюя][аеиоуыэюя]+[^аеиоуыэюя]+[аеиоуыэюя].*(?<=о)сть?$/';

    function s(&$s, $re, $to)
    {
        $orig = $s;
        $s = preg_replace($re, $to, $s);
        return $orig !== $s;
    }

    function m($s, $re)
    {
        return preg_match($re, $s);
    }

    function stem_word($word)
    {
        $word = strtolower($word);
        $word = str_replace('ё', 'е', $word);
        # Check against cache of stemmed words
        if ($this->Stem_Caching && isset($this->Stem_Cache[$word])) {
            return $this->Stem_Cache[$word];
        }
        $stem = $word;
        do {
          if (!preg_match($this->RVRE, $word, $p)) break;
          $start = $p[1];
          $RV = $p[2];
          if (!$RV) break;

          # Step 1
          if (!$this->s($RV, $this->PERFECTIVEGROUND, '')) {
              $this->s($RV, $this->REFLEXIVE, '');

              if ($this->s($RV, $this->ADJECTIVE, '')) {
                  $this->s($RV, $this->PARTICIPLE, '');
              } else {
                  if (!$this->s($RV, $this->VERB, ''))
                      $this->s($RV, $this->NOUN, '');
              }
          }

          # Step 2
          $this->s($RV, '/и$/', '');

          # Step 3
          if ($this->m($RV, $this->DERIVATIONAL))
              $this->s($RV, '/ость?$/', '');

          # Step 4
          if (!$this->s($RV, '/ь$/', '')) {
              $this->s($RV, '/ейше?/', '');
              $this->s($RV, '/нн$/', 'н');
          }

          $stem = $start.$RV;
        } while(false);
        if ($this->Stem_Caching) $this->Stem_Cache[$word] = $stem;
        return $stem;
    }

    function stem_caching($parm_ref)
    {
        $caching_level = @$parm_ref['-level'];
        if ($caching_level) {
            if (!$this->m($caching_level, '/^[012]$/')) {
                die(__CLASS__ . "::stem_caching() - Legal values are '0','1' or '2'. '$caching_level' is not a legal value");
            }
            $this->Stem_Caching = $caching_level;
        }
        return $this->Stem_Caching;
    }

    function clear_stem_cache()
    {
        $this->Stem_Cache = array();
    }
}
	//подсветка поисковых фраз
function highlight($word, $srchstr)
{
 if ($srchstr=="") return $word;
 if (!is_array($srchstr))
  $srchstr=explode(" ", preg_replace('/[\s]+/u',' ',trim($srchstr)));
	$stemmer = new Lingua_Stem_Ru();
	foreach ($srchstr as $val)
	{
    $val=$stemmer->stem_word($val);
	 $word = preg_replace('/([а-яa-z0-9]*'.preg_quote($val, "/").'[а-яa-z0-9]*)/iu', '<span class="forum_hl">\\1</span>', $word);
	}
	return $word;
}
/**
 * Выборка прав для модулей
 *
 * @param none
 * @return array
 * @author Akira
 */
 function getAcces($module_id,$group_id=0) {
 	global $tbl_modules, $db;
 	if($group_id){
 		$result = $db->select("SELECT * FROM ?_access WHERE group_id = ? AND module_id = ?;",$group_id,$module_id); //
 	}else{
 		$result = $db->select("SELECT * FROM ?_access WHERE group_id = 0 AND module_id = ?;",$module_id); //
 	}
 	return $result ? $result : false ;
 }
/**
 * Выборка модулей и проверка на подключение
 *
 * @param none
 * @return array
 * @author Akira
 */
function getModules(){
	global $tbl_modules, $db;
	$all_mods=glob(MODS_PATH."*", GLOB_ONLYDIR);
            $result=$db->select("SELECT * FROM ?_modules ORDER BY NAME"); // Все установленные модули
            foreach($result as $modules)
                {
                 $mod_name =  substr($modules['module'],0,strlen($modules['module'])-1); // Чистим слэш
                     $module[$mod_name] = array('module_id'=>$modules['module_id'],
                                           'name'=>$modules['name'],
                                           'component'=>$modules['component'],
                                           'disable'=>$modules['disable']);
                }
            foreach($all_mods as $mod){
                       $name= str_replace(MODS_PATH,'',$mod);
                       $info = file_exists($mod."/config.ini") ? parse_ini_file($mod."/config.ini",true) : false;
                       // Ищим инсталяционные данные
                       $sqls=glob($mod."/*.sql");
                       $all_mod[] = $name;
                       $module[$name]['sql'] = $sqls;
                       $module[$name]['info'] = $info;
                       if(is_array($module[$name])){
                	      $module[$name]['install']=1;
                       }else{
                	      $module[$name]['install']=0;
                       }
             }
     return $module;
}
/**
 * Выборка sql файлов модуля
 *
 * @param string $mod
 * @return array
 * @author Akira
 */
function getModulesSql($mod){
     $sqls=glob(MODS_PATH.$mod."/*.sql");
     return count($sqls)>=1 ? $sqls : false;
}
/**
 * Информация из файла config.ini модуля
 *
 * @param string $mod
 * @return array
 * @author Akira
 */
function getModuleInfo($mod) {
	return file_exists(MODS_PATH.$mod."/config.ini") ? parse_ini_file(MODS_PATH.$mod."/config.ini",true) : false;
}
function refresh($text='', $url=false, $time=0,$exit=true){
	global $config;
	if (!$url) $url=ext($_SERVER['PHP_SELF'], $config['ext']);
	echo    '<html>' .
			'<head>' .
			'<META HTTP-EQUIV="refresh" content="'.$time.';URL='.$url.'">'.
			'</head>'.
			'<body><h1>'.
			$text.
			'</h1></body>'.
			'</html>';
	$exit ? exit() : "";
}
/**
 * Парсинг sql
 *
 * @param string $url
 * @return boolean
 * @author Akira
 */
function parse_mysql_dump($url) {
	global $db;
   $file_content = file($url);
   $query = "";
   foreach($file_content as $key=>$sql_line) {
     $sql_line = trim($sql_line);
     if (($sql_line != "") && (substr($sql_line, 0, 2) != "--") && (substr($sql_line, 0, 1) != "#")) {
       $query .= $sql_line;
       if(preg_match("/;$/", $sql_line)) {
         $result = $db->query($query);
		 echo htmlspecialchars($query);
		 if (is_array($result))
		 {
			echo " <span style='color:#f00'>Fail</span><br />";
			return false;
		 }
		 else
		 {
			echo " <span style='color:#00F'>Ok</span><br />";
		 }
		 $query = "";
       }
     }
   }
   return true;
  }
  function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; print_r($info); echo "</pre>";
    exit();
}
/**
 * Получения ревизии
 *
 * @param string $mod
 * @return array
 * @author Akira
 */
function getRev($rev) {
    preg_match("#\d+#",$rev,$match);
    return $match[0];
}
/**
 * Перевод кирилицы в транслит
 *
 * @param string
 * @return string
 * @author Loki
 */
function translit($st)
{
	$rus_letters=array( 'ж',  'ц',  'ч', 'ш',  'щ',    'ь', 'ю',  'я',  'ї', 'є',
						'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ъ', 'ы', 'э');
	$eng_letters=array('zh', 'ts', 'ch', 'sh', 'shch', '',  'yu', 'ya', 'i', 'ie',
						'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', '',  'y', 'e');
	$st=str_replace($rus_letters, $eng_letters, $st);

    return $st;
}
/**
 * Приведение url в съедобный вид. Поправил немного (akira)
 *
 * @param string
 * @return string
 * @author Loki
 */
 function convert_url($st)
 {
 	$st=mb_strtolower($st);
	$st=translit($st);
	if (mb_strpos($st, "/")!==0) $st="/".$st;
	$st=trim($st);
	$st=preg_replace('#[^a-z0-9/]+#u', '_', $st);
	return $st;
 }
/**
 * Проверка url на сущ. в базе
 *
 * @param string
 * @return boolean
 * @author Akira
 */
 function check_url($path, $tree_id=false){
  	global $db;
  	return $db->selectCell("SELECT count(*) FROM ?_tree_val WHERE path=? { AND tree_id != ? };",$path, ($tree_id ? $tree_id : DBSIMPLE_SKIP));// Вытаскиваем все группы
  }
 function getUserGroups(){
  	global $db;
  	return $db->select("SELECT * FROM ?_groups ORDER BY group_name;");// Вытаскиваем все группы
  }
function getUsers(){
  	global $db;
  	return $db->select("SELECT * FROM ?_users ORDER BY realname;");// Вытаскиваем все
  }
/**
 * Вывод print_r
 *
 * @param any
 * @return no
 * @author Akira
 */
 function vardump($any){
	print "<pre>";
	print_r($any);
	print "</pre>";
 }
 
 /**
 * Проверяет не является ли ссылка корневой и, если нет, подставляет к ней расширение
 *
 * @param string
  * @param string
 * @return string
 * @author Loki
 */
function ext($path, $ext)
{
    return ($path!='/' ?  $path.$ext : $path);
}
/**
* Отдает xml feed. Пока реализован rss2.0
*
* @param array
* @param string
* @author Loki
*/
function feed($feed_data, $feed_type='rss')
{
	global $core, $smarty;
	include_once ($_SERVER['DOCUMENT_ROOT'].'/kernel/classes/rss.php');
	
	//тут формируем $xml
	
	$rss = new RSS($feed_data['title'], 
					$feed_data['link'], 
					$feed_data['description'], 
					($feed_data['language']?$feed_data['language']:'ru-ru'),
					$feed_data['pubDate'],
					$feed_data['lastBuildDate'],
					$feed_data['managingEditor'],
					$feed_data['webMaster']);
	if(is_array($feed_data['feed']))
	{
		foreach ($feed_data['feed'] as $tmp)
		{
			$rss->addItem($tmp['title'], $tmp['link'], $tmp['description'], $tmp['pubDate'], $tmp['guid']);
		}
	}

	$contentType = "application/rss+xml";
	Header("Content-Type: ".$contentType."; charset=utf-8;");
	$smarty->assign('_component', $rss->saveXML( ));
	$core['template']='blank';
}
 /**
 * Проверяет язык текущей ветки. Если язык явно не указан, то бурется дефолтный язык из настроек. Данные вносятся в массив $core
 *
 * @author Loki
 */
function current_lang()
{
	global $core, $db, $config, $smarty;
	$lang=$db->selectRow("SELECT l.lang_id, lang_name, `key` FROM ?_tree_langs tl 
															JOIN ?_langs l ON tl.lang_id=l.lang_id 
															WHERE tree_id IN (?a) 
															ORDER BY FIELD(tree_id, ?a) 
															LIMIT 1", $core['level'], array_reverse($core['level']));
	if (!$lang)
	$lang=$db->selectRow("SELECT lang_id, lang_name, `key` FROM ?_langs WHERE `key`=?", $config['default_lang']);
	$core['lang_id']=$lang['lang_id'];
	$core['lang_name']=$lang['lang_name'];
	$core['lang_key']=$lang['key'];
	$smarty->assign('lang_key', $core['lang_key']);
}

/**
* Формирует url
*
* @param array
* @param string
* @param string
* @return string
* @author Loki
*/
function url($params=array(), $action='', $type='')
{
	global $config;
	if (!is_array($params) && $params) $params=array($params);
	$url=$_SERVER['PHP_SELF'];
	if ($action) $url.="-".$action;
	if (count($params) && is_array($params))
	{
		ksort($params);
		$params=array_map("urlencode", $params);
		$url.=".".implode('/', $params);
	}
	
	if ($_SERVER['PHP_SELF']!="/" || $action)
	{
		if (!$type) $url.=$config['ext'];
		else $url.=".".$type;
	}
	return $url;
}
/**
* Ищет строку соотвествующую заданной в текущем языке. Если такой не существует, то создает новую запись.
*
* @param string
* @return string
* @author Loki
*/
function _lang($text_key)
{
	global $db, $core;
	if (!$core['translate'][$core['lang_id']]) $core['translate'][$core['lang_id']]=prepare_lang();
	if (!$core['translate'][$core['lang_id']][$text_key])
	{
		$db->query("INSERT INTO ?_translate_keys (text_key, text_descr) VALUES(?, ?)", $text_key, $_SERVER['REQUEST_URI']);
		$core['translate'][$core['lang_id']][$text_key]=$text_key;
		return $text_key;
	}
	else
	{
		return $core['translate'][$core['lang_id']][$text_key];
	}
}

function prepare_lang()
{
	global $db, $core;
	$lang=$db->selectCol("SELECT text_key AS ARRAY_KEY, IFNULL(text,text_key) as text 
					                    FROM  ?_translate_keys tk 
										LEFT JOIN (SELECT text_id, text 
										FROM ?_translate 
										WHERE lang_id=?) as t ON tk.text_id=t.text_id", $core['lang_id']);	
	return ($lang?$lang:false);
}
?>