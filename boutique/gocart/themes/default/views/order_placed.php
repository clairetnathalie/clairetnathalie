<?php include('header.php'); ?>

<div class="page-header">
<h2><?php echo lang('order_number');?>: <?php echo $order_id;?></h2>
</div>

<?php
// content defined in canned messages
echo $download_section;
?>

<?php
$ship = $customer ['ship_address'];
$bill = $customer ['bill_address'];
?>
	
<?php if($this->go_cart->shipping_relay_point_info_txt() != false):?>
<div class="row">
<div class="span4">
<h3><?php echo lang('account_information');?></h3>
		<?php echo (!empty($customer['company']))?$customer['company'].'<br/>':'';?>
		<?php echo $customer['firstname'];?> <?php echo $customer['lastname'];?><br />
		<?php echo $customer['email'];?> <br />
		<?php echo $customer['phone'];?>
	</div>
<div class="span4">
<h3><?php echo lang('shipping_information');?></h3>
		<?php echo $ship['firstname'];?> <?php echo $ship['lastname'];?><br />
		<?php echo (!empty($ship['company']))?$ship['company'].'<br/>':'';?>
		<?php echo $ship['email'];?><br />
		<?php echo $ship['phone'];?><br />
<br />
<small><?php echo $this->go_cart->shipping_relay_point_info_txt();?></small>
</div>
<div class="span4">
<h3><?php echo lang('billing_information');?></h3>
		<?php echo format_address($bill, TRUE);?><br />
		<?php echo $bill['email'];?><br />
		<?php echo $bill['phone'];?>
	</div>
</div>
<?php else:?>
<div class="row">
<div class="span4">
<h3><?php echo lang('account_information');?></h3>
		<?php echo (!empty($customer['company']))?$customer['company'].'<br/>':'';?>
		<?php echo $customer['firstname'];?> <?php echo $customer['lastname'];?><br />
		<?php echo $customer['email'];?> <br />
		<?php echo $customer['phone'];?>
	</div>
<div class="span4">
<h3><?php echo ($ship != $bill)?lang('shipping_information'):lang('shipping_and_billing');?></h3>
		<?php echo format_address($ship, TRUE);?><br />
		<?php echo $ship['email'];?><br />
		<?php echo $ship['phone'];?>
	</div>
	<?php if($ship != $bill):?>
	<div class="span4">
<h3><?php echo lang('billing_information');?></h3>
		<?php echo format_address($bill, TRUE);?><br />
		<?php echo $bill['email'];?><br />
		<?php echo $bill['phone'];?>
	</div>
	<?php endif;?>
</div>
<?php endif;?>

<div class="row">
<div class="span4">
<h3><?php echo lang('additional_details');?></h3>
		<?php
		if (! empty ( $referral )) :
			?><div><strong><?php echo lang('heard_about');?></strong> <?php echo $referral;?></div><?php endif;?>
		<?php if(!empty($shipping_notes)):?><div><strong><?php echo lang('shipping_instructions');?></strong> <?php echo $shipping_notes;?></div><?php endif;?>
	</div>

<div class="span4">
<h3 style="padding-top: 10px;"><?php echo lang('shipping_method');?></h3>
		<?php echo $shipping['method']; ?>
	</div>

<div class="span4">
<h3><?php echo lang('payment_information');?></h3>
		<?php echo $payment['description']; ?>
	</div>
</div>

<?php if($go_cart['group_discount'] > 0) : ?>
<div class="row-fluid">
<div class="span12">
<div class="cn-summary-header"><?php echo sprintf (lang('group_discount_notice'), $go_cart['type_of_group_discount']); ?></div>
</div>
</div>
<?php endif; ?>

<table class="table table-bordered table-striped"
	style="margin-top: 20px; overflow: scroll;">
	<thead>
		<tr>
			<th style="width: 10%;"><?php echo lang('sku');?></th>
			<th style="width: 20%;"><?php echo lang('name');?></th>
			<th style="width: 10%;"><?php echo lang('price');?></th>
			<th><?php echo lang('description');?></th>
			<th style="width: 10%;"><?php echo lang('quantity');?></th>
			<th style="width: 8%;"><?php echo lang('totals');?></th>
		</tr>
	</thead>
	
