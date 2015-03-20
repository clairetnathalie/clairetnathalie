<div class="page-header-cn-couettabra" style="margin: 0 0 30px;">
<h2><?php echo lang('form_checkout_procedure');?></h2>
</div>

<?php if (validation_errors()):?>
<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
		<?php echo validation_errors();?>
	</div>
<?php endif;?>

<?php include('order_details.php');?>

<?php $attributes = array('id' => 'shipMethodForm');?>

<?php echo form_open('checkout/step_2', $attributes);?>
<div class="row">
<div class="span6">
<h2><?php echo lang('shipping_method');?></h2>
<div class="alert alert-error" id="shipping_error_box"
	style="display: none"></div>
				
				<?php /*var_dump($shipping_methods)*/ ;?>
				
				<?php
				foreach ( $shipping_methods as $key => $val ) :
					$ship_encoded = md5 ( json_encode ( array ($key, $val ) ) );
					if ($ship_encoded == $shipping_code) {
						$checked = true;
					} else {
						$checked = false;
					}
					?>
				<?php if( preg_match('/Mondial Relay/i', $val['entity_common_name']) && count($relay_list) > 0 && isset($relay_list)): ?>
				<div class="shipping-method-elements">
<div style="width: 90%; float: left; height: inherit;">
<table class="table shipping-details-list"
	style="margin: 0; height: inherit;">
	<tr class="shipping-details" style="cursor: pointer"
		data-ship-method-hash="s<?php echo $ship_encoded;?>">
		<td style="width: 10%; vertical-align: middle;"><label
			class="radio relay-radio" style="margin-top: 2px;"><?php echo form_radio('shipping_method', $ship_encoded, set_radio('shipping_method', $ship_encoded, $checked), 'class="radio-shipping-details" id="s'.$ship_encoded.'"');?></label>
		</td>
		<td id="method-common-name"
			style="width: 22%; vertical-align: middle; height: 30px;"><span><?php echo $val['entity_common_name'];?></span></td>
		<td style="width: 48%; vertical-align: middle;"
			id="relay-button-holder"></td>
		<td style="width: 20%; vertical-align: middle; height: 30px;"
			class="shipping-method-element-section"><span><strong><?php echo $val['str'];?></strong></span></td>
	</tr>
</table>
</div>

<div
	style="width: 10%; float: right; height: inherit; overflow: hidden;">
						
						<?php if($val['entity_description'] != ''):?>
						<div id="delivery-info-s<?php echo $ship_encoded;?>"
	style="height: inherit; margin: 0;" data-toggle="popover"
	title="<?php echo ($this->config->item('language') == 'french')?'Info Livraison':'Delivery Info';?>"
	data-trigger="hover" data-placement="left" data-html="true"
	data-animation="true" data-color="blue"
	data-content="<?=htmlspecialchars($val['entity_description']);?>"><i
	class="icon-info-sign"
	style="position: relative; top: 22.5px; height: 15px; width: 15px; text-align: center; vertical-align: middle;"></i>
</div>

<script type="text/javascript">
							$script.ready(['bootstrap_js_0'], function() {
								$(document).ready(function(){
							
									$('#delivery-info-s<?php echo $ship_encoded;?>').hover(function() {
										$(this).popover('show');
									});
		
								});
							});	
						</script>
						
						<?php endif;?>
						
					</div>

</div>	
				<?php elseif(!preg_match('/Mondial Relay/i', $val['entity_common_name'])):?>
				<div class="shipping-method-elements">
<div style="width: 90%; float: left; height: inherit;">
<table class="table shipping-details-list"
	style="margin: 0; height: inherit;">
	<tr class="shipping-details" style="cursor: pointer"
		data-ship-method-hash="s<?php echo $ship_encoded;?>">
		<td style="width: 10%; vertical-align: middle;"><label class="radio"
			style="margin-top: 2px;"><?php echo form_radio('shipping_method', $ship_encoded, set_radio('shipping_method', $ship_encoded, $checked), 'class="radio-shipping-details" id="s'.$ship_encoded.'"');?></label>
		</td>
		<td id="method-common-name"
			style="width: 70%; vertical-align: middle; height: 30px;"><span><?php echo $val['entity_common_name'];?></span></td>
		<td style="width: 20%; vertical-align: middle; height: 30px;"><span><strong><?php echo $val['str'];?></strong></span></td>
	</tr>
</table>
</div>

