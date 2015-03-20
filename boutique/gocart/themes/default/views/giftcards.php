
<!-- 
	<div class="span4">
		<div id="primary-img" style="margin-bottom: 15px; background: #fff;">
			<?php
			if ($this->config->item ( 'language' ) == 'french') {
				echo theme_img ( 'giftcard_fr.jpg', lang ( 'giftcard' ) );
			} else {
				echo theme_img ( 'giftcard.jpg', lang ( 'giftcard' ) );
			}
			?>
		</div>
	</div>
	-->

<div class="span9">

<div class="row-fluid">

<div class="span12">
	
				<?php $gift_card_form_array_attributes = array('id' => 'gift-card-form'); ?>
				<?php echo form_open('cart/giftcard', $gift_card_form_array_attributes);?>
			
					<div class="row-fluid">
<div class="span12">
<div class="page-header-cn-couettabra main-header middle"
	style="margin: 0 0 30px; background: #6e6e6d;">
<h1><?php echo lang('giftcard');?></h1>
</div>
</div>
</div>
					
					<?php if(is_array($preset_values)):?>
					<div class="row-fluid">
<div class="span8 offset4">
<div class="control-group">
<div class="controls"><label class="radio">
										<?php
						if (set_value ( 'amount' ) == 'preset_amount') {
							$checked = true;
							$dropdown_style = 'style="display: block;"';
						} else {
							$checked = false;
							$dropdown_style = 'style="display: none;"';
						}
						
						echo form_radio ( 'amount', 'preset_amount', $checked, 'style="margin-top: 1px;"' );
						?>
										<span style="padding-top: 5px; padding-bottom: 5px;"><?php echo lang('giftcard_choose_amount');?></span>
</label></div>
</div>
			
							<?php
						foreach ( $preset_values as $value ) {
							//$options[$value] = format_currency($value);
							

							$value = number_format ( round ( abs ( ( float ) $value * ( float ) $this->session->userdata ( 'currency_rate' ) ), 0, PHP_ROUND_HALF_DOWN ), $this->session->userdata ( 'currency_decimal_place' ), $this->config->item ( 'currency_decimal' ), $this->config->item ( 'currency_thousands_separator' ) );
							$options [$value] = $this->session->userdata ( 'currency_symbol' ) . ' ' . $value;
						}
						
						$giftcard_dropdown_preset_amount_attributes = 'id="gift-card-preset-amount" ' . $dropdown_style;
						
						echo form_dropdown ( 'preset_amount', $options, set_value ( 'preset_amount' ), $giftcard_dropdown_preset_amount_attributes );
						?>
						</div>
</div>
					<?php endif;?>
					
					<?php if($allow_custom_amount):?>
					<div class="row-fluid">
<div class="span7 offset5" style="width: 100%;">
<p class="text-left"
	style="width: 100%; text-align: left; padding-left: 20px; padding-top: 10px;"><?php echo lang('or');?></p>
</div>
</div>

<div class="row-fluid">
<div class="span8 offset4">
<div class="control-group">
<div class="controls"><label class="radio">
										<?php
						if (set_value ( 'amount' ) == 'custom_amount') {
							$checked = true;
							$input_style = 'style="display: block;"';
						} else {
							$checked = false;
							$input_style = 'style="display: none;"';
						}
						
						echo form_radio ( 'amount', 'custom_amount', $checked, 'style="margin-top: 1px;"' );
						?>
										<span style="padding-top: 5px; padding-bottom: 5px;"><?php echo lang('giftcard_custom_amount');?></span>
</label></div>
</div>
							<?php
						$giftcard_form_input_custom_amount_attributes = 'id="gift-card-custom-amount" ' . $input_style;
						
						echo form_input ( 'custom_amount', set_value ( 'custom_amount' ), $giftcard_form_input_custom_amount_attributes );
						?>
						</div>
</div>
					<?php endif;?>
					
					<br />
<br />

<div class="row-fluid">
<div class="span8 offset4">
<div class="control-group"><label><?php echo lang('giftcard_to');?></label>
								<?php echo form_input('gc_to_name', set_value('gc_to_name')); ?>
						
								<label><?php echo lang('giftcard_email');?></label>
								<?php echo form_input('gc_to_email', set_value('gc_to_email')); ?>
						
								<label><?php echo lang('giftcard_from');?></label>
								<?php echo form_input('gc_from', set_value('gc_from')); ?>
						
								<label><?php echo lang('giftcard_message');?></label>
								<?php
								$data = array ('name' => 'message', 'rows' => '5', 'cols' => '30' );
								
								echo form_textarea ( $data, set_value ( 'message' ) );
								?>
							</div>
</div>
</div>
<div class="row-fluid">
<div class="span8 offset4">
<div class="control-group"><input type="submit" class="btn btn-primary"
	value="<?php echo lang('form_add_to_cart');?>" /></div>
</div>
</div>

</form>

<script type="text/javascript">
					$script.ready(['jquery_local_0'], function() {
						$(document).ready(function(){
							$("input[name='amount']").click(function() {
								$("#gift-card-custom-amount").hide( "fast" );
								$("#gift-card-preset-amount").hide( "fast" );
								if($('input:radio[name=amount]:checked').val() == "preset_amount"){
									//alert('You clicked radio preset amount!');
									$("#gift-card-preset-amount").show( "fast" );
							    }
								if($('input:radio[name=amount]:checked').val() == "custom_amount"){
									//alert('You clicked radio custom amount!');
									$("#gift-card-custom-amount").show( "fast" );
							    }
							});
						});
					});
				</script></div>

</div>

</div>