<?php if($go_cart['tax_is_vat']) : ?>

	<?php
	/**************************************************************
	VAT
	 **************************************************************/
	?>	
	
	<tfoot>
		
		<?php
	/**************************************************************
		Subtotal NET
	 **************************************************************/
	?>
			
		<?php if($go_cart['total_items'] > 1) : ?>
			
			<?php if($go_cart['tax_vat'] > 0) : ?>
			
				<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_net');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['taxable_total_vat']); ?></td>
		</tr>
			
			<?php elseif($go_cart['coupon_discount'] > 0): ?>
			
				<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']); ?></td>
		</tr>
					
			<?php endif; ?>
				
		<?php endif; ?>
			
			
		<?php
	/**************************************************************
		VAT Taxes
	 **************************************************************/
	?>	
				
			<?php if($go_cart['tax_vat'] > 0) : ?>
				<tr>
			<td colspan="5"><strong><?php echo sprintf (lang('tax_vat_merchandise_only'), ($this->config->item('vat_tax_rate') * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['tax_vat']);?></td>
		</tr>
			<?php endif; ?>	
			
		<?php
	/**************************************************************
		Subtotal VAT
	 **************************************************************/
	?>
			
			<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_vat');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']); ?></td>
		</tr>
			
			
			<?php if(!$this->config->item('additional_tax_shipping')): ?>
			
				<?php if($go_cart['order_tax'] > 0) : ?>
				
				<?php
			/**************************************************************
				Additional Taxes Excluding Shipping
			 **************************************************************/
			?>	
				
			    <tr>
			<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_only'), ($go_cart['tax_rate_in_use'] * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['order_tax']);?></td>
		</tr>
				
				<?php
			/**************************************************************
				Subtotal TTC for Additional Taxes Excluding Shipping
			 **************************************************************/
			?>
				
			    <tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']+$go_cart['order_tax']); ?></td>
		</tr>
			
				<?php endif; ?>
		
			<?php endif; ?>	
		
		<?php
	/**************************************************************
		Shipping
	 **************************************************************/
	?>
			
			<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong> <?php echo sprintf (lang('shipping_vat'), ($this->config->item('vat_tax_rate') * 100).' %', format_currency( round($go_cart['shipping_cost'] - ($go_cart['shipping_cost'] / ($this->config->item('vat_tax_rate') + 1)), 2, PHP_ROUND_HALF_DOWN) ) );?></td>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['shipping_cost']); ?></td>
		</tr>
		
		<?php
	/**************************************************************
		Subtotal Shipping
	 **************************************************************/
	?>		
			
			<?php if($go_cart['coupon_discount'] > 0 || ($go_cart['order_tax'] > 0 && $this->config->item('additional_tax_shipping')) ) : ?>
			
				<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_shipping');?></strong></td>
					<?php if(!$this->config->item('additional_tax_shipping')): ?>
			    	<td style="text-align: right;"><?php echo format_currency($go_cart['total']+$go_cart['coupon_discount']+$go_cart['gift_card_discount']); ?></td>
			    	<?php else: ?>
			    	<td style="text-align: right;"><?php echo format_currency($go_cart['total']+$go_cart['coupon_discount']+$go_cart['gift_card_discount']-$go_cart['order_tax']); ?></td>
			    	<?php endif; ?>
				</tr>
				
			<?php endif; ?>
				
		<?php
	/**************************************************************
		Additional Taxes Including Shipping
	 **************************************************************/
	?>
			
			<?php if($this->config->item('additional_tax_shipping')): ?>
			
			    <?php if($go_cart['order_tax'] > 0) : ?>
				<tr>
					<?php if($this->config->item('additional_tax_applied_only_to_shipping')) : ?>
			    	<td colspan="5"><strong><?php echo sprintf (lang('tax_add_shipping_only'), ($go_cart['tax_rate_in_use'] * 100).' %');?></strong></td>
			    	<?php else: ?>
			    	<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_and_shipping'), ($go_cart['tax_rate_in_use'] * 100).' %');?></strong></td>
			    	<?php endif; ?>
			    	
					<td style="text-align: right;">+ <?php echo format_currency($go_cart['order_tax']);?></td>
		</tr>
				<?php endif; ?>
				
			<?php endif; ?>
		
		<?php
	/**************************************************************
		 Custom charges
	 **************************************************************/
	?>
			<?php $charges = $go_cart['custom_charges'];?>
			<?php if(!empty($charges)): ?>
			
			<?php foreach($charges as $name=>$price) : ?>
			<tr>
			<td colspan="5"><strong><?php echo $name?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($price); ?></td>
		</tr>	
			<?php endforeach;?>
			
			<?php endif; ?>
			
		<?php
	/**************************************************************
		Subtotal Additional Taxes
	 **************************************************************/
	?>		
				
			<?php if( $go_cart['coupon_discount'] > 0 && $go_cart['order_tax'] > 0 && $this->config->item('additional_tax_shipping') ) : ?>
			<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['total']+$go_cart['coupon_discount']+$go_cart['gift_card_discount']); ?></td>
		</tr>
			<?php endif; ?>
			
		<?php
	/**************************************************************
		Discount Calculations
	 **************************************************************/
	?>
			
			<?php if($go_cart['group_discount'] > 0):?>
			<!--
		    <tr>
		    	<?php if($go_cart['type_of_group_discount']):?>
		   		<td colspan="5"><strong><?php echo lang('group_discount');?></strong> <?php echo sprintf (lang('group_discount_notice'), $go_cart['type_of_group_discount']); ?></td>
				<?php else: ?>
		    	<td colspan="5"><strong><?php echo lang('group_discount');?></strong></td>
				<?php endif; ?>
		    	<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['group_discount']);?></td>
			</tr>
		  	-->
			<?php endif; ?>
		
			<?php if($go_cart['coupon_discount'] > 0):?>
		    <tr>
			<td colspan="5"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['coupon_discount']);?></td>
		</tr>
			<?php endif; ?>
		
			
		<?php
	/**************************************************************
		Gift Cards
	 **************************************************************/
	if ($go_cart ['gift_card_discount'] > 0) :
		?>
		<tr>
			<td colspan="5"><strong><?php echo lang('gift_card_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['gift_card_discount']); ?></td>
		</tr>
		<?php endif; ?>
						
			
		<?php
	/**************************************************************
		Grand Total
	 **************************************************************/
	?>
		<tr>
			<td colspan="5"><strong><?php echo lang('cart_total_ttc');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['total']); ?></td>
		</tr>

	</tfoot>

	<tbody>
	<?php
	
	$subtotal = 0;
	foreach ( $go_cart ['contents'] as $cartkey => $product ) {
		$subtotal += $product ['price'] * $product ['quantity'];
	}
	
	foreach ( $go_cart ['contents'] as $cartkey => $product ) :
		?>
		<?php
		
		if ($product ['name'] == 'Carte-cadeau') {
			if ($this->session->userdata ( 'language' ) == 'french') {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" />';
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard.jpg' ) . '" alt="Gift Card" />';
			}
		} elseif ($product ['name'] == 'Gift Card') {
			if ($this->session->userdata ( 'language' ) == 'french') {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" />';
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard.jpg' ) . '" alt="Gift Card" />';
			}
		} else {
			if (isset ( $product ['images'] )) {
				$images = (( array ) json_decode ( strval ( $product ['images'] ) ));
				$count = 0;
				foreach ( $images as $image ) {
					if ($count == 0) {
						$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . $product ['name'] . '"/>';
					}
					
					if (isset ( $image->primary ) && $image->primary == true) {
						$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . $product ['name'] . '"/>';
					}
					$count += 1;
				}
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'no_picture.png' ) . '" alt="' . lang ( 'no_image_available' ) . '"/>';
			}
		}
		?>
		
		<tr>
			<td><?php echo ($product['sku'] != '') ? '<br/><small>'.$product['sku'].'</small><br/>'.$photo : $photo;?></td>
			<td><?php echo $product['name']; ?></td>
			
			<?php if($go_cart['group_discount'] > 0):?>
			
				<?php if($product['quantity'] > 1) : ?>
				<td>
				<?php echo $product['quantity'] . ' x ' . format_currency($product['price']);?>
				<br />
			<small><?php echo $go_cart['type_of_group_discount'];?></small> <br />
			<br />
			<span style="border-top: 1px solid #eee; padding-top: 5px;"><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item_order_placed($customer['group_discount_formula'], $subtotal, $product['price'] * $product['quantity'], $go_cart['group_discount'], $go_cart['total_items']) );?></span>
			</td>
				<?php else: ?>
				<td><?php echo format_currency($product['price']);?>
				<br />
			<small><?php echo $go_cart['type_of_group_discount'];?></small> <br />
			<br />
			<span style="border-top: 1px solid #eee; padding-top: 5px;"><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item_order_placed($customer['group_discount_formula'], $subtotal, $product['price'], $go_cart['group_discount'], $go_cart['total_items']) );?></span>
			</td>
				<?php endif;?>
			
			<?php else: ?>
			
				<?php if($product['quantity'] > 1) : ?>
				<td><?php echo $product['quantity'] . ' x ' . format_currency($product['price']);?>
				<br />
			<br />
			<span style="border-top: 1px solid #eee; padding-top: 5px;"><?php echo format_currency( $product['price'] * $product['quantity'] );?></span>
			</td>
				<?php else: ?>
				<td><?php echo format_currency($product['price']);?></td>
				<?php endif;?>
			
			<?php endif; ?>
			
			<td><?php
		
