<?php include('header.php'); ?>
<div class="row">
<div class="span12">
<div class="btn-group pull-right"><a class="btn"
	title="<?php echo lang('send_email_notification');?>"
	onclick="$('#notification_form').slideToggle();"><i
	class="icon-envelope"></i> <?php echo lang('send_email_notification');?></a>
<a class="btn"
	href="<?php echo site_url('admin/orders/packing_slip/'.$order->id);?>"
	target="_blank"><i class="icon-file"></i><?php echo lang('packing_slip');?></a>
</div>
</div>
</div>

<br>
<br>

<script type="text/javascript">
// store message content in JS to eliminate the need to do an ajax call with every selection
var messages = <?php
$messages = array ();
foreach ( $msg_templates as $msg ) {
	$messages [$msg ['id']] = array ('subject' => $msg ['subject'], 'content' => $msg ['content'] );
}
echo json_encode ( $messages );
?>;
//alert(messages[3].subject);
// store customer name information, so names are indexed by email
var customer_names = <?php
echo json_encode ( array ($order->email => $order->firstname . ' ' . $order->lastname, $order->ship_email => $order->ship_firstname . ' ' . $order->ship_lastname, $order->bill_email => $order->bill_firstname . ' ' . $order->bill_lastname ) );
?>;
// use our customer names var to update the customer name in the template
function update_name()
{
	if($('#canned_messages').val().length>0)
	{
		set_canned_message($('#canned_messages').val());
	}
}

function set_canned_message(id)
{
	// update the customer name variable before setting content	
	$('#msg_subject').val(messages[id]['subject'].replace(/{customer_name}/g, customer_names[$('#recipient_name').val()]));
	if($('#notification_form').find('.redactor_box').length > 0)
	{
		$('#notification_form').find('.redactor_box').remove();
		$('#notification_form').find("label:contains('Message')").after('<textarea id="content_editor" name="content" class="redactor"></textarea>');
		$('#content_editor').val(messages[id]['content'].replace(/{customer_name}/g, customer_names[$('#recipient_name').val()]));
		$('.redactor').redactor({
			imageUpload: '<?php echo site_url($this->config->item('admin_folder').'/media/redactor_upload');?>',
	        imageUploadErrorCallback: function(json)
	        {
	            alert(json.error);
	        },   
			focus: true,
			plugins: ['fileBrowser'],
			convertDivs: false,
			allowedTags: ['p', 'h1', 'h2', 'div', 'ul', 'li', 'br', 'b', 'em', 'strong', 'span']
		});
	}
}	
</script>

<div id="notification_form" class="row" style="display: none;">
<div class="span12">
		<?php echo form_open($this->config->item('admin_folder').'/orders/send_notification/'.$order->id);?>
			<fieldset><label><?php echo lang('message_templates');?></label> <select
	id="canned_messages" onchange="set_canned_message(this.value)"
	class="span12">
	<option><?php echo lang('select_canned_message');?></option>
					<?php
					
foreach ( $msg_templates as $msg ) {
						echo '<option value="' . $msg ['id'] . '">' . $msg ['name'] . '</option>';
					}
					?>
				</select> <label><?php echo lang('recipient');?></label> <select
	name="recipient" onchange="update_name()" id="recipient_name"
	class='span12'>
					<?php
					if (! empty ( $order->email )) {
						echo '<option value="' . $order->email . '">' . lang ( 'account_main_email' ) . ' (' . $order->email . ')';
					}
					if (! empty ( $order->ship_email )) {
						echo '<option value="' . $order->ship_email . '">' . lang ( 'shipping_email' ) . ' (' . $order->ship_email . ')';
					}
					if ($order->bill_email != $order->ship_email) {
						echo '<option value="' . $order->bill_email . '">' . lang ( 'billing_email' ) . ' (' . $order->bill_email . ')';
					}
					?>
				</select> <label><?php echo lang('subject');?></label> <input
	type="text" name="subject" size="40" id="msg_subject" class="span12" />