<div
	style="width: 10%; float: right; height: inherit; overflow: hidden;">
						
						<?php if($val['entity_description'] != ''):?>
						<div id="delivery-info-s<?php echo $ship_encoded;?>"
	style="height: inherit; margin: 0;" data-toggle="popover"
	title="<?php echo ($this->config->item('language') == 'french')?'Info Livraison':'Delivery Info';?>"
	data-trigger="hover" data-placement="left" data-html="true"
	data-animation="true" data-color="blue"
	data-content="<?=htmlspecialchars($val['entity_description']);?>"><i
	class="icon-info-sign"
	style="position: relative; top: 22.5px; height: 15px; width: 15px; text-align: center; vertical-align: middle;"></i>
</div>

<script type="text/javascript">
							$script.ready(['bootstrap_js_0'], function() {
							
								$('#delivery-info-s<?php echo $ship_encoded;?>').hover(function() {
									$(this).popover('show');
								});
								
							});
						</script>
						
						<?php endif;?>
						
					</div>

</div>	
				<?php endif;?>
				
				<?php endforeach;?>
		</div>
<div class="span6">
<h2><?php echo lang('shipping_instructions')?></h2>
			<?php echo form_textarea(array('name'=>'shipping_notes', 'value'=>set_value('shipping_notes', $this->go_cart->get_additional_detail('shipping_notes')), 'class'=>'span6', 'style'=>'height:200px;'));?>
		</div>
</div>
<br>
<!-- inserts for form -->
</form>

<div class="modal hide" id="relay-modal" data-backdrop="true"
	style="width: 90%; max-width: 600px;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">×</button>
<h2>Points Relais</h2>
</div>

<div class="modal-body">
<table
	style="width: 100%; border-top: none; margin-top: 50px; margin-bottom: 50px;">
	<tr>
		<td style="text-align: center">
						<?php
						
foreach ( $relay_list as $relay_pt ) :
							//print_r($relay_pt);
							if ($relay_point == $relay_pt->ParcelShopId) {
								$checked = true;
							} else {
								$checked = false;
							}
							?>
						
						<div class="points-relais-elements">

		<div style="width: 90%; float: left; height: inherit;">

		<table class="table" style="margin: 0; height: inherit;">

			<tr class="points-relais-details" style="cursor: pointer"
				data-relais-point-num="<?php echo $relay_pt->ParcelShopId;?>">
				<td style="width: 10%; vertical-align: middle;"><label
					class="radio points-relais-selection" style=""><?php echo form_radio('points-relais', $relay_pt->ParcelShopId, set_radio('points-relais', $relay_pt->ParcelShopId, $checked), 'class="radio-points-relais" id="'.$relay_pt->ParcelShopId.'"');?></label>
				</td>
				<td id="points-relais-addr"
					style="width: 60%; vertical-align: middle; height: inherit;">
				<p style="vertical-align: middle;">
				
				
				<address style="margin: auto;">
													<?php if($relay_pt->Name != ''):?>
													<span><strong><?php echo $relay_pt->Name;?></strong></span><br>
													<?php endif;?>
													<?php if($relay_pt->Adress1 != ''):?>
													<span><?php echo $relay_pt->Adress1;?></span><br>
													<?php endif;?>
													<?php if($relay_pt->Adress2 != ''):?>
													<span><?php echo $relay_pt->Adress2;?></span><br>
													<?php endif;?>
													<span><?php echo $relay_pt->City;?>, <?php echo $relay_pt->PostCode;?></span>
				</address>
				</p>
				</td>
				<td class="points-relais-info-locate"
					style="width: 30%; vertical-align: middle; height: inherit;">
											<?php if($relay_pt->LocalisationDetails != ''):?>
												<span><small><i><?php echo $relay_pt->LocalisationDetails;?></i></small></span>
											<?php endif;?>
										</td>
			</tr>

		</table>

		</div>

		<div style="width: 10%; float: right; height: inherit;">

		<table style="margin: 0 0 0 20px; height: inherit;">
									<?php if($relay_pt->MapUrl != ''):?>
									<tr>
				<td id="map-location-info-<?php echo $relay_pt->ParcelShopId;?>"
					class="popup-marker" style="vertical-align: middle;"
					title="<?php echo lang('relay_point_map');?>" data-toggle="popover"
					data-trigger="manual" data-placement="left" data-html="true"
					data-animation="true"
					data-content="<?php echo htmlspecialchars('<!DOCTYPE html><html><head><meta charset="utf-8"/><meta http-quiv="Content-Type" content="text/html; charset=utf-8"/><title>Mondial Relay Map</title></head><body><iframe src="') . $relay_pt->MapUrl . '&resize=1' . htmlspecialchars('" height="230" width="390" scrolling="no" frameborder="no";></iframe></body></html>');?>">
				<i class="icon icon-map-marker"></i></td>
			</tr>
			<script type="text/javascript">
										$script.ready(['bootstrap_js_0'], function() {
											$('#map-location-info-<?php echo $relay_pt->ParcelShopId;?>').click(function(e) {
												if($(this).next('.popover').hasClass('in'))
												{
													$(this).popover('hide');
												}
												else
												{
													$(this).popover('show');
												}
												e.stopPropagation();
											});
										});
									</script>
									<?php endif;?>
									
									<?php if( !empty($relay_pt->OpeningHours) ):?>
									<?php $opening_hours_content = '';?>
									<?php
								
