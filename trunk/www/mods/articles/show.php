<?
 $mod_template="art_show.tpl";

//выцепляем все картинки из текста имеющие признак class="illustrate'
/*
 preg_match_all('/<img([^>]+class="illustrate"[^>]*)>/i', $art_info['art_content'], $images);
 $art_images=array();
 foreach ($images[1] as $key=>$image)
 {
  preg_match('/src="(.+?)\.(gif|jpg|png)"/i', $images[0][$key], $src);
  preg_match('/width="(\d+)"/i', $images[0][$key], $width);
  preg_match('/height="(\d+)"/i', $images[0][$key], $height);
  preg_match('/(?<=alt=)"(.*?)(?<!\\\)"/si', $images[0][$key], $alt);
  (mb_strlen($alt[1])>20) ? $alt_small=mb_substr($alt[1], 0, 20)."..." : $alt_small=$alt[1]; //если описание больше 20 символов - усекаем его
  $art_images[]=array('src'=>$src[1].".".$src[2],
                      'src_tn'=>$src[1]."_tn.".$src[2],
                      'width'=>$width[1],
                      'height'=>$height[1],
                      'alt'=>$alt[1],
                      'alt_small'=>$alt_small);

 }
  
 $art_info['art_content']=preg_replace('/<img[^>]+class="illustrate"[^>]*>/i', '', $art_info['art_content']);*/
 $art_show=array('art_name'=>$art_info['art_name'], 'art_data'=>$art_info['art_content'], 'art_id'=>$art_info['art_id']);
 $tmp_prev=$next_flag=""; 
foreach($art_list as $list_item)
{
 if($list_item['art_id']==$art_info['art_id'])
 {
  if (is_array($tmp_prev)) $art_prev=$tmp_prev;
  $next_flag=true;
 }
 else
 {
  if ($next_flag)
  {
   $art_next=$list_item;
   break;
  }
  else
  {
   $tmp_prev=$list_item;
  }
 }
}

 $smarty->assign('art_prev',$art_prev);
 $smarty->assign('art_next',$art_next);

 $smarty->assign($art_show);
 $titlepage=$core['tree_name'];

 $smarty->assign('art_images', $art_images);

  $smarty->assign('access_add', access("add"));
  $smarty->assign('access_edit', access("edit"));
  $smarty->assign('access_delete', access("delete"));
?>
