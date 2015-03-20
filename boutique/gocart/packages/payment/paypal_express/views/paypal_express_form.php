<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<label><?php echo lang('enabled');?></label>
<select name="enabled" class="span3">
	<option value="1"
		<?php echo((bool)$settings['enabled'])?' selected="selected"':'';?>><?php echo lang('enabled');?></option>
	<option value="0"
		<?php echo((bool)$settings['enabled'])?'':' selected="selected"';?>><?php echo lang('disabled');?></option>
</select>

<br>
<br>
<br>

<label><?php echo lang('test_mode_label');?></label>
<select name="SANDBOX" class="span3">
	<option value="1"
		<?php echo((bool)$settings['SANDBOX'])?' selected="selected"':'';?>><?php echo lang('test_mode');?></option>
	<option value="0"
		<?php echo((bool)$settings['SANDBOX'])?'':' selected="selected"';?>><?php echo lang('live_mode');?></option>
</select>

<br>
<br>
<br>

<label><?php echo lang('currency') ?></label>
<input class="span3" name="currency"
	value="<?php echo @$settings["currency"] ?>" />
<?php echo lang('currency_label')?>

<br>
<br>
<br>

<label><?php echo lang('pp_username') ?> Sandbox</label>
<input class="span3" name="username_sandbox" type="text"
	value="<?php echo @$settings["username_sandbox"] ?>" size="50">

<br>

<label><?php echo lang('pp_password') ?> Sandbox</label>
<input class="span3" name="password_sandbox" type="text"
	value="<?php echo @$settings["password_sandbox"] ?>" size="50">

<br>

<label><?php echo lang('pp_key') ?> Sandbox</label>
<input class="span3" name="signature_sandbox" type="text"
	value="<?php echo @$settings["signature_sandbox"] ?>" size="50" />

<br>
<br>
<br>

<label><?php echo lang('pp_username') ?> Live</label>
<input class="span3" name="username" type="text"
	value="<?php echo @$settings["username"] ?>" size="50">

<br>

<label><?php echo lang('pp_password') ?> Live</label>
<input class="span3" name="password" type="text"
	value="<?php echo @$settings["password"] ?>" size="50">

<br>

<label><?php echo lang('pp_key') ?> Live</label>
<input class="span3" name="signature" type="text"
	value="<?php echo @$settings["signature"] ?>" size="50" />
