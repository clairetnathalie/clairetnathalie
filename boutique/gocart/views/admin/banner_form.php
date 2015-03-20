<?php include('header.php'); ?>


<?php
$title = array ('name' => 'title', 'value' => set_value ( 'title', $title ) );
$enable_on = array ('name' => 'enable_on', 'id' => 'enable_on', 'value' => set_value ( 'enable_on', set_value ( 'enable_on', $enable_on ) ) );
$disable_on = array ('name' => 'disable_on', 'id' => 'disable_on', 'value' => set_value ( 'disable_on', set_value ( 'disable_on', $disable_on ) ) );
$f_image = array ('name' => 'image', 'id' => 'image' );
$link = array ('name' => 'link', 'value' => set_value ( 'link', $link ) );
$new_window = array ('name' => 'new_window', 'value' => 1, 'checked' => set_checkbox ( 'new_window', 1, $new_window ) );
$description = array ('name' => 'description', 'class' => 'redactor', 'value' => set_value ( 'description', $description ), 'style' => 'height: 200px;' );
$alt_text = array ('name' => 'alt_text', 'class' => 'span8', 'value' => set_value ( 'alt_text', $alt_text ) );
$template_options = array ('0' => lang ( 'template_null' ), '1' => lang ( 'template_couettabra' ), '2' => lang ( 'template_bienvenue' ), '3' => lang ( 'template_bons_cadeaux' ), '4' => lang ( 'template_noel' ), '5' => lang ( 'template_bonne_année' ), '6' => lang ( 'template_st_valentin' ), '7' => lang ( 'template_soldes' ) );
?>

<div class="row">

<?php $attributes = array('class' => 'span12');?>
<?php echo form_open_multipart($this->config->item('admin_folder').'/banners/form/'.$id, $attributes); ?>

<div class="row">
<div class="span4">
<fieldset><label for="title"><?php echo lang('title');?> </label>
			<?php echo form_input($title); ?>
		
			<label for="link"><?php echo lang('link');?> </label>
			<?php echo form_input($link); ?>
		
			<label for="enable_on"><?php echo lang('enable_on');?> </label>
			<?php echo form_input($enable_on); ?>
		
			<label for="disable_on"><?php echo lang('disable_on');?> </label>
			<?php echo form_input($disable_on); ?>
		
			<label class="checkbox">
			    <?php echo form_checkbox($new_window); ?> <?php echo lang('new_window');?>
			</label></fieldset>
</div>

<div class="span8">
<fieldset><label for="template"><?php echo lang('template');?> </label>
			<?php echo form_dropdown('template', $template_options, strval($template)); ?>
			
			<br>

<label for="description"><?php echo lang('description');?> </label>
			<?php echo form_textarea($description); ?>
			
			<br>

<label for="alt_text"><?php echo lang('alt_text');?> </label>
			<?php echo form_input($alt_text); ?>
			
		</fieldset>
</div>
</div>

<div class="row">
<div class="span12">
<fieldset><label for="image"><?php echo lang('image');?> </label>
			<?php echo form_upload($f_image); ?>
		
			<?php if($id && $image != ''):?>
			<div
	style="text-align: center; padding: 5px; border: 1px solid #ccc;"><img
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').IMG_UPLOAD_FOLDER.'images/full/'.$image);?>"
	alt="current" /><br /><?php echo lang('current_file');?></div>
			<?php endif;?>

			<div class="form-actions"><input class="btn btn-primary"
	type="submit" value="<?php echo lang('save');?>" /></div>

</fieldset>
</div>
</div>

</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#enable_on").datepicker({ dateFormat: 'mm-dd-yy'});
		$("#disable_on").datepicker({ dateFormat: 'mm-dd-yy'});
	});
	
	$('form').submit(function() {
		$('.btn').attr('disabled', true).addClass('disabled');
	});
</script>
<?php include('footer.php'); ?>