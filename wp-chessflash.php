<?php

/*
 * Plugin Name: WP-ChessFlash
 * Plugin URI: http://www.pepijnvanerp.nl/chess/wp-chessflash/
 * Description: Allows display of an interactive chessgame using the ChessFlash viewer (version 2.16 from http://chessflash.com/) in Wordpress posts
 * Version: 1.2
 * Author: Pepijn van Erp
 * Author URI: http://www.pepijnvanerp.nl/
 */

/*
 *  usage:  put pgn-code between [pgn] [/pgn] tags
 *  optional use of attributes (with their default values):  [pgn height=350 tabmode=false flipboard=false] [/pgn]
 *  additional parameters must be allowed in the options page:  puzzle=false twoboards=false boardonly=false
 *  colors and piece characters can be set in options page
 */

class chessflash
{
	//PvE: hook into the_content with [$tag] [/$tag] tags
	function parse($text)
	{
		
		//PvE:I tried to do this wit a regexp like: 
		//return preg_replace_callback( '/\[pgn\]((.|\n|\r)*?)\[\/pgn\]/', array('chessflash','encode_pgn'), $text );
		//but ran into problems with larger pgn files, probably because of the recursion in preg_replace_callback
		//The following code is low-level but works!

		$tag='pgn';

		$matchblock = chessflash::find_tag($tag, $text); //finds first block '[$tag]-data-[/$tag]' with start and length
		if ($matchblock == null) return $text;

		//PvE: part of $text before [$tag]
		$ret1=substr($text,0,$matchblock['startblock']);

		//PvE: now able to work with block '[$tag]-data-[/$tag]'
		//$ret2=$matchblock['body'];
		$ret2=chessflash::encode_pgn($matchblock);

		//PvE: search in part of $text after [/$tag] for more instances of '[$tag]-data-[/$tag]'-blocks with recursion
		$ret3=chessflash::parse(substr($text,$matchblock['endblock']+1));
	
		$text=$ret1.$ret2.$ret3;
		return $text;
    	}

	

