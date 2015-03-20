<?php
/*
$path 	= $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-top-left.png';
$type 	= pathinfo($path, PATHINFO_EXTENSION);
$data 	= file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
$left_corner_top_image 	= '<img src="'.$base64.'" alt="top left corner" style="width: 15px;height:15px;" />';



$path 	= $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-bottom-right.png';
$type 	= pathinfo($path, PATHINFO_EXTENSION);
$data 	= file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
$right_corner_bottom_image 	= '<img src="'.$base64.'" alt="right bottom corner" style="width: 15px;height:15px;" />';



$path 	= $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_top_654x113px.png';
$type 	= pathinfo($path, PATHINFO_EXTENSION);
$data 	= file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
$logo_top_image 	= '<img src="'.$base64.'" alt="top left corner" style="width: 220px;height:auto;" />';



$path 	= $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_bottom_654x20px.png';
$type 	= pathinfo($path, PATHINFO_EXTENSION);
$data 	= file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
$logo_bottom_image 	= '<img src="'.$base64.'" alt="right bottom corner" style="width: 220px;height:auto;" />';
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<!-- So that mobile webkit will display zoomed in -->
<meta name="format-detection" content="telephone=no">
<!-- disable auto telephone linking in iOS -->
<!-- <link rel="stylesheet" type="text/css" href="cid:order_email_stylesheet">  -->
<meta name="X-MC-Tags" content="purchased-items">
<meta name="X-MC-AutoText" content="on">

<title><?php echo lang('welcome')?> {customer_name}</title>
<style type="text/css">
/* Resets: see reset.css for details */
.ReadMsgBody {
	width: 100%;
	background-color: #6e6e6d;
}

.ExternalClass {
	width: 100%;
	background-color: #6e6e6d;
}

.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div
	{
	line-height: 100%;
}

body {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
}

body {
	margin: 0;
	padding: 0;
	background-color: #6e6e6d;
}

div.outer-wrapper {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
}

div.outer-wrapper {
	margin: 0;
	padding: 0;
}

p,h3 {
	padding: 0 5px 0 5px;
}

p {
	color: #6e6e6d;
	font-size: 15px;
}

.product-description p {
	color: #6e6e6d;
	font-size: 12px;
	line-height: 12px;
	text-overflow: ellipsis;
	padding: 0px;
}

table {
	border-spacing: 0;
}

table td {
	border-collapse: collapse;
}

.yshortcuts a {
	border-bottom: none !important;
}

/* Constrain email width for small screens */
@media screen and (max-width: 600px) {
	table[class="container"] {
		width: 95% !important;
	}
}

/* Give content more room on mobile */
@media screen and (max-width: 480px) {
	td[class="container-padding"] {
		padding-left: 12px !important;
		padding-right: 12px !important;
	}
}

/* Styles for forcing columns to rows */
@media only screen and (max-width : 600px) {
	/* force container columns to (horizontal) blocks */
	td[class="force-col"] {
		display: block;
		padding-right: 0 !important;
	}
	table[class="col-3"] { /* unset table align="left/right" */
		float: none !important;
		width: 100% !important;
		/* change left/right padding and margins to top/bottom ones */
		margin-bottom: 12px;
		padding-bottom: 12px;
		border-bottom: 1px solid #eee;
	}
	table[class="product-table"] { /* unset table align="left/right" */
		float: none !important;
		width: 100% !important;
		/* change left/right padding and margins to top/bottom ones */
		margin-bottom: 0;
		padding-bottom: 0;
		border-bottom: 1px solid #eee;
	}
	/* remove bottom border for last column/row */
	table[id="last-col-3"] {
		border-bottom: none !important;
		margin-bottom: 0;
	}
	/* align images right and shrink them a bit */
	img[class="col-3-img"] {
		float: right;
		margin-left: 6px;
		max-width: 130px;
	}
	img[class="product-img"] {
		float: left;
		max-width: 120px;
		max-height: 120px;
	}
	div[class="product-info"] {
		width: 100% !important;
	}
}
</style>
</head>

<body style="margin: 0; padding: 0; background-color: #6e6e6d;"
	bgcolor="#6e6e6d" leftmargin="0" topmargin="0" marginwidth="0"
	marginheight="0">

