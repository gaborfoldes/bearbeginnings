<?php 
/*
** BBCode PARSER in PHP by napolux
** www.napolux.com
*/

// Parsing engine 
function parsing(&$string)
{
	// Accented letters ;)
	$string = str_replace("à","&agrave;",$string);
	$string = str_replace("è","&egrave;",$string);
	$string = str_replace("é","&eacute;",$string);
	$string = str_replace("ì","&igrave;",$string);
	$string = str_replace("ò","&ograve;",$string);
	$string = str_replace("ù","&ugrave;",$string);
	//$string = str_replace("'","&#39;", $string);
	//$string = str_replace('"',"&quot;",$string);

	// < & > substitution
	$string = str_replace("<","&lt;",$string);
	$string = str_replace("<","&gt;",$string);

	// Remove slashes...
	$string = stripslashes($string);
	
	// URL parsing
	$string = str_replace(" "," °", $string);
	$string = str_replace("\n","\n°", $string);
	$string = str_replace("\t","\t°", $string);
	
	$tmp = $string;
	$string = "";
	$separators = "°§";

    //get each token
    for($token = strtok($tmp, $separators);$token !== FALSE;$token = strtok($separators))
    {
    	//skip empty tokens
        if($token != "")
        {
			if (eregi("(news|http|https|ftp)://([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)",$token))
				$token2write = eregi_replace("^(news|http|https|ftp)://([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)","<a href=\"\\1://\\2\" target=\"_blank\">\\1://\\2</a>", $token);
			else $token2write = $token;
        }
		$string .= $token2write;
    }
	
	// Images
	$string = str_replace("[img]","<img border=\"0\" src=\"",$string);
	$string = str_replace("[/img]","\" alt=\"Immagine\">", $string);

	// List
	$string = str_replace("[li]","<li>", $string);
	$string = str_replace("[/li]","</li>", $string);
	$string = str_replace("[list]","<ul>", $string);
	$string = str_replace("[/list]","</ul>", $string);

	// Text formatting
	$string = str_replace("[b]","<b>", $string);
	$string = str_replace("[/b]","</b>", $string);
	$string = str_replace("[i]","<i>", $string);
	$string = str_replace("[/i]","</i>", $string);
	$string = str_replace("[u]","<u>",$string);
	$string = str_replace("[/u]","</u>",$string);
	$string = str_replace("[big]","<big>",$string);
	$string = str_replace("[/big]","</big>", $string);
	
	$string = str_replace("[bigger]","<big><big>",$string);
	$string = str_replace("[/bigger]","</big><big>", $string);
	$string = str_replace("[sm]","<small>", $string);
	$string = str_replace("[/sm]","</small>", $string);
	
	// Font color
	$string = str_replace("[color=","<font color=\"",$string);

	$string = str_replace("darkred]","darkred\">",$string);
	$string = str_replace("red]","red\">",$string);
	$string = str_replace("orange]","orange\">",$string);
	$string = str_replace("brown]","brown\">",$string);
	$string = str_replace("yellow]","yellow\">",$string);
	$string = str_replace("green]","green\">",$string);
	$string = str_replace("olive]","olive\">",$string);
	$string = str_replace("cyan]","cyan\">",$string);
	$string = str_replace("blue]","blue\">",$string);
	$string = str_replace("darkblue]","darkblue\">",$string);
	$string = str_replace("indigo]","indigo\">",$string);
	$string = str_replace("violet]","violet\">",$string);
	$string = str_replace("white]","white\">",$string);
	$string = str_replace("black]","black\">",$string);
	$string = str_replace("darkred]","darkred\">",$string);

	$string = str_replace("[/color]","</font>",$string);
	
	// E-mail parsing
 	$string = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))",  "<a href=\"mailto:\\1\">\\1</a>", $string);

	// <br> 
	$string = nl2br($string);
}
?>