foreach ( $relay_pt->OpeningHours as $key => $val ) :
									
									if ($this->config->item ( 'language' ) == 'french') {
										if ($key == 'Monday') {
											$key = 'Lundi';
										} elseif ($key == 'Tuesday') {
											$key = 'Mardi';
										} elseif ($key == 'Wednesday') {
											$key = 'Mercredi';
										} elseif ($key == 'Thursday' || $key == 'Thirsday') {
											$key = 'Jeudi';
										} elseif ($key == 'Friday') {
											$key = 'Vendredi';
										} elseif ($key == 'Saturday') {
											$key = 'Samedi';
										} elseif ($key == 'Sunday') {
											$key = 'Dimanche';
										}
									}
									
									$opening_hours_content .= '  <div class="accordion" id="accordion-' . $relay_pt->ParcelShopId . '">';
									$opening_hours_content .= '    <div class="accordion-group">';
									$opening_hours_content .= '      <div class="accordion-heading">';
									$opening_hours_content .= '        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-' . $relay_pt->ParcelShopId . '" href="#collapse-' . $key . '">';
									$opening_hours_content .= '			<strong>' . $key . '</strong>';
									$opening_hours_content .= '        </a>';
									$opening_hours_content .= '      </div>';
									$opening_hours_content .= '     <div id="collapse-' . $key . '" class="accordion-body collapse">';
									$opening_hours_content .= '        <div class="accordion-inner">';
									
									foreach ( $val as $key => $timeslot ) {
										$opening_hours_content .= '			<p>' . $timeslot . '</p>';
									}
									
									$opening_hours_content .= '        </div>';
									$opening_hours_content .= '      </div>';
									$opening_hours_content .= '   </div>';
									?>
						        	<?php endforeach;?>
									<tr>
				<td id="opening-hours-info-<?php echo $relay_pt->ParcelShopId;?>"
					class="popup-marker" style="vertical-align: middle;"
					title="<?php echo lang('relay_point_opening_hours');?>"
					data-toggle="popover" data-trigger="manual" data-placement="left"
					data-html="true" data-animation="true"
					data-content="<?php echo htmlspecialchars('<div class="opening-hours-accordion">'.$opening_hours_content.'</div>'); ?>">
				<i class="icon icon-time"></i></td>
			</tr>
			<script type="text/javascript">
										$script.ready(['bootstrap_js_0'], function() {
											$('#opening-hours-info-<?php echo $relay_pt->ParcelShopId;?>').on('click', function(e) {
												if($(this).next('.popover').hasClass('in'))
												{
													$(this).popover('hide');
												}
												else
												{
													$(this).popover('show');
												}
											});
										});
									</script>
									<?php endif;?>
								</table>

		</div>

		</div>
						
						<?php endforeach;?>
					</td>
	</tr>
</table>
</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal">Valider</button>
</div>

</div>

