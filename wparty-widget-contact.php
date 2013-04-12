<?php


if (!function_exists('wparty_widget_contact')) :
function wparty_widget_contact ($res, $instance, $args, $content='') {
   global $WParty;
   $N="\n";

   $defaults = array(
"name" => "",
"mailfrom" => "",
"mailto" => "",
"email" => "",
"subject" => "",
"message" => "",
"send" => "SEND",
"target" => get_permalink(),
"response" => "",
"error" => "",
"missing" => "",
"rows" => "10",
"prefix" => "[CONTACT] ",
   );
   $tab_args = wp_parse_args( $args, $defaults );   

   $model0=
<<<MODEL0
 <div class="form-content">
<form method="post" action="TARGET">
<div><label>Your Name</label></div>
<div><input type="text" name="contact-name" value="NAME"></div>
<div><label>Your Email</label></div>
<div><input type="text" name="contact-email" value="EMAIL"></div>
<div><label>Subject</label></div>
<div><input type="text" name="contact-subject" value="SUBJECT"></div>
<div><label>Message</label></div>
<div><textarea name="contact-message" rows="ROWS">
MESSAGE
</textarea></div>

<div><input type="submit" name="contact0-submit" value="SEND"></div>

<div class="response">
<div class="response-ok" style="STYLE-OK"><h3>Message Sent. Thanks for your interest.</h3></div>
<div class="response-error" style="STYLE-KO">[PROBLEM]... Please try again later...</div>
<div class="response-missing" style="STYLE-MISSING">[MISSING]... Please fill missing information...</div>
</div>

<div><input type="hidden" name="contact0-key" value="MD5KEY"></div>
<div><input type="hidden" name="contact0-mandatory" value=""></div>
FORMEXTRA
</form>
 </div>
MODEL0;

   if (!empty($content)) {
      $model0=$content;
   }

   $tab_args['md5key']=md5($tab_args['target']);

   $translate=array(
"NAME" => $tab_args["name"],
"EMAIL" => $tab_args["email"],
"SUBJECT" => $tab_args["subject"],
"MESSAGE" => $tab_args["message"],
"TARGET" => $tab_args["target"],
"SEND" => $tab_args["send"],
"RESPONSE" => '',
"STYLE-OK" => 'display:none;',
"STYLE-KO" => 'display:none;',
"STYLE-MISSING" => 'display:none;',
"FORMEXTRA" => '',
"MD5KEY" => $tab_args["md5key"],
"ROWS" => $tab_args["rows"],
   );

   $check2ok=false;

   $check2mandatory=array("email", "message");
   $check2count = 0;
   $check2missing = 0;

   foreach($check2mandatory as $curcheck) {
      if (isset($_REQUEST["contact-$curcheck"])) {
         $form2cur=stripslashes(trim($_REQUEST["contact-$curcheck"]));
         if (!empty($form2cur)) {
            $check2count++;
         }
         else {
            $check2missing++;
         }
      }
   }

   if ($check2count == count($check2mandatory)) {
      $check2ok=true;
   }

   if ($check2missing > 0) {
      $translate['STYLE-MISSING']='display:block;';
   }
   
   // optional key protection
   if (!empty($_REQUEST['contact0-key']) && ($_REQUEST['contact0-key'] != $tab_args['md5key'])) {
      $check2ok=false;
   }

   if ($check2ok || $check2missing) {
      $translate['NAME'] = trim(stripslashes($_REQUEST['contact-name']));
      $translate['EMAIL'] = trim(stripslashes($_REQUEST['contact-email']));
      $translate['SUBJECT'] = trim(stripslashes($_REQUEST['contact-subject']));
      $translate['MESSAGE'] = trim(stripslashes($_REQUEST['contact-message']));
   }

   if ($check2ok) {
      $translate['RESPONSE'] = "";

      $mail2headers=array();

      if ($tab_args['mailfrom'] == "auto") {
         // set from: to visitor email
         $mail2from=sanitize_email($translate['EMAIL']);
         $mail2fromname=sanitize_title($translate['NAME']);

         if (!empty($mail2from)) {
            $mail2headers[] = "From: $mail2fromname <$mail2from>";
         }
      }

      $mail2subject=$tab_args['prefix'].$translate['SUBJECT'];
      $mail2message=$tab_args['target'];

      $mailto=$tab_args['mailto'];
      if (empty($mailto)) {
         $mailto=get_the_author_meta('user_email');
      }
      if (empty($mailto)) {
         $mailto=get_option('admin_email');
      }
      if (!empty($mailto)) {
         if (empty($mail2subject)) {
            $mail2subject='['.get_option('blogname').']';
         }
         $mail2message.="\n-----\n";
         $mail2message.='from: '.$translate['NAME'];
         $mail2message.="\n";
         $mail2message.='mail: '.$translate['EMAIL'];
         $mail2message.="\n";
         $mail2message.='ip: '.$_SERVER['REMOTE_ADDR'];
         $mail2message.="\n";
         $mail2message.='date: '.date("d/m/y H:i:s");
         $mail2message.="\n-----\n";

         // extra fields
         foreach($_REQUEST as $rvar => $rval) {
            if (FALSE !== strpos($rvar, "contact-")) {
               $curvar=str_replace("contact-", "", $rvar);
               $rval1=trim(stripslashes($rval));
               $mail2message.="\n[$curvar]\n$rval1\n";
            }
         }
         $mail2message.="\n-----\n";

         $mail2ok=wp_mail( $mailto, $mail2subject, $mail2message, $mail2headers );

         if ($mail2ok) {
            $translate['RESPONSE']=$tab_args['response'];
            $translate['STYLE-OK']='display:block;';
         }
         else {
            $translate['RESPONSE']=$tab_args['error'];
            $translate['STYLE-KO']='display:block;';
         }
      }

   }
   
   $form2extra='';
   apply_filters('wparty_form_extra', $form2extra);
   $translate['FORMEXTRA']=$form2extra;

   $model1=do_shortcode($model0);
   $htmlpost=str_replace(array_keys($translate), array_values($translate), $model1);
   echo $htmlpost;
 
}
endif;





