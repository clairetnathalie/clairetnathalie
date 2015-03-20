<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<label><?php echo lang('enabled');?></label>
<select name="enabled" class="span3">
	<option value="1"
		<?php echo((bool)$settings['enabled'])?' selected="selected"':'';?>><?php echo lang('enabled');?></option>
	<option value="0"
		<?php echo((bool)$settings['enabled'])?'':' selected="selected"';?>><?php echo lang('disabled');?></option>
</select>

<label><?php echo lang('currency') ?></label>
<input class="span3" name="currency"
	value="<?php echo @$settings["currency"] ?>" />
<?php echo lang('currency_label')?>

<br>

<label><?php echo lang('gw_username') ?></label>
<input class="span3" name="username" type="text"
	value="<?php echo @$settings["username"] ?>" size="50">

<br>

<label><?php echo lang('gw_merchant_key') ?></label>
<input class="span3" name="merchant key" type="text"
	value="<?php echo @$settings["merchant_key"] ?>" size="50">

<br>

<label><?php echo lang('gw_merchant_id') ?></label>
<input class="span3" name="merchant id" type="text"
	value="<?php echo @$settings["merchant_id"] ?>" size="50" />
