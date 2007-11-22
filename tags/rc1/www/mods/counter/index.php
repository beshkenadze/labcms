<?php
$mod_template="";
  // Формируем строчку с ip
  if($obtip == 0) $ip = $_SERVER['REMOTE_ADDR']; // По умолчанию
  if($obtip == 1) $ip = urldecode(getenv(HTTP_CLIENTIP)); // www.nodex.ru
  if(empty($ip)) $ip = '0.0.0.0'; 

  // Это строчка с реферером - URL страницы, с которой посетитель пришёл на 
  // сайт
    $reff=urldecode($_SERVER["HTTP_REFERER"]);
    //приводим переводы строк в заголовке страницы к единому виду
	 $titlepage = trim($titlepage); 
	 //специально для flex $_SERVER['REQUEST_URI'] везде заменено на $_SERVER['REDIRECT_URL']
		if (substr($_SERVER['REDIRECT_URL'], -1)!="/") $_SERVER['REDIRECT_URL']=$_SERVER['REDIRECT_URL']."/";

      if(empty($titlepage))
	  {
		$titlepage=$core['tree_name'];
		//$titlepage = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'];
	  }
	  
		// Выясним, первичный ключ (id_page) текущей страницы  (по названию страницы) 
      $id_page = $db->selectCell("SELECT id_page FROM ?_count_pages WHERE title = ?", $titlepage); 
      if (!$id_page) 
      {
          $id_page = $db->selectCell("SELECT id_page FROM ?_count_pages WHERE name=?", $_SERVER['REDIRECT_URL']); 
          if ($id_page) 
          {
             $db->query("UPDATE ?_count_pages SET title=? WHERE id_page=?", $titlepage, $id_page); 
          } 
          // Если данная страница отсутствует в таблице pages 
          // и не разу не учитывалась - добавляем данную страницу в таблицу. 
          else 
          {   
              $id_page =$db->query("INSERT INTO ?_count_pages VALUES (NULL, ?, ?, 0)", $_SERVER['REDIRECT_URL'], $titlepage);                 
            } 
      }
      // Определяем строку USER_AGENT
      $useragent = $_SERVER['HTTP_USER_AGENT'];
      $browser = 'none';
      // Выясняем браузер
      if(strpos($useragent, "Mozilla") !== false) $browser = 'mozilla';
      if(strpos($useragent, "MSIE")    !== false) $browser = 'msie';
      if(strpos($useragent, "MyIE")    !== false) $browser = 'myie';
      if(strpos($useragent, "Opera")   !== false) $browser = 'opera';
      if(strpos($useragent, "Netscape")!== false) $browser = 'netscape';
      if(strpos($useragent, "Firefox") !== false) $browser = 'firefox';
      // Выясняем операционную систему
      $os = 'none';
      if(strpos($useragent, "Win")      !== false) $os = 'windows';
      if(strpos($useragent, "Linux")    !== false 
      || strpos($useragent, "Lynx")     !== false
      || strpos($useragent, "Unix")     !== false) $os = 'unix';
      if(strpos($useragent, "Macintosh")!== false) $os = 'macintosh';
      if(strpos($useragent, "PowerPC")  !== false) $os = 'macintosh';
      // Выясняем принадлежность к поисковым роботам
      if(strpos($useragent, "StackRambler") !== false) $os = 'robot_rambler';
      if(strpos($useragent, "Googlebot")    !== false) $os = 'robot_google';
      if(strpos($useragent, "Mediapartners-Google")    !== false) $os = 'robot_google';
      if(strpos($useragent, "Yandex")       !== false) $os = 'robot_yandex';
      if(strpos($useragent, "Aport")        !== false) $os = 'robot_aport';
      if(strpos($useragent, "msnbot")       !== false) $os = 'robot_msnbot';
      $search = 'none';
      // Выясняем принадлежность к поисковым системам
      if(strpos($reff,"yandex"))  $search = 'yandex';
      if(strpos($reff,"rambler")) $search = 'rambler';
      if(strpos($reff,"google"))  $search = 'google';
      if(strpos($reff,"aport"))   $search = 'aport';
      if(strpos($reff,"go.mail") && strpos($reff,"search"))   $search = 'mail';
      if(strpos($reff,"msn") && strpos($reff,"results"))   $search = 'msn';
      $server_name = $_SERVER["SERVER_NAME"];
      if(substr($_SERVER["SERVER_NAME"],0,4) == "www.") $server_name = substr($_SERVER["SERVER_NAME"],4);
      if(strpos($reff,$server_name)) $search = 'own_site';

      // Заносим всю собранную информацию в базу данных
      $db->query("INSERT INTO ?_count_ip VALUES (null, INET_ATON(?), NOW(), ?, ?, ?)", $ip, $id_page, $browser, $os);

      if ($search!="google" && $search!="msn")
      {
       $reff=iconv("CP1251", "UTF-8", $reff);
      }

      // Если имеется реферер, заносим информацию о нём в отдельную таблицу
      if(!empty($reff) && $search=="none")
      {
        $db->query("INSERT INTO ?_count_refferer VALUES (0, ?, NOW(), INET_ATON(?), ?)", $reff, $ip, $id_page);
      }

	  //вносим поисковый запрос в соответствующую таблицу
 if(!empty($reff) && $search!="none" && $search != "own_site")
 {
	  switch($search)
    {
      case 'yandex':
      {
          eregi("text=([^&]*)", $reff."&", $query); 
          if(strpos($reff,"yandpage")!=null)
            $quer=convert_cyr_string(urldecode($query[1]),"k","w");
          else
            $quer=$query[1];
        break;
      }
      case 'rambler':
      {
          eregi("words=([^&]*)", $reff."&", $query); 
          $quer=$query[1];
        break;
      }
      case 'mail':
      {
          eregi("q=([^&]*)", $reff."&", $query); 
          $quer=$query[1];
        break;
      }
      case 'google':
      {
          eregi("q=([^&]*)", $reff."&", $query); 
          $quer = $query[1]; 
        break;
      }
      case 'msn':
      {
          eregi("q=([^&]*)", $reff."&", $query); 
          $quer = $query[1];
        break;
      }
      case 'aport':
      {
          eregi("r=([^&]*)", $reff."&", $query); 
          $quer=$query[1];
        break;
      }
     }//конец для switch
	 $symbols = array("\"", "'", "(", ")", "+", ",", "-"); 
	 $quer = str_replace($symbols, " ", $quer); 
	 $quer = trim($quer); 
	 $quer = preg_replace('|[\s]+|',' ',$quer); 
	 $db->query("INSERT INTO ?_count_searchquerys VALUES (0, ?, NOW(), INET_ATON(?), ?, ?)", $quer, $ip, $id_page, $search);
  }
   
?>
