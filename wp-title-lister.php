<?php
/*
Plugin Name: WP Title Lister
Plugin URI: http://www.flashcentury.net/wp-title-lister
Description: Wp title lister Plugin is a plugin which is arranged for especially archive sites of wide blogs.
Version: 1.04
Author: Huseyin Kocak
Author URI: http://www.flashcentury.net
License: 
*/

/*
Copyright 2010 Wp Title Lister (email : info@k-78.de)

This program is free software: you can redistribute it and modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

K78 - Let´s do more!

*/


define ( 'WTLDIR', WP_PLUGIN_DIR . '/wp-title-lister' );
define ( 'WTLURL', WP_PLUGIN_URL . '/wp-title-lister' );
define ( 'WTLVERSION', '1.04');

load_plugin_textdomain( 'wp-title-lister', false, dirname(plugin_basename(__FILE__)) .  '/lang' );

function WTLFonksiyon()
{
echo '<link href="'.WTLURL.'/style.css" rel="stylesheet" type="text/css">';	
?>
<div id="container">
<div class="metabox-holder" id="header">
	<div class="postbox">
		<div id="header-colour">
		<?php //echo 'WTLDIR =' . WTLDIR . '<br />'; 
			  //echo 'WTLURL =' . WTLURL . '<br />'; 
		?>
			<div id="header-title">Wordpress Title Lister | <?php _e('Version', 'wp-title-lister') ?> <?php echo WTLVERSION; ?></div>

				<div id="header-links">
					<ul>
						<li><a href="options-general.php?page=wp-title-lister.php&sayfa=table"><?php _e('Title', 'wp-title-lister') ?></a> | </li>
						<li><a href="options-general.php?page=wp-title-lister.php&sayfa=ayar"><?php _e('Setting', 'wp-title-lister') ?></a> </li>
					</ul>
				</div>
	<div class="clearer"></div>
			</div>	
	



<div id="orta">

			<div id="content">
<?php
	
$sayfa=$_GET['sayfa'];

if($sayfa=='table'){
require_once(WTLDIR.'/wp-title-lister-table.php' );
}elseif ($sayfa=='ayar'){
require_once(WTLDIR.'/wp-title-lister-ayar.php' );
}else{
require_once(WTLDIR.'/wp-title-lister-table.php' );
}
?>

			</div>





<div id="content">
<br />
<br />

<h3><?php _e('Informations and support', 'wp-title-lister') ?></h3>
<br />
<br />
<div style="width:100%; text-align:center;"><a href="http://www.k-78.de/" target="_blank" title="K78 Let`s do more!"><img src="<?php echo WTLURL ?>/images/logo.jpg" alt="K78 Let`s do more!" border="0" style="margin:5px;"></a></div>
<br />
<br />

</div>



			
</div><!-- orta -->




<div class="clearer"></div>
</div><!-- //postbox -->
</div>

</div>

<?php
}
function wpTitleLister() {
	if (function_exists('add_options_page')) {
		add_options_page('wp-title-lister', 'WP Title Lister', 8, basename(__FILE__), 'WTLFonksiyon');	
	}
}
add_action('admin_menu', 'wpTitleLister');
?>