<label><?php echo lang('message');?></label> <textarea
	id="content_editor" name="content" class="redactor"></textarea>

<div class="form-actions"><input type="submit" class="btn btn-primary"
	value="<?php echo lang('send_message');?>" /></div>
</fieldset>
</form>
</div>
</div>

<div class="row" style="margin-top: 10px;">
<div class="span4">
<h3><?php echo lang('account_info');?></h3>
<p>
		<?php echo (!empty($order->company))?$order->company.'<br>':'';?>
		<?php echo $order->firstname;?> <?php echo $order->lastname;?> <br />
		<?php echo $order->email;?> <br />
		<?php echo $order->phone;?>
		</p>
</div>
<div class="span4">
<h3><?php echo lang('billing_address');?></h3>
		<?php echo (!empty($order->bill_company))?$order->bill_company.'<br/>':'';?>
		<?php echo $order->bill_firstname.' '.$order->bill_lastname;?> <br />
		<?php echo $order->bill_address1;?><br>
		<?php echo (!empty($order->bill_address2))?$order->bill_address2.'<br/>':'';?>
		<?php echo $order->bill_city.', '.$order->bill_zone.' '.$order->bill_zip;?><br />
		<?php echo $order->bill_country;?><br />
		
		<?php echo $order->bill_email;?><br />
		<?php echo $order->bill_phone;?>
	</div>
<div class="span4">
<h3><?php echo lang('shipping_address');?></h3>
		<?php echo (!empty($order->ship_company))?$order->ship_company.'<br/>':'';?>
		<?php echo $order->ship_firstname.' '.$order->ship_lastname;?> <br />
		<?php echo $order->ship_address1;?><br>
		<?php echo (!empty($order->ship_address2))?$order->ship_address2.'<br/>':'';?>
		<?php echo $order->ship_city.', '.$order->ship_zone.' '.$order->ship_zip;?><br />
		<?php echo $order->ship_country;?><br />
		
		<?php echo $order->ship_email;?><br />
		<?php echo $order->ship_phone;?>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
<div class="span4">
<h3><?php echo lang('order_details');?></h3>
<p>
		<?php if(!empty($order->referral)):?>
			<strong><?php echo lang('referral');?>: </strong><?php echo $order->referral;?><br />
		<?php endif;?>
		<?php if(!empty($order->is_gift)):?>
			<strong><?php echo lang('is_gift');?></strong>
		<?php endif;?>
		
		<?php if(!empty($order->gift_message)):?>
			<strong><?php echo lang('gift_note');?></strong><br />
			<?php echo $order->gift_message;?>
		<?php endif;?>
		</p>
</div>
<div class="span4">
<h3><?php echo lang('payment_method');?></h3>
<p><?php echo $order->payment_info; ?></p>
</div>
<div class="span4">
<h3><?php echo lang('shipping_details');?></h3>
		<?php echo $order->shipping_method; ?>
		<?php if(!empty($order->shipping_notes)):?><div
	style="margin-top: 10px;"><?php echo $order->shipping_notes;?></div><?php endif;?>
		
		<?php preg_match('/Numéro d\'expédition Mondial Relay #([0-9]{8})/mi', $order->notes, $match_parcelInformation);?>
		
		<?php if($mondiale_relay_create_shipment_btn):?>
		
			<?php if($match_parcelInformation == false):?>
			<?php if(!$this->config->item('redirect_only_to_mondial_relay_interface_for_create_shipment')):?>
			<br>
<button class="btn" id="relay-button" data-toggle="modal"
	data-target="#relay-modal"><?php echo lang('create_shipment_mondiale_relay');?></button>
			<?php else:?>
			<br>
