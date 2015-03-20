<style type="text/css">
.placeholder {
	display: none;
}
</style>

<div class="page-header-cn-couettabra" style="margin: 0 0 30px;">
<h2><?php echo lang('form_checkout_procedure');?></h2>
</div>

<?php if (validation_errors()):?>
<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
		<?php echo validation_errors();?>
	</div>
<?php endif;?>

<script type="text/javascript">
$script.ready(['bootstrap_js_0'], function() {
	$(document).ready(function(){
		//if we support placeholder text, remove all the labels
		if(!supports_placeholder())
		{
			$('.placeholder').show();
		}
		
		function supports_placeholder()
		{
			return 'placeholder' in document.createElement('input');
		}
	});
});
</script>

<script type="text/javascript">
$script.ready(['bootstrap_js_0'], function() {
	$(document).ready(function() {
		$('#country_id').change(function(){
			populate_zone_menu();
		});	
	
		// context is ship or bill
		function populate_zone_menu(value)
		{
			$.post('<?php echo site_url('locations/get_zone_menu');?>',{id:$('#country_id').val()}, function(data) {
				$('#zone_id').html(data);
			});
		}
	});
});
</script>
<?php /* Only show this javascript if the user is logged in */ ?>
<?php if($this->Customer_model->is_logged_in(false, false)) : ?>
<script type="text/javascript">

	<?php
	$add_list = array ();
	foreach ( $customer_addresses as $row ) {
		// build a new array
		$add_list [$row ['id']] = $row ['field_data'];
	}
	$add_list = json_encode ( $add_list );
	echo "eval(addresses=$add_list);";
	?>
		
	function populate_address(address_id)
	{
		if(address_id == '')
		{
			return;
		}
		
		// - populate the fields
		$.each(addresses[address_id], function(key, value){
			
			$('.address[name='+key+']').val(value);

			// repopulate the zone menu and set the right value if we change the country
			if(key=='zone_id')
			{
				zone_id = value;
			}
		});
		
		// repopulate the zone list, set the right value, then copy all to billing
		$.post('<?php echo site_url('locations/get_zone_menu');?>',{id:$('#country_id').val()}, function(data) {
			$('#zone_id').html(data);
			$('#zone_id').val(zone_id);
		});		
	}
	
</script>
<?php endif;?>

<?php
$countries = $this->Location_model->get_countries_menu ();

if (! empty ( $customer [$address_form_prefix . '_address'] ['country_id'] )) {
	$zone_menu = $this->Location_model->get_zones_menu ( $customer [$address_form_prefix . '_address'] ['country_id'] );
} else {
	$zone_menu = array ('' => '' ) + $this->Location_model->get_zones_menu ( array_shift ( array_keys ( $countries ) ) );
}

//form elements


$company = array ('placeholder' => lang ( 'address_company' ), 'class' => 'address span8', 'name' => 'company', 'value' => set_value ( 'company', @$customer [$address_form_prefix . '_address'] ['company'] ) );
$address1 = array ('placeholder' => lang ( 'address1' ), 'class' => 'address span8', 'name' => 'address1', 'value' => set_value ( 'address1', @$customer [$address_form_prefix . '_address'] ['address1'] ) );
$address2 = array ('placeholder' => lang ( 'address2' ), 'class' => 'address span8', 'name' => 'address2', 'value' => set_value ( 'address2', @$customer [$address_form_prefix . '_address'] ['address2'] ) );
$first = array ('placeholder' => lang ( 'address_firstname' ), 'class' => 'address span4', 'name' => 'firstname', 'value' => set_value ( 'firstname', @$customer [$address_form_prefix . '_address'] ['firstname'] ) );
$last = array ('placeholder' => lang ( 'address_lastname' ), 'class' => 'address span4', 'name' => 'lastname', 'value' => set_value ( 'lastname', @$customer [$address_form_prefix . '_address'] ['lastname'] ) );
$email = array ('placeholder' => lang ( 'address_email' ), 'class' => 'address span4', 'name' => 'email', 'value' => set_value ( 'email', @$customer [$address_form_prefix . '_address'] ['email'] ) );
$phone = array ('placeholder' => lang ( 'address_phone' ), 'class' => 'address span4', 'name' => 'phone', 'value' => set_value ( 'phone', @$customer [$address_form_prefix . '_address'] ['phone'] ) );
$city = array ('placeholder' => lang ( 'address_city' ), 'class' => 'address span3', 'name' => 'city', 'value' => set_value ( 'city', @$customer [$address_form_prefix . '_address'] ['city'] ) );
$zip = array ('placeholder' => lang ( 'address_postcode' ), 'maxlength' => '10', 'class' => 'address span2', 'name' => 'zip', 'value' => set_value ( 'zip', @$customer [$address_form_prefix . '_address'] ['zip'] ) );

?>
	
	<?php
	//post to the correct place.
	echo ($address_form_prefix == 'ship') ? form_open ( 'checkout/step_1' ) : form_open ( 'checkout/billing_address' );
	?>
<div class="row">
			<?php // Address form ?>
			<div class="span8 offset2">
<div class="row">
<div class="span4">
<h2 style="margin: 0px; width: 100%;">
							<?php echo ($address_form_prefix == 'ship')?lang('shipping_address'):lang('billing_address');?>
						</h2>
</div>
<div class="span4">
						<?php if($this->Customer_model->is_logged_in(false, false)) : ?>
							<button class="btn btn-inverse pull-right"
	onclick="$('#address_manager').modal().modal('show');" type="button"><i
	class="icon-envelope icon-white"></i> <?php echo lang('choose_saved_address');?></button>
						<?php endif; ?>
					</div>