<script type="text/javascript">
$script.ready(['bootstrap_js_0'], function() {
	
	$(document).ready(function() {
		if( $('.shipping-method-elements').find('.radio').children('input[type=radio]:checked').length )
		{
			if( $('.relay-radio').children('input[type=radio]:checked').length )
			{
				$('#relay-button-holder').html('<button class="btn btn-primary" id="relay-button" data-toggle="modal" data-target="#relay-modal"><?php echo lang('choose_relay_point_btn');?></button>');

				if( $('#relay-modal').find('*').find('.points-relais-selection').children('input[type=radio]:checked').length )
				{
					var num = $('#relay-modal').find('*').find('.points-relais-selection').children('input[type=radio]:checked').val();
					$('#shipMethodForm').append('<input class="btn btn-block btn-large btn-primary" id="continue-btn" type="submit" value="&nbsp;&nbsp;<?php echo lang('form_continue');?>&nbsp;&nbsp;"/>');
					if( !$('#shipMethodForm').find('input[value="relais_point_submit"]').length )
					{
						$('#shipMethodForm').append('<input type="hidden" value="relais_point_submit" name="relais_point_submit" />');
					}
					$('#shipMethodForm').find('input[name="relais_point_num"]').remove();
					$('#shipMethodForm').append('<input type="hidden" value="'+num+'" name="relais_point_num" />');
				}
				else
				{
					$('#shipMethodForm').append('<input class="btn btn-block btn-large btn-primary disabled" id="continue-btn" type="submit" value="&nbsp;&nbsp;<?php echo lang('form_continue');?>&nbsp;&nbsp;" disabled />');
				}
			}
			else
			{
				$('#shipMethodForm').append('<input class="btn btn-block btn-large btn-primary" id="continue-btn" type="submit" value="&nbsp;&nbsp;<?php echo lang('form_continue');?>&nbsp;&nbsp;"/>');
			}
		}
		else
		{
			$('#shipMethodForm').append('<input class="btn btn-block btn-large btn-primary disabled" id="continue-btn" type="submit" value="&nbsp;&nbsp;<?php echo lang('form_continue');?>&nbsp;&nbsp;" disabled />');
		}

		<?php if(isset($activate_point_relais_modal)):?>
		$('#relay-modal').modal('show');
		<?php endif;?>	
	});
	
	$('.shipping-details').click(function() {   
		$('.radio-shipping-details').each(function(){
			$(this).prop('checked', false);
			//$(this).removeProp('checked');
			//$(this).removeAttr('checked');
		});	
		var key = $(this).data('ship-method-hash');
		var check = $(this).find('#'+key);
		check.prop('checked', true);
		//check.attr('checked','checked');
		if ($(this).find('#relay-button-holder').length)
		{
			$('#relay-button-holder').html('<button class="btn btn-primary" id="relay-button" data-toggle="modal" data-target="#relay-modal"><?php echo lang('choose_relay_point_btn');?></button>');

			if($('#relay-modal').find('*').find('.points-relais-selection').children('input[type=radio]:checked').length)
			{
				var num = $('#relay-modal').find('*').find('.points-relais-selection').children('input[type=radio]:checked').val();
				$('#continue-btn').removeClass('disabled').removeProp('disabled');
				if( !$('#shipMethodForm').find('input[value="relais_point_submit"]').length )
				{
					$('#shipMethodForm').append('<input type="hidden" value="relais_point_submit" name="relais_point_submit" />');
				}
				$('#shipMethodForm').find('input[name="relais_point_num"]').remove();
				$('#shipMethodForm').append('<input type="hidden" value="'+num+'" name="relais_point_num" />');
			}
			else
			{
				$('#continue-btn').addClass('disabled').prop('disabled', true);
				$('#shipMethodForm').find('input[value="relais_point_submit"]').remove();
				$('#shipMethodForm').find('input[name="relais_point_num"]').remove();
			}
		}
		else
		{
			$('#relay-button-holder').children('#relay-button').remove();
			$('#continue-btn').removeClass('disabled').removeProp('disabled');
			$('#shipMethodForm').find('input[value="relais_point_submit"]').remove();
			$('#shipMethodForm').find('input[name="relais_point_num"]').remove();
		}
		
	});

	$('#relay-button').click(function() {
		
	});

	$('.points-relais-details').click(function() {   
		$('.radio-points-relais').each(function(){
			$(this).prop('checked', false);
			//$(this).removeProp('checked');
			//$(this).removeAttr('checked');
		});	
		var key = $(this).data('relais-point-num');
		var check = $(this).find('#'+key);
		check.prop('checked', true);
		//check.attr('checked','checked');
		$('#continue-btn').removeClass('disabled').removeProp('disabled');
		if( !$('#shipMethodForm').find('input[value="relais_point_submit"]').length )
		{
			$('#shipMethodForm').append('<input type="hidden" value="relais_point_submit" name="relais_point_submit" />');
		}
		$('#shipMethodForm').find('input[name="relais_point_num"]').remove();
		$('#shipMethodForm').append('<input type="hidden" value="'+key+'" name="relais_point_num" />');
	});

	$('html').on('mouseup', function(e) {
		if( $(e.target).parent('.popup-marker').next('.popover').hasClass('in') ) 
		{
			return;
		}
		if( $(e.target).next('.popover').hasClass('in') ) 
		{
			return;
		}
		else
		{
			if(!$(e.target).closest('.popover').length) {
		        $('.popover').each(function(){
		            $(this.previousSibling).popover('hide');
		        });
		    }
		}
	});

	$('.modal-body').scroll(function() {
		$('.popover').each(function(){
            $(this.previousSibling).popover('hide');
        });
	});
});
</script>
