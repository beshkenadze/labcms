<?php

/**
 * Smarty strip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     ext<br>
 * Example:  {$var|ext:"string"} 
 * @author   Loki
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_ext($path, $ext)
{
    return ($path!='/' ?  $path.$ext : $path);
}

?>
