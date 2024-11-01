<div class="wrap">
<h2>WP-ChessFlash Options</h2>
<p> WP-ChessFlash uses the <a href="http://chessflash.com/" target="_blank">ChessFlash PGN viewer</a> developed by Glenn Wilson. On this page you can change most of the parameters of the viewer. The parameters <b> height</b>,<b>tabmode</b> and <b>flipboard</b> can be set by calling the plugin with the [pgn] tag. Not all functions of ChessFlash are made available with this plugin (because I don't need them on my webpage), maybe in the future. </p>

<p>Usage: <strong>[pgn]{your pgn-data}[/pgn]</strong> The pgn-data can be copy-pasted from your chessprogram.</p>
<p>
To use parameters: <strong>[pgn tabmode=true height=350 flipboard=true initialply=xx]{your pgn-data}[/pgn]</strong>
</p>
<p><em>NB: ChessFlash itself uses the parameter 'initialmove' in stead of 'initialply' but it works the same: initialply=5 gives the position after 5 plies, that is after the third move by white.</em></p>

<h3>Settings for ChessFlash PGN viewer</h3>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<em>Leave empty for default values.</em>

<table class="form-table">
<tr valign="top">
<th scope="row">Piece characters</th>
<td><input type="text" name="wpcf_pieces" value="<?php echo get_option('wpcf_pieces'); ?>" /> Default KQRBNP. For German use KDTLSB, for Dutch KDTLPp. </td>
</tr>
<tr><td><h3>Check to allow parameters to be set in<br> [pgn <em>parameter=value</em>] tag</h3></td></tr>
<tr valign="top">
<th scope="row">Allow option 'twoboards=true'</th>
<td><input type="checkbox" name="wpcf_allowtwoboards" value="true" <?php if(get_option('wpcf_allowtwoboards')) echo "checked"; ?>/> Default: false</td>
</tr>
<tr valign="top">
<th scope="row">Allow option 'boardonly=true'</th>
<td><input type="checkbox" name="wpcf_allowboardonly" value="true" <?php if(get_option('wpcf_allowboardonly')) echo "checked"; ?> />  Default: false</td>
</tr>
<tr valign="top">
<th scope="row">Allow option 'puzzle=true'</th>
<td><input type="checkbox" name="wpcf_allowpuzzle" value="true" <?php if(get_option('wpcf_allowpuzzle')) echo "checked"; ?> />  Default: false</td>
</tr>

<tr><td><h3>Color settings</h3></td></tr>
<tr valign="top">
<th scope="row">Light squares</th>
<td><input type="text" name="wpcf_light" value="<?php echo get_option('wpcf_light'); ?>" /> Default: f4f4ff </td>
</tr>
<tr valign="top">
<th scope="row">Dark squares</th>
<td><input type="text" name="wpcf_dark" value="<?php echo get_option('wpcf_dark'); ?>" /> Default: 0072b9</td>
</tr>
<tr valign="top">
<th scope="row">Bordertext</th>
<td><input type="text" name="wpcf_bordertext" value="<?php echo get_option('wpcf_bordertext'); ?>" /> Default: 494949</td>
</tr>
<tr valign="top">
<th scope="row">Border</th>
<td><input type="text" name="wpcf_border" value="<?php echo get_option('wpcf_border'); ?>" /> Default: Light squares value</td>
</tr>
<tr valign="top">
<th scope="row">Background</th>
<td><input type="text" name="wpcf_background" value="<?php echo get_option('wpcf_background'); ?>" /> Default: ffffff</td>
</tr>

<tr valign="top">
<th scope="row">Header background</th>
<td><input type="text" name="wpcf_headerbackground" value="<?php echo get_option('wpcf_headerbackground'); ?>" /> Default: Dark squares value</td>
</tr>
<tr valign="top">
<th scope="row">Header foreground</th>
<td><input type="text" name="wpcf_headerforeground" value="<?php echo get_option('wpcf_headerforeground'); ?>" /> Default: ffffff</td>
</tr>

<tr valign="top">
<th scope="row">Movetext area background</th>
<td><input type="text" name="wpcf_mtbackground" value="<?php echo get_option('wpcf_mtbackground'); ?>" /> Default: Background value</td>
</tr>
<tr valign="top">
<th scope="row">Movetext area foreground</th>
<td><input type="text" name="wpcf_mtforeground" value="<?php echo get_option('wpcf_mtforeground'); ?>" /> Default: 000000</td>
</tr>
<tr valign="top">
<th scope="row">Movetext area mainline</th>
<td><input type="text" name="wpcf_mtmainline" value="<?php echo get_option('wpcf_mtmainline'); ?>" /> Default: 000000</td>
</tr>
<tr valign="top">
<th scope="row">Movetext area variations</th>
<td><input type="text" name="wpcf_mtvariations" value="<?php echo get_option('wpcf_mtvariations'); ?>" /> Default: ff0000</td>
</tr>

<tr valign="top">
<th scope="row">Scrollbar base color</th>
<td><input type="text" name="wpcf_scrollbar" value="<?php echo get_option('wpcf_scrollbar'); ?>" /> Default: Header background value</td>
</tr>

<tr valign="top">
<th scope="row">Light squares board 2</th>
<td><input type="text" name="wpcf_light2" value="<?php echo get_option('wpcf_light2'); ?>" /> Default: Light squares value (board 1)</td>
</tr>
<tr valign="top">
<th scope="row">Dark squares board 2</th>
<td><input type="text" name="wpcf_dark2" value="<?php echo get_option('wpcf_dark2'); ?>" /> Default: Dark squares value (board 1)</td>
</tr>
<tr valign="top">
<th scope="row">Border board 2</th>
<td><input type="text" name="wpcf_border2" value="<?php echo get_option('wpcf_border2'); ?>" /> Default: Border value (board 1)</td>
</tr>
<tr valign="top">
<th scope="row">Bordertext board 2</th>
<td><input type="text" name="wpcf_bordertext2" value="<?php echo get_option('wpcf_bordertext2'); ?>" /> Default: Bordertext value (board 1)</td>
</tr>


</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="wpcf_light,wpcf_dark,wpcf_bordertext,wpcf_border,wpcf_background,wpcf_headerbackground,wpcf_headerforeground,wpcf_mtforeground,wpcf_mtvariations,wpcf_mtmainline,wpcf_mtbackground,wpcf_pieces,wpcf_scrollbar,wpcf_allowtwoboards,wpcf_allowboardonly,wpcf_allowpuzzle" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>





</div>





