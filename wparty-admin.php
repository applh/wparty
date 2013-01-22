<?php

   global $WParty;

$WParty['admin_html']=
<<<WPARTYADMIN
<h3>WParty</h3>

<form method="post" action="{$_SERVER['REQUEST_URI']}">
<table>
<tbody>
<tr>
<td>
<textarea rows="20" cols="80">
</textarea>
</td>
</tr>
<tr>
<td>
<input type="submit" value="Submit">
</td>
</tr>
</tbody>
</table>
</form>
WPARTYADMIN;

function wparty_admin () {
   global $WParty;
   
   echo $WParty['admin_html'];

}

function wparty_admin_init () {
   add_options_page( 'WParty', 'WParty', 'edit_themes', 'wparty.php', 'wparty_admin');
}


add_action('admin_menu', 'wparty_admin_init');