echo $product ['excerpt'];
		if (isset ( $product ['options'] )) {
			foreach ( $product ['options'] as $name => $value ) {
				if (is_array ( $value )) {
					echo '<div><span class="gc_option_name">' . $name . ':</span><br/>';
					foreach ( $value as $item )
						echo '- ' . $item . '<br/>';
					echo '</div>';
				} else {
					echo '<div><span class="gc_option_name">' . $name . ':</span> ' . $value . '</div>';
				}
			}
		}
		?></td>
			<td><?php echo $product['quantity'];?></td>
			<?php if($go_cart['group_discount'] > 0):?>
			<td style="text-align: right;"><?php echo format_currency( round($this->go_cart->calculate_group_discount_for_item_order_placed($customer['group_discount_formula'], $subtotal, $product['price'] * $product['quantity'], $go_cart['group_discount'], $go_cart['total_items']) / ($this->config->item('vat_tax_rate') + 1), 2, PHP_ROUND_HALF_DOWN) ); ?>
				<br />
			<small><?php echo lang('price_net');?></small></td>
			<?php else: ?>
			<td><?php echo format_currency($product['price'] * $product['quantity']);?></td>
			<?php endif; ?>
		</tr>
		
	<?php endforeach; ?>
		
	</tbody>
	
<?php else: ?>

	<?php
	/**************************************************************
	Not VAT
	 **************************************************************/
	?>
	
	<tfoot>
	
		<?php
	/**************************************************************
		Subtotal Calculations
	 **************************************************************/
	?>
		
		<?php if($$go_cart['total_items'] > 1 && ($go_cart['coupon_discount'] > 0 || $go_cart['gift_card_discount'] > 0)) : ?>
		<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']); ?></td>
		</tr>
		<?php endif; ?>
		
		<?php if($go_cart['group_discount'] > 0)  : ?> 
	    <!--
		<tr>
			<td colspan="5"><strong><?php echo lang('group_discount');?></strong> <?php echo sprintf (lang('group_discount_notice'), $go_cart['type_of_group_discount']); ?></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['group_discount']);?></td>
		</tr>
		-->
		<?php endif; ?>
			
		<?php if($go_cart['coupon_discount'] > 0): ?>
	    <tr>
			<td colspan="5"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['coupon_discount']);?></td>
		</tr>
		<?php endif; ?>
		
		<?php if($go_cart['group_discount'] > 0 || $go_cart['coupon_discount'] > 0): ?> 
		<tr>
			<td colspan="5"><strong><?php echo lang('discounted_subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['discounted_subtotal']);?></td>
		</tr>
		<?php else: ?>
		<?php if($$go_cart['total_items'] > 1) : ?>
		<tr>
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']); ?></td>
		</tr>
		<?php endif; ?>
		<?php endif; ?>
		
		<?php
	/**************************************************************
		 Custom charges
	 **************************************************************/
	?>
		<?php
	$charges = $this->go_cart->get_custom_charges ();
	if (! empty ( $charges )) {
		foreach ( $charges as $name => $price ) :
			?>
				
		<tr>
			<td colspan="5"><strong><?php echo $name?></strong></td>
			<td>+ <?php echo format_currency($price); ?></td>
		</tr>	
				
		<?php
		
endforeach
		;
	}
	?>
		
		<?php
	/**************************************************************
		Order Taxes
	 **************************************************************/
	?>
		
		<?php /*Show shipping cost if added before taxes*/; ?>
		<?php if($this->config->item('tax_shipping') && $go_cart['shipping_cost']>0) : ?>
		
		<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['shipping_cost']); ?></td>
		</tr>
		
		<?php if($go_cart['order_tax'] > 0) : ?>
		<tr>
			<td colspan="5"><strong><?php echo lang('taxable_total');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['subtotal']-$go_cart['coupon_discount']+$go_cart['shipping_cost']); ?></td>
		</tr>
		<?php endif; ?>
		
		<?php endif; ?>
		
		
		<?php if($go_cart['order_tax'] > 0 && $go_cart['shipping_cost']>0) : ?>
	    <tr>
	    	<?php if(!$this->config->item('tax_shipping')) : ?>
			<td colspan="5"><?php echo sprintf (lang('tax_merchandise_only'), ($go_cart['tax_rate_in_use'] * 100).' %');?></td>
			<?php else: ?>
			<td colspan="5"><?php echo sprintf (lang('tax_merchandise_and_shipping'), ($go_cart['tax_rate_in_use'] * 100).' %');?></td>
			<?php endif; ?>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['order_tax']);?></td>
		</tr>
		<?php endif; ?>
		
		
		<?php /*Show shipping cost if added after taxes*/; ?>
		<?php if(!$this->config->item('tax_shipping') && $go_cart['shipping_cost']>0) : ?>
		<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($go_cart['shipping_cost']); ?></td>
		</tr>
		<?php endif; ?>
		
		<?php
	/**************************************************************
		Gift Cards
	 **************************************************************/
	if ($go_cart ['gift_card_discount'] > 0) :
		?>
		<tr>
			<td colspan="5"><strong><?php echo lang('gift_card_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($go_cart['gift_card_discount']); ?></td>
		</tr>
		<?php endif; ?>
		
		<?php
	/**************************************************************
		Grand Total
	 **************************************************************/
	?>
		<tr>
			<td colspan="5"><strong><?php echo lang('cart_total_ttc');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($go_cart['total']); ?></td>
		</tr>

	</tfoot>

	<tbody>
	<?php
	$subtotal = 0;
	
	foreach ( $go_cart ['contents'] as $cartkey => $product ) {
		$subtotal += $product ['price'] * $product ['quantity'];
	}
	
	foreach ( $go_cart ['contents'] as $cartkey => $product ) :
		?>
		<?php
		
		if ($product ['name'] == 'Carte-cadeau') {
			if ($this->session->userdata ( 'language' ) == 'french') {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" />';
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard.jpg' ) . '" alt="Gift Card" />';
			}
		} elseif ($product ['name'] == 'Gift Card') {
			if ($this->session->userdata ( 'language' ) == 'french') {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" />';
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'giftcard.jpg' ) . '" alt="Gift Card" />';
			}
		} else {
			if (isset ( $product ['images'] )) {
				$images = (( array ) json_decode ( strval ( $product ['images'] ) ));
				$count = 0;
				foreach ( $images as $image ) {
					if ($count == 0) {
						$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . $product ['name'] . '"/>';
					}
					
					if (isset ( $image->primary ) && $image->primary == true) {
						$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . $product ['name'] . '"/>';
					}
					$count += 1;
				}
			} else {
				$photo = '<img class="photo" src="' . theme_img ( 'no_picture.png' ) . '" alt="' . lang ( 'no_image_available' ) . '"/>';
			}
		}
		?>
		
		<tr>
			<td><?php echo ($product['sku'] != '') ? '<br/><small>'.$product['sku'].'</small><br/>'.$photo : $photo;?></td>
			<td><?php echo $product['name']; ?></td>
			<td><?php echo format_currency($product['base_price']);  ?></td>
			<td><?php
		