</div>

<div class="row">
<div class="span8"><label class="placeholder"><?php echo lang('address_company');?></label>
						<?php echo form_input($company);?>
					</div>
</div>
<div class="row">
<div class="span4"><label class="placeholder"><?php echo lang('address_firstname');?><b
	class="r"> *</b></label>
						<?php echo form_input($first);?>
					</div>
<div class="span4"><label class="placeholder"><?php echo lang('address_lastname');?><b
	class="r"> *</b></label>
						<?php echo form_input($last);?>
					</div>
</div>
<div class="row">
<div class="span4"><label class="placeholder"><?php echo lang('address_email');?><b
	class="r"> *</b></label>
						<?php echo form_input($email);?>
					</div>

<div class="span4"><label class="placeholder"><?php echo lang('address_phone');?><b
	class="r"> *</b></label>
						<?php echo form_input($phone);?>
					</div>
</div>

<div class="row">
<div class="span8 input-prepend"><span class="add-on address-country"><?php echo lang('address_country');?></span>
<label class="placeholder"><?php echo lang('address_country');?><b
	class="r"> *</b></label>
						<?php echo form_dropdown('country_id',$countries, @$customer[$address_form_prefix.'_address']['country_id'], 'id="country_id" class="address address-country"');?>
					</div>
</div>

<div class="row">
<div class="span8"><label class="placeholder"><?php echo lang('address1');?><b
	class="r"> *</b></label>
						<?php echo form_input($address1);?>
					</div>
</div>

<div class="row">
<div class="span8"><label class="placeholder"><?php echo lang('address2');?></label>
						<?php echo form_input($address2);?>
					</div>
</div>

<div class="row">
<div class="span3"><label class="placeholder"><?php echo lang('address_city');?><b
	class="r"> *</b></label>
						<?php echo form_input($city);?>
					</div>
<div class="span3 input-prepend"><span class="add-on address-state"><?php echo lang('address_state');?></span>
<label class="placeholder"><?php echo lang('address_state');?><b
	class="r"> *</b></label>
						<?php echo form_dropdown('zone_id',$zone_menu, @$customer[$address_form_prefix.'_address']['zone_id'], 'id="zone_id" class="address address-state span3" style="height: 32px;"');?>
					</div>
<div class="span2"><label class="placeholder"><?php echo lang('address_postcode');?><b
	class="r"> *</b></label>
						<?php echo form_input($zip);?>
					</div>
</div>

<div class="row">
<div class="span8"><input class="btn btn-block btn-large btn-primary"
	type="submit"
	value="&nbsp;&nbsp;<?php echo lang('form_continue');?>&nbsp;&nbsp;" />
</div>
</div>
</div>
</div>
</form>

<div class="row">
<div class="span6 offset3"><br>
<br>
<legend>
<h4><?php echo lang('checkout_step1_social');?></h4>
</legend></div>

<div class="span12">
<div class="btn-group">
<div class="btn-holder"><a class="btn btn-social btn-facebook"
	href="<?php echo base_url('/hauth/checkout/Facebook');?>"
	rel="nofollow"><strong><i class="icon-facebook" alt="Facebook Checkout"
	title="Facebook Checkout"></i> <small>Facebook</small></strong></a></div>
<!--
				<div class="btn-holder">
					<a class="btn btn-social btn-twitter" href="<?php echo base_url('/hauth/checkout/Twitter');?>" rel="nofollow"><strong><i class="icon-twitter" alt="Twitter Checkout" title="Twitter Checkout"></i> <small>Twitter</small></strong></a>
				</div>
				-->
<div class="btn-holder"><a class="btn btn-social btn-google-plus"
	href="<?php echo base_url('/hauth/checkout/Google');?>" rel="nofollow"><strong><i
	class="icon-google-plus" alt="Google Checkout" title="Google Checkout"></i>
<small>Google</small></strong></a></div>
<div class="btn-holder"><a class="btn btn-social btn-linkedin"
	href="<?php echo base_url('/hauth/checkout/LinkedIn');?>"
	rel="nofollow"><strong><i class="icon-linkedin" alt="Linkedin Checkout"
	title="Linkedin Checkout"></i> <small>Linkedin</small></strong></a></div>
</div>
</div>
</div>

<?php if($this->Customer_model->is_logged_in(false, false)) : ?>

<div class="modal hide" id="address_manager">
<div class="modal-header">
<button type="button" class="close dark" data-dismiss="modal">×</button>
<h3><?php echo lang('your_addresses');?></h3>
</div>
<div class="modal-body">
<p>


<table class="table table-striped">
			<?php
	$c = 1;
	foreach ( $customer_addresses as $a ) :
		?>
				<tr>
		<td>
						<?php
		$b = $a ['field_data'];
		echo nl2br ( format_address ( $b ) );
		?>
					</td>
		<td style="width: 100px;"><input type="button"
			class="btn btn-primary choose_address pull-right"
			onclick="populate_address(<?php echo $a['id'];?>);"
			data-dismiss="modal" value="<?php echo lang('form_choose');?>" /></td>
	</tr>
			<?php endforeach;?>
			</table>
</p>
</div>
<div class="modal-footer"><a href="#" class="btn btn-checkout"
	data-dismiss="modal"><?php echo lang('close');?></a></div>
</div>
<?php endif;?>