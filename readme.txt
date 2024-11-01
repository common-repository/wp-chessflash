=== WP-ChessFlash ===
Contributors: pjvanerp
Tags: chess, pgn
Requires at least:
Tested up to: 4.0.1
Stable tag: 1.2

Allows display of a chessgame using the ChessFlash viewer


== Description == 
Allows display of a interactive chessgame using the [ChessFlash PGN viewer](http://chessflash.com/) in posts and comments. Most of the settings of the Chessflash can be set either through adding parameters to the [pgn] tags or through the options page.

NB ChessFlash PGN viewer has been followed up by KnightVision, this plugin still uses the older version. 
 
Usage:

* paste pgn-code between [pgn] [/pgn] tags
* use of parameters with their default values: [pgn height=350 tabmode=false flipboard=false initialply=22]...[/pgn]
* additional parameters (puzzle, twoboards, boardonly) must first be allowed in options page
* colors and piece characters can be set in options page

== Installation ==

1. Upload directory `wp-chessflash` to  to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Customize the viewer through the options page in the 'Settings' menu in Wordpress

== Frequently Asked Questions ==

= ChessFlash has been replaced with KnightVision. Why doesn't this plugin use that newer viewer? =

I plan to update to the KnightVision version, but then I will probably use a new name for the plugin as well. 

= Why can't I see the vieuwer on mobile devices? =

The viewer uses Flash, which unfortunately doesn't work on tablets and mobile phones.

= Why are the chess pieces different from those on [chessflash.com](http://chessflash.com/chessflash.html)? =

I recompiled chessflash.swf with a different piece set for use in [Jin](http://jinchess.com/): [merida.ead-01.zip](http://ixian.com/chess/jin-piece-sets/). The original piece set didn't match the diagrams I use on the website of my chess club. You can replace chessflash.swf in the plugin directory with the original version to get the original pieces.



== Changelog ==
= 1.2 =
* bug fixes for Wordpress 4.0.1

= 1.1 =
* fixed the checkboxes to allow 'boardonly' and 'puzzle' tags
* added some text to explain 'initialply=xx' option

= 1.0 =
* using Chessflash version 2.16 with Merida piece set
* new parameter (initalply=xx)to start the player at specific ply number

= 0.9 =
* using Chessflash version 2.13 (now possible to change piece characters);
* introduced options page to set colors and piece characters and allow extra parameters;
* added transparency to flash object to avoid dropdown menus falling behind object;
* known issue: Firefox has problem with transparency -> playback with arrowkeys is not OK (one click is 2 plies). This is an known Firefox problem, not yet fixed in Firefox 3.5.2.

= 0.5 =
* added possibility to change some of the parameters with attributes in the [pgn] opening tag. Eg [pgn height=350 tabmode=false flipboard=false] [/pgn].

= 0.4 =
* resolved the problem of the replacement of '...' by Wordpress.

= 0.3 = 
* resolved the problem of pgn-files being too big by using a more low-level approach at filtering out the pgn-codes. Problem was caused by a memory limit in preg_replace_callback;
- known issue: wordpress removes ... and replaces this with something else. The chesscode works anyway.

= 0.2 =
* encoding of the pgn-data now in plugin, so you can paste in normal pgn-data between the tags;
* bug: does not work with larger pgn-data, not caused by Chessflash.swf -> has to do something with the way the pgn-data is filtered from the content.

= 0.1 =
* reworked code from plugin show-fen a bit to find the pgn-code in between [pgn] [/pgn] tags;
* seems to work with using ChessFlash.swf locally and pasting encoded pgn-data (from http://chessflash.com/chessflash.html).