<a class="btn"
	href="https://www.mondialrelay.fr/ww2/espaces/enseigne.aspx"><?php echo lang('create_shipment_mondiale_relay');?></a>
			<?php endif;?>
			<?php endif;?>
			
			<?php if($match_parcelInformation == true):?>
				<?php if($order->status == "Shipped"):?>
			
					<?php if($match_parcelInformation):?>
						<?php $attributes_parcel_info_form = array('id' => 'parcelInformationMondialeRelayForm', 'class' => 'form-horizontal');?>
						<br>
						<?php echo form_open('admin/orders/get_parcel_info_mondiale_relay/'.$order->id, $attributes_parcel_info_form);?>
							<input id="exp_id" type="hidden" name="exp_id"
	value="<?php echo $match_parcelInformation[1];?>" /> <input
	id="order_id" type="hidden" name="order_id"
	value="<?php echo $order->id;?>" /> <input class="btn"
	id="get-parcel-info-btn" type="submit"
	value="<?php echo lang('get_parcel_info_mondiale_relay');?>" /> </from>
					<?php endif;?>
				<?php endif;?>
			<?php endif;?>
		<?php endif;?>
	</div>
</div>

<?php echo form_open($this->config->item('admin_folder').'/orders/view/'.$order->id, 'class="form-inline"');?>
<fieldset>
<div class="row" style="margin-top: 20px;">
<div class="span8">
<h3><?php echo lang('admin_notes');?></h3>
<textarea name="notes" class="span8"><?php echo $order->notes;?></textarea>
</div>


<div class="span4">
<h3><?php echo lang('status');?></h3>
			<?php
			$select_colors_array = ( array ) $this->config->item ( 'order_statuses_colors' );
			$select_class = 'class="span4 selectpicker" data-style="btn-' . $select_colors_array [$order->status] . '"';
			echo form_dropdown ( 'status', $this->config->item ( 'order_statuses' ), $order->status, $select_class );
			?>
		</div>
</div>

<div class="form-actions"><input type="submit" class="btn btn-primary"
	value="<?php echo lang('update_order');?>" /></div>
</fieldset>
</form>


