<?php

if (!function_exists('wparty_widget_sidebar')) :
function wparty_widget_sidebar ($name) {
   global $WParty;
       if (!empty($WParty['sidebar.before'])) {
          echo $WParty['sidebar.before'];
       }
       dynamic_sidebar( $name );

       if (!empty($WParty['sidebar.after'])) {
          echo $WParty['sidebar.after'];
       }
}
endif;