echo $product ['excerpt'];
		if (isset ( $product ['options'] )) {
			foreach ( $product ['options'] as $name => $value ) {
				if (is_array ( $value )) {
					echo '<div><span class="gc_option_name">' . $name . ':</span><br/>';
					foreach ( $value as $item )
						echo '- ' . $item . '<br/>';
					echo '</div>';
				} else {
					echo '<div><span class="gc_option_name">' . $name . ':</span> ' . $value . '</div>';
				}
			}
		}
		?></td>
			<td><?php echo $product['quantity'];?></td>
			<?php if($go_cart['group_discount'] > 0) : ?>
			<td style="text-align: right;">
				<?php echo format_currency( $product['price'] * $product['quantity'] ); ?>
				<br />
			<small><?php echo $go_cart['type_of_group_discount'];?></small> <br />
			<br />
				<?php echo format_currency( round($this->go_cart->calculate_group_discount_for_item_order_placed($customer['group_discount_formula'], $subtotal, $product['price'], $go_cart['group_discount'], $go_cart['total_items']), 2, PHP_ROUND_HALF_DOWN) ); ?>
			</td>
			<?php else: ?>
			<td style="text-align: right;">
				<?php echo format_currency( $product['price'] * $product['quantity'] );?>
			</td>
			<?php endif;?>
		</tr>
		
	<?php endforeach; ?>
	
	</tbody>
	
<?php endif; ?>

</table>

<?php if($this->go_cart->shipping_relay_point_info_html() != false):?>
<div>
<?php echo $this->go_cart->shipping_relay_point_info_html();?>
</div>
<?php endif;?>

<?php include('footer.php');