<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('name');?></th>
			<th><?php echo lang('description');?></th>
			<th><?php echo lang('price');?></th>
			<th style="text-align: right;"><?php echo lang('quantity');?></th>
			<th style="text-align: right;"><?php echo lang('total');?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($order->contents as $orderkey=>$product):?>
		<?php
			
			if ($product ['name'] == 'Carte-cadeau') {
				if ($this->session->userdata ( 'language' ) == 'french') {
					$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/giftcard_fr.jpg" alt="Carte-cadeau" />';
				} else {
					$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/giftcard.jpg" alt="Gift Card" />';
				}
			} elseif ($product ['name'] == 'Gift Card') {
				if ($this->session->userdata ( 'language' ) == 'french') {
					$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/giftcard_fr.jpg" alt="Carte-cadeau" />';
				} else {
					$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/giftcard_fr.jpg" alt="Gift Card" />';
				}
			} else {
				if (isset ( $product ['images'] )) {
					$images = (( array ) json_decode ( strval ( $product ['images'] ) ));
					
					if (! empty ( $images )) {
						$count = 0;
						foreach ( $images as $image ) {
							if ($count == 0) {
								$file_name = $image->filename;
							}
							
							if (isset ( $image->primary ) && $image->primary == true) {
								$file_name = $image->filename;
							}
							
							$count += 1;
						}
						
						$path = $this->config->item ( 'upload_server_path' ) . 'images/tiny/' . $file_name;
						$type = pathinfo ( $path, PATHINFO_EXTENSION );
						$data = file_get_contents ( $path );
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode ( $data );
						$photo = '<img src="' . $base64 . '" alt="' . $product ['name'] . '">';
					} else {
						$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/' . 'no_picture.png" alt="' . lang ( 'no_image_available' ) . '" />';
					}
				} else {
					$photo = '<img src="' . $this->config->item ( 'asset_url' ) . 'default/assets/img/' . 'no_picture.png" alt="' . lang ( 'no_image_available' ) . '" />';
				}
			}
			?>
		<tr>
			<td>
				<?php echo $product['name'];?>
				<?php echo (trim($product['sku']) != '')?'<br/><small>'.$product['sku'].'</small><br/>'.$photo:'<br/>'.$photo;?>
				
			</td>
			<td>
				<?php //echo $product['excerpt'];?>
				<?php
			
			// Print options
			if (isset ( $product ['options'] )) {
				foreach ( $product ['options'] as $name => $value ) {
					$name = explode ( '-', $name );
					$name = trim ( $name [0] );
					if (is_array ( $value )) {
						echo '<div>' . $name . ':<br/>';
						foreach ( $value as $item ) {
							echo '- ' . $item . '<br/>';
						}
						echo "</div>";
					} else {
						echo '<div>' . $name . ': ' . $value . '</div>';
					}
				}
			}
			
			if (isset ( $product ['gc_status'] ))
				echo $product ['gc_status'];
			?>
			</td>
			<td>
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$product['price'])*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
			<td style="text-align: right;"><?php echo $product['quantity'];?></td>
			<td style="text-align: right;">
			
				<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$product['price'])*((float)$product['quantity'])*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			
				<br />
				
				<?php if($product['subtotal'] != $product['price']*$product['quantity']): ?>
				<?php if(isset($order->group_discount_formula)) : ?>
				<span style="text-align: right;"><?php echo $order->group_discount_formula;?></span>
			<br />
				<?php else: ?>
				<br />
				<?php endif;?>
				<span style="text-align: right;"><?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$product['subtotal'])*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>&nbsp;</span>
				<?php endif;?>
			
			</td>
		</tr>
		<?php endforeach;?>
		</tbody>

	<tfoot>
		
	<?php if((bool)$order->tax_is_vat == true):?>
	<?php
		/**************************************************************
	VAT
		 **************************************************************/
		?>
		
		<?php /*var_dump($order)*/ ;?>
		
		<?php if($order->coupon_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('coupon_discount');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">&#8722; 
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->coupon_discount)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif;?>
		
		<tr>
			<td><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_ttc');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->subtotal)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>

		<tr>
			<td><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_net');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->taxable_total_vat)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>

		<tr>
			<td><strong><?php echo sprintf (lang('tax_vat_merchandise_only'), ($this->config->item('vat_tax_rate') * 100).' %');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->tax_vat)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		
		<?php
		$charges = @$order->custom_charges;
		if (! empty ( $charges )) {
			foreach ( $charges as $name => $price ) :
				?>
				
		<tr>
			<td><strong><?php echo $name?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">+
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$price)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>	
				
		<?php
			