	function find_tag( $tag,$text)
	{
		//PvE: find opening tag [$tag and store position
		$x = strpos($text, '[' . $tag);
    		if ($x === false) return null;
		
		$t=array();
		$t['startblock']=$x;
		
		//PvE: find closing [ of opening tags [$tag and store position
		$x2 = $x+strlen($tag)+1;
		$y = strpos($text, ']', $x);
		$t['startbody']=$y+1;

		// extracts attributes (attr=value, no spaces admitted)
    		$tmp = split(' ', substr($text, $x2, $y-$x2));
    		for ($i=0; $i<count($tmp); $i++)
    		{
        		$tmp[$i] = trim($tmp[$i]);
        		if ($tmp[$i] == '') continue;
        		$tmp2 = split('=', $tmp[$i], 2);
        		$t['attrs'][$tmp2[0]] = $tmp2[1];
    		}

		//PvE: search closing tag [/$tag] from end of found opening tag 
		$z = strpos(substr($text,$t['startbody']), '[/' . $tag . ']');
  		
		if ($z !== false) 
    		{
        		$t['endbody']=$t['startbody']+$z-1;
			$t['endblock']=$t['endbody']+strlen($tag)+3;

			$t['lenblock'] = $t['endblock']-$t['startblock']+1;
			$t['lenbody'] = $t['endbody']-$t['startbody']+1;

			$t['body'] = substr($text, $t['startbody'], $t['lenbody']);

        	}
    		else $t['lenbody'] = 0;

		return $t;
	}

	
	//PvE: encodes the pgn for use with ChessFlash.swf and places the ChessFlash codes around the pgn-code
	function encode_pgn( $pgnblock)
	{	
		//PvE: trim leading whitespace
		$pgn = ltrim( $pgnblock['body'] );

		//PvE: trim ending whitespace
		$pgn = rtrim( $pgn );

		$pgn=strip_tags($pgn);
		
		$pgn=str_replace("'","’", $pgn); // single quote to single right quote; 
		$pgn=str_replace("+","%2B", $pgn);// encode check / plus sign symbol
		
		//PvE: tinyMCE or WP replace... with an entity behind the scenes,this is corrected his way
		$pgn = str_replace(array('&#8230;'), '...', $pgn);
		
		//PvE: tinyMCE or WP replace " with an entity behind the scenes,this is corrected his way
		$pgn = str_replace(array('&#8220;'), '"', $pgn);
		$pgn = str_replace(array('&#8221;'), '"', $pgn);


		//PvE: path to ChessFlash.swf on it's 'home-base'
		//$path="http://chessflash.com/releases/latest";

		//PvE: local path to ChessFlash.swf
		$siteurl = get_option("siteurl");
		$path=$siteurl."/wp-content/plugins/wp-chessflash/";
		
		//PvE: default colors from KnightVision
		$ligth_def="f4f4ff";
		$dark_def="0072b9";
		$bordertext_def="494949";
		$background_def="ffffff";
		$headerforeground_def="ffffff";
		$mtforeground_def="000000";
		$mtvariations_def="ff0000";
		$mtmainline_def="000000";
		$pieces_def="KQRBNP";		
	
		$cf_start='<object type="application/x-shockwave-flash" data="';
      	$cf_start.=$path;
		
		$cf_start.='ChessFlash.swf" width="100%" ';
		
		//PvE:height possibly set in attribute
		if ($pgnblock['attrs']['height']!=null){
			$cf_start.='height="'.$pgnblock['attrs']['height'].'">';
		}
		else $cf_start.='height="350">';
		
		
		$cf_start.='<param name="movie" value="';
		$cf_start.=$path;
		$cf_start.='ChessFlash.swf" /><param name="flashvars" value=\'orientation=H';
		
		//PvE:tabmode possibly set in attribute
		if ($pgnblock['attrs']['tabmode']!=null){
			$cf_start.='&tabmode='.$pgnblock['attrs']['tabmode'];
		}
		else $cf_start.='&tabmode=false';
		
		//PvE:initialmove possibly set in attribute
		if ($pgnblock['attrs']['initialply']!=null){
			$cf_start.='&initialmove='.$pgnblock['attrs']['initialply'];
		}
		else $cf_start.='&initialmove=0';

		$tmp=get_option('wpcf_light');
		if ($tmp==null){ $tmp=$light_def;
		}
		else $light_def=$tmp;
		$cf_start.='&light='.$tmp;		

		$tmp=get_option('wpcf_dark');
		if ($tmp==null){ $tmp=$dark_def;
		}
		else $dark_def=$tmp;
		$cf_start.='&dark='.$tmp;
		
		$tmp=get_option('wpcf_bordertext');
		if ($tmp==null){ $tmp=$bordertext_def;
		}
		else $bordertext_def=$tmp;
		$cf_start.='&bordertext='.$tmp;

		$border_def=$light;
		$tmp=get_option('wpcf_border');
		if ($tmp==null){ $tmp=$light_def;
		}
		else $border_def=$tmp;
		$cf_start.='&border='.$tmp;

		$headerbackground_def=$dark_def;	
		$tmp=get_option('wpcf_headerbackground');
		if ($tmp==null){ $tmp=$headerbackground_def;
		}
		else $headerbackground_def=$tmp;
		$cf_start.='&headerbackground='.$tmp;
		
		$tmp=get_option('wpcf_scrollbar');
		if ($tmp==null){ $tmp=$headerbackground_def;
		}
		$cf_start.='&scrollbar='.$tmp;

		$tmp=get_option('wpcf_headerforeground');
		if ($tmp==null){ $tmp=$headerforeground_def;
		}
		$cf_start.='&headerforeground='.$tmp;

		$tmp=get_option('wpcf_mtforeground');
		if ($tmp==null){ $tmp=$mtforeground_def;
		}
		$cf_start.='&mtforeground='.$tmp;

		$tmp=get_option('wpcf_mtvariations');
		if ($tmp==null){ $tmp=$mtvariations_def;
		}
		$cf_start.='&mtvariations='.$tmp;

		$tmp=get_option('wpcf_mtmainline');
		if ($tmp==null){ $tmp=$mtmainline_def;
		}
		$cf_start.='&mtmainline='.$tmp;

		$tmp=get_option('wpcf_background');
		if ($tmp==null){ $tmp=$background_def;
		}
		else $background_def=$tmp;
		$cf_start.='&background='.$tmp;	

		$tmp=get_option('wpcf_mtbackground');
		if ($tmp==null) $tmp=$background_def;
		$cf_start.='&mtbackground='.$tmp;

		$tmp=get_option('wpcf_light2');
		if ($tmp==null) $tmp=$light_def;
		$cf_start.='&light2='.$tmp;
		
		$tmp=get_option('wpcf_dark2');
		if ($tmp==null) $tmp=$dark_def;
		$cf_start.='&dark2='.$tmp;

		$tmp=get_option('wpcf_border2');
		if ($tmp==null) $tmp=$border_def;
		$cf_start.='&border2='.$tmp;

		$tmp=get_option('wpcf_bordertext2');
		if ($tmp==null) $tmp=$bordertext_def;
		$cf_start.='&bordertext2='.$tmp;

			
		//PvE:point of view possibly set in attribute
		if ($pgnblock['attrs']['flipboard']=='true'){
			$cf_start.='&humanplayswhite='.'false';
		}
		else $cf_start.='&humanplayswhite=true';
	
		$tmp=get_option('wpcf_pieces');
		if ($tmp==null) $tmp=$pieces_def;
		$cf_start.='&pieces='.$tmp;

		//PvE: twoboards possibly set in attribute
		if ($pgnblock['attrs']['twoboards']=='true' && get_option('wpcf_allowtwoboards')){
			$cf_start.='&twoboards=true';
		}

		//PvE: boardonly possibly set in attribute
		if ($pgnblock['attrs']['boardonly']=='true' && get_option('wpcf_allowboardonly')){
			$cf_start.='&boardonly=true';
		}
		
		//PvE: boardonly possibly set in attribute
		if ($pgnblock['attrs']['puzzle']=='true' && get_option('wpcf_allowpuzzle')){
			$cf_start.='&puzzle=true';
		}



		$cf_start.='&pgndata=';

		$cf_end="'/>";

		//PvE: want to include next line, because it fixes dropdown menu falling behind the object. 
		// However it causes a problem with replay of moves with the arrow keys on keyboard.
		// Problem is only in Firefox
		$cf_end.='<param name="wmode" value="transparent" />';
  		$cf_end.="</object>";	
 
		$ret=$cf_start.$pgn.$cf_end;
		
		return $ret;

  }
}

function wp_chessflash_menu() {
  add_options_page('WP-ChessFlash Options', 'WP-ChessFlash', 8,  'wp-chessflash/options.php');
}



add_filter( 'the_content', array('chessflash','parse') );

//PvE: uncomment next line to allow the use of the tags in comments
add_filter( 'comment_text', array('chessflash','parse') );

add_action('admin_menu', 'wp_chessflash_menu');


?>
