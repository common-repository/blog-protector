<?php
/*
Plugin Name: Blog Protector
Plugin URI: http://www.pcdrome.com/blog-protector/
Description: Protects Your Valuable Blog Content As Well As Images From Being Copied. Adjust your settings <a href="options-general.php?page=blog-protector.php">here</a>.
Version: 5.3
Author: Anurag Choudhari
Author URI: http://www.pcdrome.com/hckanurag
*/
 /*
Copyright 2020  Anurag Choudhari, IN  (http://www.pcdrome.com/)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details: http://www.gnu.org/licenses/gpl.txt
*/

function PMB_Footer()
{
?>
<script type="text/javascript">
disableSelection(document.body)
</script>

<?php
}

function PMB_Disable_Right_Click($PMB_Message)
{?>

<meta http-equiv="imagetoolbar" content="no">

<script type="text/javascript" language="JavaScript">
function disableText(e){
  return false
}
function reEnable(){
  return true
}
//For browser IE4+
document.onselectstart = new Function ("return false")

//For browser NS6
if (window.sidebar){
  document.onmousdown = disableText
  document.onclick = reEnable
}
</script>



<script language="JavaScript1.2">
var msgpopup="<?php echo $PMB_Message; ?>";
function pmb(){
	  if(alertVis == "1") alert(message);
          if(closeWin == "1") self.close();
          return false;
}
function IE() {
     if (event.button == "2" || event.button == "3"){pmb();}
}
function NS(e) {
     if (document.layers || (document.getElementById && !document.all)){
          if (e.which == "2" || e.which == "3"){ pmb();}
     }
}
document.onmousedown=IE;document.onmouseup=NS;document.oncontextmenu=new Function("alert(msgpopup);return false")

</script>
<?php }


function PMB_Disable_Selection()
{
?>
<script type="text/javascript">
function disableSelection(target){
if (typeof target.onselectstart!="undefined") //For IE
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //For Firefox
	target.style.MozUserSelect="none"
else //All other route (For Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}

</script>
<?php
}

    function PMB_OPT()
{
    if($_POST['PMB_Update']){
		update_option('PMB_Deact_Click',$_POST['PMB_Deact_Click']);
		update_option('PMB_Deact_txt',$_POST['PMB_Deact_txt']);
		update_option('PMB_Deact_Click_text',$_POST['PMB_Deact_Click_text']);
        echo '<h3>Your Blog Is Now Protected.</h3>';
	}
	$wp_PMB_Deact_Click = get_option('PMB_Deact_Click');
	$wp_PMB_Deact_txt = get_option('PMB_Deact_txt');
	?>
	<div class="wrap">
	<h2>Blog Protector - Options Page</h2>
	<form method="post" id="PMB_OPT">
		<fieldset class="options">
      <table class="form-table">
      <tr valign="top">

      <h3 style="text-align: left">Our Network</h3>
      <h4><a href="https://www.geekenized.com">Geekenized Technologies</a>.com |&nbsp;
 <a href="https://www.PcDrome.com">PcDrome</a>.com |&nbsp;<a href="https://www.GeekyCube.com">GeekyCube</a>.com</h4>
            <td>


	  <h3><input type="checkbox" id="PMB_Deact_Click" name="PMB_Deact_Click" value="PMB_Deact_Click" <?php if($wp_PMB_Deact_Click == true) { echo('checked="checked"'); } ?> />: Disable Right Click Of Mouse.</h3>
				Enter Warning Message Here :<input name="PMB_Deact_Click_text" type="text" id="PMB_Deact_Click_text" value="<?php echo get_option('PMB_Deact_Click_text') ;?>" size="60"/>
				<br></br>This Text Will Be Displayed When User Right Clicks On Blog.
				</td>
			</tr><td>
			<h3><input type="checkbox" id="PMB_Deact_txt" name="PMB_Deact_txt" value="PMB_Deact_txt" <?php if($wp_PMB_Deact_txt == true) { echo('checked="checked"'); } ?> />: Deactivate Text Selection And Image Dragging.(Highly Recommended)</h3>
    		</td><tr><td>
		<input type="submit" name="PMB_Update" value="Update" />
                </td>
        </tr>
        </table>



<h1 style="text-align: right">Powered By <a href="https://www.geekycube.com" target="_blank">Geeky Cube</a>.com & <a href="https://www.pcdrome.com" target="_blank">PcDrome.com</a> </h1>
		</fieldset>
	</form>
	</table>
	</div>
	<?php
}
//We are calling you, function
function Protect_My_Blog()
{


	$wp_PMB_Deact_txt = get_option('PMB_Deact_txt');
	$wp_PMB_Deact_Click_text = get_option('PMB_Deact_Click_text');
    $wp_PMB_Deact_Click = get_option('PMB_Deact_Click');
	$pos = strpos(strtoupper(getenv("REQUEST_URI")), '?preview=true');

	if ($pos === false) {
		if($wp_PMB_Deact_Click == true) { PMB_Disable_Right_Click($wp_PMB_Deact_Click_text); }
		if($wp_PMB_Deact_txt == true) { PMB_Disable_Selection(); }
	}
}

function ProtectMyBlog_footer()
{
	$wp_PMB_Deact_txt = get_option('PMB_Deact_txt');

	if($wp_PMB_Deact_txt == true) { PMB_Footer(); }
}

function ProtectMyBlog_Admin()
{
	if (function_exists('add_options_page')) {
		add_options_page('Blog Protector', 'Blog Protector', 9, basename(__FILE__),'PMB_OPT');
	}
}

	/**
	 * Adds Custom settings option below other links on Manage Plugins page.
	 */
	function ProtectMyBlog_actions( $links, $file ) {
		if( $file == 'blog-protector/blog-protector.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=blog-protector.php' ) . '">' .'Settings' . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
	}	

//  Commanding the Wordpress
add_action('wp_head','Protect_My_Blog');
add_action('wp_footer','ProtectMyBlog_footer');
add_action('admin_menu','ProtectMyBlog_Admin',1);
add_filter('plugin_action_links', 'ProtectMyBlog_actions', 10, 2 );
?>