endforeach
			;
		}
		?>
		
		<?php if(!$this->config->item('additional_tax_shipping') && $order->tax > 0) : ?>
		<tr>
			<td colspan="4"><strong><?php echo sprintf (lang('tax_add_merchandise_only'), round(($order->tax / $order->total * 100), 0).' %');?></strong></td>
			<td style="text-align: right;">+
		    <?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->tax)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif; ?>	
		
		<tr>
			<td><strong><?php echo lang('shipping');?></strong></td>
			<td colspan="3"><?php echo $order->shipping_method; ?></td>
			<td style="text-align: right;">+ 
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->shipping)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		
		<?php if($this->config->item('additional_tax_shipping') && $order->tax > 0) : ?>
		<tr>
			<?php if(!$this->config->item('additional_tax_applied_only_to_shipping')):?>
			<td colspan="4"><strong><?php echo sprintf (lang('tax_vat_merchandise_and_shipping'), round(($order->tax / $order->total * 100), 0).' %');?></strong></td>
		    <?php else: ?>
			<td colspan="4"><strong><?php echo sprintf (lang('tax_vat_merchandise_only'), round(($order->tax / $order->total * 100), 0).' %');?></strong></td>
		    <?php endif;?>
			<td style="text-align: right;">+ 
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->tax)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif; ?>	
		
		<?php if($order->gift_card_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('giftcard_discount');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">&#8722; 
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->gift_card_discount)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td>
			<h3><?php echo lang('total');?></h3>
			</td>
			<td colspan="3"></td>
			<td style="text-align: right; padding-top: 25px; font-size: 20px;"><strong>
			<?php if($order->currency != 'EUR'): ?>
			<?php echo $order->currency . ' ' . number_format( abs( ((float)$order->total)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			<br>
			<small><?php echo 'soit €' . ' ' . number_format($order->total, $order->currency_decimal_place, '.', ','); ?></small>
			<?php else: ?>
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->total)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			<?php endif; ?>
			</strong></td>
		</tr>
		
	<?php else: ?>
	<?php
		/**************************************************************
	Non VAT
		 **************************************************************/
		?>
	
		<?php if($order->coupon_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('coupon_discount');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">&#8722;
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->coupon_discount)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif;?>
		
		<tr>
			<td><strong><?php echo lang('subtotal');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->subtotal)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		
		<?php
		$charges = @$order->custom_charges;
		if (! empty ( $charges )) {
			foreach ( $charges as $name => $price ) :
				?>
				
		<tr>
			<td><strong><?php echo $name?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">+
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$price)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>	
				
		<?php
			
