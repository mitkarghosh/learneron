<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LearnerOn</title>
</head>
<body style="margin:0; padding:0px; background-color:#fff;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" style="font-family:sans-serif;color:#5c5c5c;font-size:13px;">
		<tr>
			<td align="center" valign="top">
				<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f7f7f7">
					<tr bgcolor="#000">
						<td colspan="3" style="text-align:center;padding-left:15px; padding-top:10px; padding-bottom:10px;"><a href="<?php echo $url; ?>"><img src="<?php echo $url ?>images/logo.png" alt="LearnerOn" /></a></td>
					</tr>
					<tr bgcolor="#414042">
						<td colspan="4" style="color:#ffffff;font-size:16px; font-weight:bold; text-align:center; padding:10px 15px;">Notification</td>
					</tr>
					<tr>
						<td colspan="4" style="font-size:13px; line-height:22px; padding:30px">Hi <?php echo $to_user['user']['name']; ?>,<br/>
						<p>
							<table width="90%" border="0" style="text-align:left; font-family:Arial, Helvetica, sans-serif; color:#333333" cellpadding="5" cellspacing="5">					
								<tr>
									<td>							
									A new comment has been posted under the news, titled: <a href="<?php echo $news_url;?>"><?php echo $news_title;?></a><br />
									You will be able to see comment after admin approval.							
									</td>
								</tr>								
							</table>
						</p>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="font-size:13px; line-height:22px; padding-left: 30px">Thank you,<br> LearnerOn.Net Team.</td><br>
					</tr> 
					<tr bgcolor="#414042">
						<td colspan="4" style="padding:15px; text-align:center"><a style="color:#ffffff; text-decoration:none" href="javascript:void(0);" target="_blank"><?php echo $settings['phone_number']; ?></a> <span style="color:#fff">|</span> <a style="color:#ffffff; text-decoration:none" href="mailto:<?php echo $settings->email; ?>"><?php echo $settings->email; ?></a></td>
					</tr>
				</table>
			</td>
        </tr>
	</table>
</body>
</html>