<div class="outer-wrapper"
	style="margin: 0; padding: 10px 0; color: #6e6e6d; background-color: #6e6e6d;">

<br>

<!-- 100% wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0"
	cellspacing="0" bgcolor="#6e6e6d">
	<tr>
		<td align="center" valign="top" bgcolor="#6e6e6d"
			style="background-color: #6e6e6d;"><!-- 600px container (white background) -->
		<table border="0" width="600" cellpadding="0" cellspacing="0"
			class="container" bgcolor="#ffffff">
			<tr>
				<td class="container-padding" bgcolor="#ffffff"
					style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;"
					align="left"><br>

				<table border="0" cellpadding="0" cellspacing="0"
					class="main-header">
					<tr>
						<td style="width: 15px; background-color: #ffffff;"
							valign="bottom"></td>
						<td
							style="width: 220px; height: auto; background-color: #ffffff; padding: 0; margin: 0;"
							valign="bottom">
                	<?php /*echo $logo_top_image;*/ ?>
                	<!-- <img src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/logo/cn_logo-email_top_654x113px.png');?>" style="width: 220px;height: auto;" /> -->
						<!-- <img src="cid:top_logo" alt="top logo" style="width: 220px; height: auto; padding: 0; margin: 0;" /> -->
						<img
							src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_logo-email_top_654x113px.png"
							style="width: 220px; height: auto; vertical-align: bottom;" /></td>
						<td style="width: 100%; background-color: #ffffff;"
							valign="bottom"></td>
						<td style="width: 15px; background-color: #ffffff;"
							valign="bottom"></td>
					</tr>
					<tr>
						<td
							style="width: 15px; height: 15px; background-color: #e64d56; padding: 0; margin: 0;"
							valign="top">
                	<?php /*echo $left_corner_top_image;*/ ?>
                	<!-- <img src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/icons/cn_corner-carousel-top-left.png');?>" style="width: 15px;height:15px;" /> -->
						<!-- <img src="cid:top_left_corner" alt="top left corner" style="width: 15px; height:15px; padding: 0; margin: 0;" /> -->
						<img
							src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-top-left.png"
							style="width: 15px; height: 15px;" /></td>
						<td
							style="width: 220px; height: auto; background-color: #e64d56; padding: 0; margin: 0;"
							valign="top">
                	<?php /*echo $logo_bottom_image;*/ ?>
                	<!-- <img src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/logo/cn_logo-email_bottom_654x20px.png');?>" style="width: 220px;height:auto;" /> -->
						<!-- <img src="cid:bottom_logo" alt="bottom logo" style="width: 220px; height: auto; padding: 0; margin: 0;" /> -->
						<img
							src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_logo-email_bottom_654x20px.png"
							style="width: 220px; height: auto; vertical-align: top;" /></td>
						<td style="width: 100%; height: 15px; background-color: #e64d56;"
							valign="top"></td>
						<td style="width: 15px; height: 15px; background-color: #e64d56;"
							valign="top"></td>
					</tr>
					<tr>
						<td style="background-color: #e64d56;" valign="middle"></td>
					</tr>
					<tr>
						<td style="width: 15px; height: 15px; background-color: #e64d56;"
							valign="bottom"></td>
						<td style="width: 220px; height: 15px; background-color: #e64d56;"
							valign="bottom"></td>
						<td style="width: 100%; height: 15px; background-color: #e64d56;"
							valign="bottom"></td>
						<td
							style="width: 15px; height: 15px; background-color: #e64d56; padding: 0; margin: 0;"
							valign="bottom">
              		<?php /*echo $right_corner_bottom_image;*/ ?>
                	<!-- <img src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/icons/cn_corner-carousel-bottom-right.png');?>" style="width: 15px;height:15px;"/> -->
						<!-- <img src="cid:bottom_right_corner" alt="bottom right corner" style="width: 15px; height: 15px; padding: 0; margin: 0;" /> -->
						<img
							src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-bottom-right.png"
							style="width: 15px; height: 15px; vertical-align: bottom;" /></td>
					</tr>
				</table>

				<br>