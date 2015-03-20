<?php if($this->go_cart->group_discount() > 0) : ?>
<div class="row-fluid">
<div class="span12">
<div class="cn-summary-header"><?php echo sprintf (lang('group_discount_notice'), $this->go_cart->get_type_of_group_discount_formula()); ?></div>
</div>
</div>
<?php endif; ?>
<div class="row-fluid">
<table class="table span12 table-striped table-bordered" id="summary"
	style="overflow: scroll; border-top: none;">
	<thead>
	
	
	<thead>
		<tr>
			<th style="width: 10%;"><?php echo lang('sku');?></th>
			<th style="width: 20%;"><?php echo lang('name');?></th>
			<th style="width: 10%;"><?php echo lang('price');?></th>
			<th><?php echo lang('description');?></th>
			<th style="width: 8%;"><?php echo lang('quantity');?></th>
			<th style="width: 12%; text-align: right;"><?php echo lang('totals');?></th>
		</tr>
	</thead>
	</thead>

	<tfoot>

<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>

<?php
	/**************************************************************
VAT Display
	 **************************************************************/
	?>		
			<?php /*var_dump('VAT Display')*/ ;?>
					
			<?php
	/**************************************************************
			Subtotal NET
	 **************************************************************/
	?>
				
			<?php if($this->go_cart->total_items() > 1) : ?>
				
				<?php if($this->go_cart->order_tax_vat() > 0) : ?>
				
					<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_net');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->taxable_total_vat()); ?></td>
		</tr>
				
				<?php elseif($this->go_cart->coupon_discount() > 0): ?>
				
					<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
						
				<?php endif; ?>
					
			<?php endif; ?>
				
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?>
			
			<?php
		/**************************************************************
			VAT Taxes
		 **************************************************************/
		?>	
					
				<?php if($this->go_cart->order_tax_vat() > 0) : ?>
					
					<tr>
			<td colspan="5"><strong><?php echo sprintf (lang('tax_vat_merchandise_only'), ($this->config->item('vat_tax_rate') * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax_vat());?></td>
		</tr>
					
				<?php endif; ?>	
				
			<?php
		/**************************************************************
			Subtotal VAT
		 **************************************************************/
		?>
				
				<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_vat');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
				
				
				<?php if(!$this->config->item('additional_tax_shipping')): ?>
				
					<?php if($this->go_cart->order_tax() > 0) : ?>
					
					<?php
				/**************************************************************
					Additional Taxes Excluding Shipping
				 **************************************************************/
				?>	
					
				    <tr>
			<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
		</tr>
					
					<?php
				/**************************************************************
					Subtotal TTC for Additional Taxes Excluding Shipping
				 **************************************************************/
				?>
					
				    <tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()+$this->go_cart->order_tax()); ?></td>
		</tr>
				
					<?php endif; ?>
			
				<?php endif; ?>	
			
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Shipping
	 **************************************************************/
	?>
				
				<?php if($this->go_cart->shipping_cost() > 0) : ?>
				
				<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong> <?php echo sprintf (lang('shipping_vat'), ($this->config->item('vat_tax_rate') * 100).' %', format_currency( round($this->go_cart->shipping_cost() - ($this->go_cart->shipping_cost() / ($this->config->item('vat_tax_rate') + 1)), 2, PHP_ROUND_HALF_DOWN) ) );?></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->shipping_cost()); ?></td>
		</tr>
				
				<?php endif; ?>
			
			<?php
	/**************************************************************
			Subtotal Shipping
	 **************************************************************/
	?>		
				
				<?php if($this->go_cart->shipping_cost() > 0) : ?>
					
					<?php if( $this->go_cart->coupon_discount() > 0 || ($this->go_cart->order_tax() > 0 && $this->config->item('additional_tax_shipping')) ) : ?>
					<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_shipping');?></strong></td>
						<?php if(!$this->config->item('additional_tax_shipping')): ?>
				    	<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()); ?></td>
				    	<?php else: ?>
				    	<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()-$this->go_cart->order_tax()); ?></td>
				    	<?php endif; ?>
					</tr>
					<?php endif; ?>
					
				<?php endif; ?>
				
			<?php
	/**************************************************************
			Additional Taxes Including Shipping
	 **************************************************************/
	?>
			<?php if($this->go_cart->shipping_cost() > 0) : ?>
				
				<?php if($this->config->item('additional_tax_shipping')): ?>
				
				    <?php if($this->go_cart->order_tax() > 0) : ?>
					<tr>
						<?php if($this->config->item('additional_tax_applied_only_to_shipping')) : ?>
				    	<td colspan="5"><strong><?php echo sprintf (lang('tax_add_shipping_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
				    	<?php else: ?>
				    	<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_and_shipping'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
				    	<?php endif; ?>
				    	
						<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
		</tr>
					<?php endif; ?>
					
				<?php endif; ?>
			
			<?php endif; ?>	
			
			<?php
	/**************************************************************
			 Custom charges
	 **************************************************************/
	?>
				<?php $charges = $this->go_cart->get_custom_charges();?>
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
				
				<?php if($this->go_cart->shipping_cost() > 0) : ?>
					
					<?php if( $this->go_cart->coupon_discount() > 0 && $this->go_cart->order_tax() > 0 && $this->config->item('additional_tax_shipping') ) : ?>
					<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()); ?></td>
		</tr>
					<?php endif; ?>
					
				<?php endif; ?>
			
			<?php
	/**************************************************************
			Discount Calculations
	 **************************************************************/
	?>
				<?php if($this->go_cart->coupon_discount() > 0):?>
			    <tr>
			<td colspan="5"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td id="gc_coupon_discount-1" style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->coupon_discount());?></td>
		</tr>
				<?php endif; ?>
			
				
			<?php
	/**************************************************************
			Gift Cards
	 **************************************************************/
	if ($this->go_cart->gift_card_discount () > 0) :
		?>
			<tr>
			<td colspan="5"><strong><?php echo lang('gift_card_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->gift_card_discount()); ?></td>
		</tr>
			<?php endif; ?>
							
				
				
			<?php
	/**************************************************************
			Grand Total
	 **************************************************************/
	?>
			<tr class="summarize-row">
				<?php if($this->go_cart->shipping_cost() > 0) : ?>
				<td colspan="5"><strong><?php echo lang('cart_total_ttc');?></strong></td>
				<?php else: ?>
			    <td colspan="5"><strong><?php echo lang('grand_total');?></strong></td>
			    <?php endif; ?>
			    <td style="text-align: right;"><?php echo format_currency($this->go_cart->total()); ?></td>
		</tr>
				
<?php elseif($this->go_cart->get_is_tax_vat() && !$this->go_cart->get_display_tax_vat()) : ?>

<?php
	/**************************************************************
VAT Non Display
	 **************************************************************/
	?>	
			<?php /*var_dump('VAT Non Display')*/ ;?>
			
			<?php
	/**************************************************************
			Subtotal Calculations
	 **************************************************************/
	?>
			
			<?php if(!$this->config->item('additional_tax_shipping') && $this->go_cart->order_tax() > 0 && $this->go_cart->shipping_cost() > 0) : ?>
			
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('taxable_total');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
			
			<?php else: ?>
			
			<?php if($this->go_cart->total_items() > 1 && ($this->go_cart->coupon_discount() > 0 || $this->go_cart->shipping_cost() > 0)) : ?><?php /* Because everything is summed up otherwise in the Grand Total */ ;?>
			
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
			
			<?php endif; ?>
			
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Additional Taxes Excluding Shipping
	 **************************************************************/
	?>	
			<?php if(!$this->config->item('additional_tax_shipping') && $this->go_cart->order_tax() > 0 && $this->go_cart->shipping_cost() > 0) : ?>
			<tr>
			<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
		</tr>
			
		    <?php
		/**************************************************************
			Subtotal TTC for Additional Taxes Excluding Shipping
		 **************************************************************/
		?>
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?><?php echo lang('subtotal_with_tax_add');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()+$this->go_cart->order_tax()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Discount Calculations
	 **************************************************************/
	?>
			<?php if($this->go_cart->coupon_discount() > 0): ?>
		    <tr>
			<td colspan="5"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td id="gc_coupon_discount" style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->coupon_discount());?></td>
		</tr>
			<?php endif; ?>
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?> 
			
			<?php if($this->go_cart->order_tax() > 0 && $this->go_cart->coupon_discount() > 0): ?> 
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('discounted_subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($this->go_cart->discounted_subtotal()+$this->go_cart->order_tax());?></td>
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
			<td><?php echo format_currency($price); ?></td>
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
			<?php if($this->config->item('additional_tax_shipping') && $this->go_cart->shipping_cost() > 0) : ?>
			<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->shipping_cost()); ?></td>
		</tr>
			<?php if(!$this->config->item('additional_tax_applied_only_to_shipping') && $this->go_cart->order_tax() > 0) : ?>
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('taxable_total');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($this->go_cart->total()-$this->go_cart->order_tax()); ?></td>
		</tr>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php if($this->go_cart->order_tax() > 0) : ?>
		    <tr>
		    
		    	<?php if($this->config->item('additional_tax_shipping') && !$this->config->item('additional_tax_applied_only_to_shipping')) : ?>
				
				<td colspan="5"><strong><?php echo sprintf (lang('tax_add_merchandise_and_shipping'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
				
		    	<?php elseif($this->config->item('additional_tax_shipping') && $this->config->item('additional_tax_applied_only_to_shipping')) : ?>
				
				<td colspan="5"><strong><?php echo sprintf (lang('tax_add_shipping_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
				
				<?php endif; ?>
				
			</tr>
			<?php endif; ?>
			
			<?php /*Show shipping cost if added after taxes*/; ?>
			<?php if(!$this->config->item('additional_tax_shipping') && $this->go_cart->shipping_cost() > 0) : ?>
			<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->shipping_cost()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Gift Cards
	 **************************************************************/
	if ($this->go_cart->gift_card_discount () > 0) :
		?>
			<tr>
			<td colspan="5"><strong><?php echo lang('gift_card_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->gift_card_discount()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Grand Total
	 **************************************************************/
	?>
			<tr class="summarize-row">
				<?php if($this->go_cart->order_tax() > 0) : ?>
				<td colspan="5"><strong><?php echo lang('cart_total_ttc');?></strong></td>
				<?php else: ?>
				<td colspan="5"><strong><?php echo lang('grand_total');?></strong></td>
				<?php endif; ?>
				<td style="text-align: right;"><?php echo format_currency($this->go_cart->total()); ?></td>
		</tr>

<?php else: ?>

<?php
	/**************************************************************
Not VAT
	 **************************************************************/
	?>	
			<?php /*var_dump('Not VAT')*/ ;?>
			
			<?php
	/**************************************************************
			Subtotal Calculations
	 **************************************************************/
	?>
			
			<?php if($this->go_cart->total_items() > 1 && ($this->go_cart->coupon_discount() > 0 || $this->go_cart->gift_card_discount() > 0)) : ?>
			
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
			
			<?php endif; ?>
			
			<?php if($this->go_cart->group_discount() > 0)  : ?> 
        	<!--
        	<tr>
				<td colspan="5"><strong><?php echo lang('group_discount');?></strong></td>
				<td id="gc_group_discount" style="text-align: right;"><?php echo format_currency(0-$this->go_cart->group_discount()); ?></td>
			</tr>
			-->
			<?php endif; ?>
				
			<?php if($this->go_cart->coupon_discount() > 0): ?>
		    <tr>
			<td colspan="5"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td id="gc_coupon_discount" style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->coupon_discount());?></td>
		</tr>
			<?php endif; ?>
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?> 
			
			<?php if($this->go_cart->group_discount() > 0 || $this->go_cart->coupon_discount() > 0): ?> 
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('discounted_subtotal');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($this->go_cart->discounted_subtotal());?></td>
		</tr>
			<?php else: ?>
			<?php if($this->go_cart->total_items() > 1) : ?>
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('subtotal');?></strong></td>
			<td id="gc_subtotal_price" style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
		</tr>
			<?php endif; ?>
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
			<?php if($this->config->item('tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			
			<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->shipping_cost()); ?></td>
		</tr>
			
			<?php if($this->go_cart->order_tax() > 0) : ?>
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('taxable_total');?></strong></td>
			<td style="text-align: right;"><?php echo format_currency($this->go_cart->subtotal()-$this->go_cart->coupon_discount()+$this->go_cart->shipping_cost()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php endif; ?>
			
			
			<?php if($this->go_cart->order_tax() > 0 && $this->go_cart->shipping_cost()>0) : ?>
		    <tr>
		    	<?php if(!$this->config->item('tax_shipping')) : ?>
				<td colspan="5"><?php echo sprintf (lang('tax_merchandise_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></td>
				<?php else: ?>
				<td colspan="5"><?php echo sprintf (lang('tax_merchandise_and_shipping'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></td>
				<?php endif; ?>
				<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->order_tax());?></td>
		</tr>
			<?php endif; ?>
			
			
			<?php /*Show shipping cost if added after taxes*/; ?>
			<?php if(!$this->config->item('tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			<tr>
			<td colspan="5"><strong><?php echo lang('shipping');?></strong></td>
			<td style="text-align: right;">+ <?php echo format_currency($this->go_cart->shipping_cost()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Gift Cards
	 **************************************************************/
	if ($this->go_cart->gift_card_discount () > 0) :
		?>
			<tr>
			<td colspan="5"><strong><?php echo lang('gift_card_discount');?></strong></td>
			<td style="text-align: right;">&#8722; <?php echo format_currency($this->go_cart->gift_card_discount()); ?></td>
		</tr>
			<?php endif; ?>
			
			<?php
	/**************************************************************
			Grand Total
	 **************************************************************/
	?>
			<tr class="summarize-row">
			<td colspan="5"><strong><?php echo lang('grand_total');?></strong></td>
				
				<?php if($this->go_cart->shipping_cost() == 0) : ?>
				
				<?php if($this->go_cart->order_tax() > 0) : ?>
				<td style="text-align: right;"><?php echo format_currency($this->go_cart->total()-$this->go_cart->order_tax()); ?></td>
				<?php else: ?>
				<td style="text-align: right;"><?php echo format_currency($this->go_cart->total()); ?></td>
				<?php endif; ?>
				
				<?php else: ?>
				
				<td style="text-align: right;"><?php echo format_currency($this->go_cart->total()); ?></td>
				
				<?php endif; ?>
			</tr>
			
<?php endif; ?>
		
		</tfoot>

	<tbody>
			<?php
			$subtotal = 0;
			
			foreach ( $this->go_cart->contents () as $cartkey => $product ) {
				$subtotal += $product ['price'] * $product ['quantity'];
			}
			?>
			
			<?php
			
			foreach ( $this->go_cart->contents () as $cartkey => $product ) :
				?>
			
			<?php
				
				if ($product ['name'] == 'Carte-cadeau') {
					if ($this->config->item ( 'language' ) == 'french') {
						$photo = theme_img ( 'giftcard_fr.jpg', 'Carte-cadeau' );
					} else {
						$photo = theme_img ( 'giftcard.jpg', 'Gift Card' );
					}
				} elseif ($product ['name'] == 'Gift Card') {
					if ($this->config->item ( 'language' ) == 'french') {
						$photo = theme_img ( 'giftcard_fr.jpg', 'Carte-cadeau' );
					} else {
						$photo = theme_img ( 'giftcard.jpg', 'Gift Card' );
					}
				} else {
					$photo = theme_img ( 'no_picture.png', lang ( 'no_image_available' ) );
					$images = (( array ) json_decode ( strval ( $product ['images'] ) ));
					//print_r_html($images);
					$count = 0;
					foreach ( $images as $image ) {
						if ($count == 0 && isset ( $image->filename )) {
							$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . htmlspecialchars ( $product ['name'] ) . '"/>';
						}
						
						if (isset ( $image->primary ) && $image->primary == true) {
							$photo = '<img class="photo" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $image->filename . '" alt="' . htmlspecialchars ( $product ['name'] ) . '"/>';
						}
						
						$count += 1;
					}
				}
				?>
				
				<tr>
			<td><?php echo ($product['sku'] != '') ? '<br/><small>'.$product['sku'].'</small><br/>'.$photo : $photo;?></td>
			<td style="padding-top: 15px;"><?php echo $product['name']; ?></td>
					
					
				<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>
				
					<?php
					/**************************************************************
					VAT
					 **************************************************************/
					?>
					
					<?php if($this->go_cart->group_discount() > 0) : ?>
					
					<?php if($product['quantity'] > 1) : ?>
					<td
				style="text-align: right; margin-right: 5px; padding-top: 15px;"><?php echo $product['quantity'] . ' x ' . format_currency($product['price']);?>
					<br />
			<small><?php echo $this->go_cart->get_type_of_group_discount_formula();?></small>
			<br />
			<br />
			<span style="border-top: 1px solid #eee; padding-top: 5px;"><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) );?></span>
			</td>
					<?php else: ?>
					<td
				style="text-align: right; margin-right: 5px; padding-top: 15px;"><?php echo format_currency($product['price']);?>
					<br />
			<small><?php echo $this->go_cart->get_type_of_group_discount_formula();?></small>
			<br />
			<br />
			<span style="border-top: 1px solid #eee; padding-top: 5px;"><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item($subtotal, $product['price']) );?></span>
			</td>
					<?php endif;?>
					
					<?php else: ?>
					
					<?php if($product['quantity'] > 1) : ?>
					<td style="padding-top: 15px;"><?php echo $product['quantity'] . ' x ' . format_currency($product['price']);?>
					<br />
			<br />
			<span
				style="border-top: 1px solid #eee; text-align: right; margin-right: 5px; padding-top: 5px;"><?php echo format_currency( $product['price'] * $product['quantity'] );?></span>
			</td>
					<?php else: ?>
					<td style="padding-top: 15px;"><?php echo format_currency($product['price']);?></td>
					<?php endif;?>
					
					<?php endif;?>
					
				<?php else: ?>
					
					<?php
					/**************************************************************
					Non VAT
					 **************************************************************/
					?>
					
					<td style="padding-top: 15px;"><?php echo format_currency($product['price']);?></td>
					
				<?php endif;?>
					
					<td style="padding-top: 15px;">
						<?php
				
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
				?>
					</td>

			<td style="white-space: nowrap; padding-top: 15px;">
						<?php if($this->uri->segment(1) == 'cart'): ?>
							<?php if(!(bool)$product['fixed_quantity']):?>
								<?php echo $product['quantity']?>
								<input type="hidden" name="cartkey[<?php echo $cartkey;?>]"
				value="<?php echo $product['quantity'] ?>" />
			<button class="btn btn-danger"
				style="float: right; margin-top: -5px;" type="button"
				onclick="if(confirm('<?php echo lang('remove_item');?>')){window.location='<?php echo site_url('cart/remove_item/'.$cartkey);?>';}"><i
				class="icon-remove icon-white"></i></button>
							<?php else:?>
								<?php echo $product['quantity']?>
								<input type="hidden" name="cartkey[<?php echo $cartkey;?>]"
				value="1" />
			<button class="btn btn-danger"
				style="float: right; margin-top: -5px;" type="button"
				onclick="if(confirm('<?php echo lang('remove_item');?>')){window.location='<?php echo site_url('cart/remove_item/'.$cartkey);?>';}"><i
				class="icon-remove icon-white"></i></button>
							<?php endif;?>
						<?php else: ?>
							<?php echo $product['quantity']?>
						<?php endif;?>
					</td>
					
					
					<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>
					
						<?php if($product['taxable'] == 1) : ?>
							<?php if($this->go_cart->shipping_cost() > 0) : ?>
							<td style="text-align: right; padding-top: 15px;"><?php echo format_currency( round($this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) / ($this->config->item('vat_tax_rate') + 1), 2, PHP_ROUND_HALF_DOWN) ); ?>
								<br />
			<small><?php echo lang('price_net');?></small></td>
							<?php else: ?>
							<td style="text-align: right; padding-top: 15px;"><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) );?></td>
							<?php endif;?>
						<?php else: ?>
							<td style="text-align: right; padding-top: 15px;"><?php echo format_currency( $product['price'] * $product['quantity'] ); ?></td>
						<?php endif;?>
						
					<?php else: ?>
					
						<?php if($product['taxable'] == 1) : ?>
							<?php if($this->go_cart->group_discount() > 0) : ?>
							<td style="text-align: right; padding-top: 15px;">
								<?php echo format_currency( $product['price'] * $product['quantity'] ); ?>
								<br />
			<small><?php echo $this->go_cart->get_type_of_group_discount_formula();?></small>
			<br />
			<br />
								<?php echo format_currency( round($this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']), 2, PHP_ROUND_HALF_DOWN) ); ?>
							</td>
							<?php else: ?>
							<td style="text-align: right; padding-top: 15px;">
								<?php echo format_currency( $product['price'] * $product['quantity'] );?>
							</td>
							<?php endif;?>
						<?php else: ?>
							<td style="text-align: right; padding-top: 15px;"><?php echo format_currency( $product['price'] * $product['quantity'] ); ?></td>
						<?php endif;?>
						
					<?php endif;?>
					
				</tr>
			<?php endforeach;?>
		</tbody>
</table>
</div>