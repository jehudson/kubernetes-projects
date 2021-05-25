<?php
error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {

        // require a name from user
        if(trim($_POST['contactName']) === '') {
                $nameError =  'Forgot your name!';
                $hasError = true;
        } else {
                $name = trim($_POST['contactName']);
        }

        // need valid email
        if(trim($_POST['email']) === '')  {
                $emailError = 'Forgot to enter in your e-mail address.';
                $hasError = true;
        } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
                $emailError = 'You entered an invalid email address.';
                $hasError = true;
        } else {
                $email = trim($_POST['email']);
        }

        // we need at least some content
        if(trim($_POST['comments']) === '') {
                $commentError = 'You forgot to enter a message!';
                $hasError = true;
        } else {
                if(function_exists('stripslashes')) {
                        $comments = stripslashes(trim($_POST['comments']));
                } else {
                        $comments = trim($_POST['comments']);
                }
        }

        // upon no failure errors let's email now!
        if(!isset($hasError)) {

                $emailTo = 'carol@notpavarotti.org.uk';
                $subject = 'Submitted message from '.$name;
                $sendCopy = trim($_POST['sendCopy']);
                $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
                $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

                mail($emailTo, $subject, $body, $headers);

        // set our boolean completion value to TRUE
                $emailSent = true;
        }
}
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carol-Anne Grainger - Soprano</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="contact-styles.css">
<link rel="stylesheet" type="text/css" href="main.css">

</head>

<body>
<table width="864" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="96" bgcolor="#FFFFFF"><img src="Images/logo.png" width="96" height="68" /></td>
    <td width="96" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="96" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="96">&nbsp;</td>
  </tr>
<tr style="background-color: #93BAc6; height: 30px;">
<td width="96">       <a href="index.html" class="button">Home</a></td>
<td width="96">       <a href="biography.html" class="button">Biography</a></td>
<td width="96">       <a href="repertoire.html" class="button">Repertoire</a></td>
<td width="96">       <a href="sound.html" class="button">Sound</a></td>
<td width="96">       <a href="press.html" class="button">Press</a></td>
<td width="96">       <a href="gallery.html" class="button">Gallery</a></td>
<td width="96">       <a href="contact.php" class="button">Contact</a></td>
<td width="96">       <a href=" links.html" class="button">Links</a></td>
<td width="96" bgcolor="#93BAC6">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="3"  valign="top" bgcolor="#314140"><img align="top" src="Images/Carol-Ann-058.jpg" width="288" height="442" /></td>
    <td colspan="6" valign="top" bgcolor="#314140"><span class="style1"></span><span class="style1"></span><span class="style1"></span><span class="style1"></span><span class="style1"></span><span class="style1"></span>
      <table width="384" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><p class="style2">&nbsp;</p>
          <p class="style2">&nbsp;</p></td>
        </tr>
        <tr>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
 <!-- @begin contact -->
	<div id="contact" class="section">
		<div class="container content">
		
	        <?php if(isset($emailSent) && $emailSent == true) { ?>
                <p class="info">Your email was sent. Huzzah!</p>
            <?php } else { ?>
            
				<div class="desc">
					<p id="contact-head">Contact Carol-Anne</p>
					
					<p class="desc">Please use the form to send your enquiry, I would love to hear from you!</p>
				</div>
				
				<div id="contact-form">
					<?php if(isset($hasError) || isset($captchaError) ) { ?>
                        <p class="alert">Error submitting the form</p>
                    <?php } ?>
				
					<form id="contact-us" action="contact.php" method="post">
						<div class="formblock">
							<label class="screen-reader-text">Name</label>
							<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt requiredField" placeholder="Name:" />
							<?php if($nameError != '') { ?>
								<br /><span class="error"><?php echo $nameError;?></span> 
							<?php } ?>
						</div>
                        
						<div class="formblock">
							<label class="screen-reader-text">Email</label>
							<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField email" placeholder="Email:" />
							<?php if($emailError != '') { ?>
								<br /><span class="error"><?php echo $emailError;?></span>
							<?php } ?>
						</div>
                        
						<div class="formblock">
							<label class="screen-reader-text">Message</label>
							 <textarea name="comments" id="commentsText" class="txtarea requiredField" placeholder="Message:"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
							<?php if($commentError != '') { ?>
								<br /><span class="error"><?php echo $commentError;?></span> 
							<?php } ?>
						</div>
                        
							<button name="submit" type="submit" class="subbutton">Send Mail</button>
							<input type="hidden" name="submitted" id="submitted" value="true" />
					</form>			
				</div>
				
			<?php } ?>
		</div>
    </div><!-- End #contact -->
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
    <td bgcolor="#93BAC6">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	$(document).ready(function() {
		$('form#contact-us').submit(function() {
			$('form#contact-us .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('<span class="error">Your forgot to enter your '+labelText+'.</span>');
					$(this).addClass('inputError');
					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						var labelText = $(this).prev('label').text();
						$(this).parent().append('<span class="error">Sorry! You\'ve entered an invalid '+labelText+'.</span>');
						$(this).addClass('inputError');
						hasError = true;
					}
				}
			});
			if(!hasError) {
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					$('form#contact-us').slideUp("fast", function() {				   
						$(this).before('<p class="tick"><strong>Thanks!</strong> Your email has been delivered.</p>');
					});
				});
			}
			
			return false;	
		});
	});
	//-->!]]>
</script>
</body>
</html>