endforeach
			;
		}
		?>
		<tr>
			<td><strong><?php echo lang('shipping');?></strong></td>
			<td colspan="3"><?php echo $order->shipping_method; ?></td>
			<td style="text-align: right;">+
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->shipping)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>

		<tr>
			<td><strong><?php echo lang('tax');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">+
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->tax)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php if($order->gift_card_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('giftcard_discount');?></strong></td>
			<td colspan="3"></td>
			<td style="text-align: right;">&#8722;
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->gift_card_discount)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td>
			<h3><?php echo lang('total');?></h3>
			</td>
			<td colspan="3"></td>
			<td style="text-align: right;"><strong>
			<?php if($order->currency != 'EUR'): ?>
			<?php echo $order->currency . ' ' . number_format( abs( ((float)$order->total)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			<br>
			<small><?php echo 'soit €' . ' ' . number_format($order->total, $order->currency_decimal_place, '.', ','); ?></small>
			<?php else: ?>
			<?php echo $order->currency_symbol . ' ' . number_format( abs( ((float)$order->total)*((float)$order->currency_rate) ), $order->currency_decimal_place, '.', ','); ?>
			<?php endif; ?>
			</strong></td>
		</tr>
		
	<?php endif;?>
	
	</tfoot>
</table>

<?php if($mondiale_relay_create_shipment_btn):?>
<div class="modal hide" id="relay-modal" data-backdrop="true"
	style="width: 100%; max-width: 650px;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">×</button>
<h2>Enregistrement d’une expédition Mondiale Relay</h2>
</div>
	<?php $attributes_form = array('id' => 'createMondialeRelayShipmentForm', 'class' => 'form-horizontal');?>
	<?php echo form_open('admin/orders/create_shipment_mondiale_relay/'.$order->id, $attributes_form);?>
		
		<div class="modal-body">

<fieldset class="span6"><legend>Options</legend>
<div class="control-group span6"><label class="control-label"
	for="mode_de_collecte"><?php echo ucfirst(lang('collection_mode'));?></label>
<div class="controls">
						<?php
	echo form_dropdown ( 'mode_de_collecte', $mode_de_collecte, 'CCC', 'class="span4" required="required"' );
	?>
						
					</div>
</div>
<div class="control-group span6"><label class="control-label"
	for="mode_de_livraison"><?php echo ucfirst(lang('delivery_mode'));?></label>
<div class="controls">
						<?php
	echo form_dropdown ( 'mode_de_livraison', $mode_de_livraison, '24R', 'class="span4" required="required"' );
	?>
					</div>
</div>
<div class="control-group span6"><label class="control-label"
	for="mode_de_livraison">Dimension</label>
<div class="controls form-inline"><label for="taille"><span><?php echo ucfirst(lang('size'));?></span>
						<?php
	echo form_dropdown ( 'taille', $taille, 'L', 'class="span1"' );
	?>
						</label> <span>&nbsp;&nbsp;&nbsp;</span> <label for="dimension"><span><?php echo ucfirst(lang('dimension'));?></span>
						<?php
	$attributes_dimension = array ('name' => 'dimension', 'id' => lang ( 'dimension' ), 'value' => '', 'class' => 'span1' );
	echo form_input ( $attributes_dimension );
	?>
						<span class="help-inline"> cm</span> </label></div>
</div>
</fieldset>

<fieldset class="span6"><legend>Destinataire</legend>

<div class="control-group span6"><label class="control-label"
	for="dest_civilite"><?php echo ucfirst(lang('civil_status'));?></label>
<div class="controls controls-row">
						<?php
	echo form_dropdown ( 'dest_civilite', $civilite, 'MME', 'class="span1" required="required"' );
	?>
						
						<?php
	$attributes_firstname = array ('name' => 'dest_firstname', 'id' => lang ( 'firstname_addressee' ), 'value' => $order->ship_firstname, 'class' => 'span2', 'style' => 'max-width: 100px;', 'required' => 'required' );
	echo form_input ( $attributes_firstname );
	?>
						
						<?php
	$attributes_lastname = array ('name' => 'dest_lastname', 'id' => lang ( 'lastname_addressee' ), 'value' => $order->ship_lastname, 'class' => 'span2', 'style' => 'max-width: 100px;', 'required' => 'required' );
	echo form_input ( $attributes_lastname );
	?>
						
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Ad2"><?php echo ucfirst(lang('dest_addr2'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Ad2', 'id' => lang ( 'dest_addr2' ), 'value' => '', 'class' => 'span4' );
	echo form_input ( $attributes_firstname );
	?>
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Ad3"><?php echo ucfirst(lang('dest_addr3'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Ad3', 'id' => lang ( 'dest_addr3' ), 'value' => $order->ship_address1, 'class' => 'span4', 'required' => 'required' );
	echo form_input ( $attributes_firstname );
	?>
						
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Ad4"><?php echo ucfirst(lang('dest_addr4'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Ad4', 'id' => lang ( 'dest_addr4' ), 'value' => (! empty ( $order->ship_address2 )) ? $order->ship_address2 : '', 'class' => 'span4' );
	echo form_input ( $attributes_firstname );
	?>
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Ville"><?php echo ucfirst(lang('dest_city'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Ville', 'id' => lang ( 'dest_city' ), 'value' => $order->ship_city, 'class' => 'span4', 'required' => 'required' );
	echo form_input ( $attributes_firstname );
	?>
						
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_CP"><?php echo ucfirst(lang('dest_post_code'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_CP', 'id' => lang ( 'dest_post_code' ), 'value' => $order->ship_zip, 'class' => 'span4', 'required' => 'required' );
	echo form_input ( $attributes_firstname );
	?>
						
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Tel1"><?php echo ucfirst(lang('dest_tel'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Tel1', 'id' => lang ( 'dest_tel' ), 'value' => preg_replace ( '/[\s]/', '', $order->ship_phone ), 'class' => 'span2' );
	echo form_input ( $attributes_firstname );
	?>
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="Dest_Mail"><?php echo ucfirst(lang('dest_email'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_firstname = array ('name' => 'Dest_Mail', 'id' => lang ( 'dest_email' ), 'value' => $order->ship_email, 'class' => 'span2' );
	echo form_input ( $attributes_firstname );
	?>
					</div>
</div>

</fieldset>

<fieldset class="span6"><legend>Colis</legend>

<div class="control-group span6"><label class="control-label"
	for="poids"><?php echo ucfirst(lang('shipment_weight'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_poids = array ('name' => 'poids', 'id' => lang ( 'shipment_weight' ), 'value' => number_format ( ( float ) $product ['weight'], 3, '.', '' ), 'class' => 'span1', 'placeholder' => '0.000', 'required' => 'required' );
	echo form_input ( $attributes_poids );
	?>
						<span class="help-inline"> kg</span></div>
</div>

<div class="control-group span6"><label class="control-label"
	for="NbColis"><?php echo ucfirst(lang('number_of_parcels'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_nbcolis = array ('name' => 'NbColis', 'id' => lang ( 'number_of_parcels' ), 'value' => 1, 'class' => 'span1', 'required' => 'required' );
	echo form_input ( $attributes_nbcolis );
	?>
						
					</div>
</div>

<div class="control-group span6"><label class="control-label"
	for="CRT_Valeur"><?php echo ucfirst(lang('cash_on_delivery'));?></label>
<div class="controls form-inline">
						<?php
	$attributes_contre_remboursement = array ('name' => 'CRT_Valeur', 'id' => lang ( 'cash_on_delivery' ), 'value' => '0.00', 'class' => 'span1', 'placeholder' => '0.00' );
	echo form_input ( $attributes_contre_remboursement );
	?>
						<span class="help-inline"> EUR</span></div>
</div>

</fieldset>

<input id="order_id" type="hidden" name="order_id"
	value="<?php echo $order->id;?>" /> <input id="NDossier" type="hidden"
	name="NDossier" value="<?php echo $order->order_number;?>" />
			
			<?php preg_match('#ParcelShopId"\>(.*?)\<\/span\>#m', $order->shipping_notes, $match_ParcelShopId);?>
			<input id="LIV_Rel" type="hidden" name="LIV_Rel"
	value="<?php if($match_ParcelShopId) echo $match_ParcelShopId[1];?>" />
			<?php preg_match('#ParcelShopCountryCode"\>(.*?)\<\/span\>#m', $order->shipping_notes, $match_ParcelShopCountryCode);?>
			<input id="LIV_Rel_Pays" type="hidden" name="LIV_Rel_Pays"
	value="<?php if($match_ParcelShopCountryCode) echo $match_ParcelShopCountryCode[1];?>" />

<input id="Dest_Pays" type="hidden" name="Dest_Pays"
	value="<?php if($match_ParcelShopCountryCode) echo $match_ParcelShopCountryCode[1];?>" />
<input id="Exp_Valeur" type="hidden" name="Exp_Valeur"
	value="<?php echo $order->subtotal;?>" /></div>
<div class="modal-footer">
<div class="form-actions"><input class="btn btn-primary"
	id="validate-create-shipment-mondiale-relay-btn" type="submit"
	value="&nbsp;&nbsp;Valider&nbsp;&nbsp;" /></div>
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){

	$('#validate-create-shipment-mondiale-relay-btn').click(function() {
		$('#relay-modal').modal('hide');
	});

});
</script>
<?php endif;?>

<script type="text/javascript">
$(document).ready(function(){

	$('.selectpicker').selectpicker();

	$('.selectpicker').on("change", function(e) {

		$(this).next().find('.btn.dropdown-toggle.selectpicker').attr('class',"btn dropdown-toggle selectpicker");
		
		var new_selected_option = $(this).find('option:selected').val();
		var new_selected_data_style = '';

		$.each(order_statuses_colors_json_object, function(key,val){
		    if(key == new_selected_option)
			{
				new_selected_data_style = 'btn-'+val;
			}
		});

		//alert(new_selected_data_style);
		//alert($(this).get(0).tagName);
		
		$(this).selectpicker('setStyle', new_selected_data_style);
	});

});
</script>
<?php /*print_r($order);*/?>

<?php include('footer.php');