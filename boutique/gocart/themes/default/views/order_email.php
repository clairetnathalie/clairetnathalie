<!-- ### BEGIN CONTENT ### -->

<div>
<?php
/*
if($customer['company'] != '')
{
	echo '<div class="company_name">'.$customer['company'].'</div>';
}
echo $customer['firstname'].' '. $customer['lastname'].' | '.$customer['email'].' | '.$customer['phone'];
*/
?>
</div>

<br />

{download_section}

<table border="0" cellpadding="0" cellspacing="0"
	class="columns-container"
	style="table-layout: fixed; width: 100%; background: #6ab5cb; padding: 0; color: #fff;">
	<tr>
		<td
			style="width: 15px; height: 15px; background-color: #6ab5cb; padding: 0; margin: 0;"
			valign="top"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-top-left.png"
			style="width: 15px; height: 15px;" /></td>
		<td class="force-col" style="padding: 10px 0 10px 0; margin: 0;"
			valign="top">
		<table border="0" cellspacing="0" cellpadding="0" width="175"
			align="left" class="col-3">
			<tr>
				<td align="left" valign="top"
					style="font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">

				<strong style="background: #fff; color: #6ab5cb; padding: 0 5px;"><?php echo lang('billing_address');?></strong>
				<br />
				<br />
						<?php
						
$bill = $customer ['bill_address'];
						
						if (! empty ( $bill ['company'] ))
							echo $bill ['company'] . '<br/>';
						echo $bill ['firstname'] . ' ' . $bill ['lastname'] . ' ' . $bill ['email'] . '<br/>';
						echo $bill ['phone'] . '<br/>';
						?>
						<br />

				</td>
			</tr>
		</table>
		</td>
		<td class="force-col" style="padding: 10px 20px 10px 0; margin: 0;"
			valign="top"><!-- ### COLUMN 2 ### -->
		<table border="0" cellspacing="0" cellpadding="0" width="175"
			align="left" class="col-3">
			<tr>
				<td align="left" valign="top"
					style="font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong style="background: #fff; color: #6ab5cb; padding: 0 5px;"><?php echo lang('shipping_address');?></strong>
				<br />
				<br />
						<?php
						
$ship = $customer ['ship_address'];
						
						if (! empty ( $ship ['company'] ))
							echo $ship ['company'] . '<br/>';
						echo $ship ['firstname'] . ' ' . $ship ['lastname'] . ' ' . $ship ['email'] . '<br/>';
						echo $ship ['phone'] . '<br/>';
						echo $ship ['address1'] . '<br/>';
						if (! empty ( $ship ['address2'] ))
							echo $ship ['address2'] . '<br/>';
						echo $ship ['city'] . ', ' . $ship ['zone'] . ' ' . $ship ['zip'];
						?>
						<br />


				</td>
			</tr>
		</table>
		</td>
		<td class="force-col" style="padding: 10px 0 10px 0;" valign="top"><!-- ### COLUMN 3 ### -->
		<table border="0" cellspacing="0" cellpadding="0" width="175"
			align="right" class="col-3" id="last-col-3">
			<tr>
				<td align="left" valign="top"
					style="font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">

				<strong style="background: #fff; color: #6ab5cb; padding: 0 5px;"><?php echo lang('payment_method');?></strong>
				<br />
				<br />
						<?php echo $payment['description']; ?>
						<br />
				<br />

				</td>
			</tr>
		</table>
		</td>
		<td
			style="width: 15px; height: 15px; background-color: #6ab5cb; padding: 0; margin: 0;"
			valign="bottom"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-bottom-right.png"
			style="width: 15px; height: 15px; vertical-align: bottom;" /></td>
	</tr>
</table>
<!--/ end .columns-container-->

<br />

<table border="0" cellpadding="0" cellspacing="0"
	class="columns-container">
	<tr>
		<td
			style="width: 15px; height: 15px; background-color: #eee; padding: 0; margin: 0;"
			valign="top"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-top-left.png"
			style="width: 15px; height: 15px;" /></td>
		<td class="force-col" valign="top" style="width: 100%;">

		<?php
		$subtotal = 0;
		
		foreach ( $this->go_cart->contents () as $cartkey => $product ) {
			$subtotal += $product ['price'] * $product ['quantity'];
		}
		?>
		
		<?php foreach ($this->go_cart->contents() as $cartkey=>$product):?>
		
		<?php
			$image_style1 = 'border="0" hspace="0" vspace="0" style="width: 120px; height: 120px; float: left; vertical-align: top; padding: 0;" class="product-img"';
			$image_style2 = 'border="0" hspace="0" vspace="0" style="width: 120px; height: 75.7px; float: left; vertical-align: top; padding: 0;" class="product-img"';
			if ($product ['name'] == 'Carte-cadeau') {
				if ($this->session->userdata ( 'language' ) == 'french') {
					/*
					$path	= theme_img('giftcard_fr.jpg');
        			$type 	= pathinfo($path, PATHINFO_EXTENSION);
					$data 	= file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo	= '<img src="'.$base64.'" alt="Carte-cadeau" '.$image_style.'>';
					*/
					$photo = '<img src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" ' . $image_style2 . '>';
				} else {
					/*
					$path	= theme_img('giftcard.jpg');
        			$type 	= pathinfo($path, PATHINFO_EXTENSION);
					$data 	= file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo 	= '<img src="'.$base64.'" alt="Gift Card" '.$image_style.'>';
					*/
					$photo = '<img src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" ' . $image_style2 . '>';
				}
			} elseif ($product ['name'] == 'Gift Card') {
				if ($this->session->userdata ( 'language' ) == 'french') {
					/*
					$path	= theme_img('giftcard_fr.jpg');
        			$type 	= pathinfo($path, PATHINFO_EXTENSION);
					$data 	= file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo	= '<img src="'.$base64.'" alt="Carte-cadeau" '.$image_style.'>';
					*/
					$photo = '<img src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" ' . $image_style2 . '>';
				} else {
					/*
					$path	= theme_img('giftcard.jpg');
        			$type 	= pathinfo($path, PATHINFO_EXTENSION);
					$data 	= file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo 	= '<img src="'.$base64.'" alt="Gift Card" '.$image_style.'>';
					*/
					$photo = '<img src="' . theme_img ( 'giftcard_fr.jpg' ) . '" alt="Carte-cadeau" ' . $image_style2 . '>';
				}
			} else {
				if (isset ( $product ['images'] )) {
					$images = (( array ) json_decode ( strval ( $product ['images'] ) ));
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
					
					/*
					$path = $this->config->item('upload_server_path').'images/tiny/'.$file_name;
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$data = file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo = '<img src="'.$base64.'" alt="'.$product['name'].'" '.$image_style1.'>';
					*/
					
					//$photo	= '<img src="'.base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').'uploads/images/tiny/'.$file_name).'" alt="'.$product['name'].'" '.$image_style1.'>';
					

					$photo = '<img src="http://clairetnathalie.com/uploads/images/tiny/' . $file_name . '" alt="' . $product ['name'] . '" ' . $image_style1 . '>';
				
				} else {
					/*
					$path	= theme_img('no_picture.png');
        			$type 	= pathinfo($path, PATHINFO_EXTENSION);
					$data 	= file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$photo 	= '<img src="'.$base64.'" alt="'.lang('no_image_available').'" '.$image_style1.'>';
					*/
					
					$photo = '<img src="' . theme_img ( 'no_picture.png' ) . '" alt="' . lang ( 'no_image_available' ) . '" ' . $image_style1 . '>';
				}
			}
			?>
			

        <!-- ### COLUMN 1 ### -->
		<table border="0" cellspacing="0" cellpadding="0" width="100%"
			align="left" class="product-table"
			style="width: 100%; table-layout: inherit; background: #eee; padding: 0;">
			<tr>
				<td align="left" valign="middle"
					style="padding: 30px 0 10px 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">

				<div
					style="float: left; vertical-align: top; width: 170px; padding: 0 0 20px 0;">
						<?php echo $photo; ?>
					</div>

				<div style="float: right; vertical-align: top; width: 90px;">

				<table border="0" cellspacing="0" cellpadding="0" align="right">
					<tr>
						<td align="right" valign="top"><?php echo $product['quantity'];?>&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;<?php if($this->go_cart->group_discount() == 0 && $product['quantity'] == 1) : ?><strong><?php endif;?><?php echo format_currency($product['price']);?><?php if($this->go_cart->group_discount() == 0 && $product['quantity'] == 1) : ?></strong><?php endif;?></td>
					</tr>
				</table>
						
						<?php if($product['quantity'] > 1) : ?>
						<br>
				<table border="0" cellspacing="0" cellpadding="0" align="right">
					<tr>
						<td align="right" valign="top"><?php if($this->go_cart->group_discount() == 0 && $product['quantity'] > 1) : ?><strong><?php endif;?><?php echo format_currency( $product['price'] * $product['quantity'] );?><?php if($this->go_cart->group_discount() == 0 && $product['quantity'] > 1) : ?></strong><?php endif;?></td>
					</tr>
				</table>
						<?php endif;?>
						
						<?php if($this->go_cart->group_discount() > 0) : ?>
						<br>
				<table border="0" cellspacing="0" cellpadding="0" align="right">
					<tr>
						<td align="right" valign="top"><small><?php echo $this->go_cart->get_type_of_group_discount_formula();?></small></td>
					</tr>
					<tr>
						<td align="right" valign="top"><strong><?php echo format_currency( $this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) );?></strong></td>
					</tr>
				</table>
						<?php endif;?>
						
						<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>
						<br>
				<table border="0" cellspacing="0" cellpadding="0" align="right">
					<br>
					<br>
					<tr>
						<td align="right" valign="top"><small><?php echo lang('net_price');?> <?php echo format_currency( round($this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) / ($this->config->item('vat_tax_rate') + 1), 2, PHP_ROUND_HALF_DOWN) );?></small></td>
					</tr>
					<tr>
						<td align="right" valign="top"><small><?php echo lang('vat_price');?> <?php echo format_currency( $this->go_cart->calculate_group_discount_for_item($subtotal, $product['price'] * $product['quantity']) / ($this->config->item('vat_tax_rate') + 1) * $this->config->item('vat_tax_rate') );?></small></td>
					</tr>

				</table>
						<?php endif; ?>
						
					</div>

				<div
					style="float: left; vertical-align: top; width: 35%; min-width: 220px;">

				<a href="#" style="color: #2469A0; font-weight: bold;"><?php echo $product['name']; ?></a>

				<div class="product-description"
					style="padding: 0; overflow: hidden;"><?php echo $product['excerpt'];?></div>

				</div>
					
					<?php
			if (isset ( $product ['options'] )) {
				echo '<table cellspacing="0" cellpadding="0">';
				foreach ( $product ['options'] as $name => $value ) {
					echo '<tr class="cart_options">';
					if (is_array ( $value )) {
						echo '<td class="cart_option"><strong>' . $name . '&nbsp;&nbsp;:</strong></td><td class="cart_option">';
						foreach ( $value as $item ) {
							echo '<div>' . $item . '</div>';
						}
						echo '</td>';
					} else {
						echo '<td class="cart_option"><strong>' . $name . '&nbsp;&nbsp;:</strong></td><td class="cart_option" >&nbsp;&nbsp;' . $value . '</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
			}
			?>
					<br>
				</td>
			</tr>
		</table>
		
		<?php endforeach;?>
		
		</td>
		<td
			style="width: 15px; height: 15px; background-color: #eee; padding: 0; margin: 0;"
			valign="bottom"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-bottom-right.png"
			style="width: 15px; height: 15px; vertical-align: bottom;" /></td>
	</tr>
</table>
<!--/ end .columns-container-->

<br />

<table border="0" cellpadding="0" cellspacing="0"
	class="columns-container"
	style="width: 100%; table-layout: fixed; background: #e64d56; padding: 0;">
	<tr style="border-top: 1px solid #eee;">
		<td
			style="width: 15px; height: 15px; background-color: #e64d56; padding: 0; margin: 0;"
			valign="top"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-top-left.png"
			style="width: 15px; height: 15px;" /></td>
		<td style="padding: 10px 0 10px 0; width: 100%; color: #fff;"
			valign="top"><!-- ### COLUMN 2 ### -->
		<table border="0" cellspacing="0" cellpadding="0" width="100%"
			align="right" style="float: right; width: 100%;">

	    
<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>
		
<?php
	/**************************************************************
VAT Display
	 **************************************************************/
	?>

	        
        <?php
	/**************************************************************
		Subtotal NET
	 **************************************************************/
	?>
			
		<?php if($this->go_cart->total_items() > 1) : ?>
			
			<?php if($this->go_cart->order_tax_vat() > 0) : ?>
			
				<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_net');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
						<?php echo format_currency($this->go_cart->taxable_total_vat()); ?>
					</td>
			</tr>
			
			<?php elseif($this->go_cart->coupon_discount() > 0): ?>
			
				<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
						<?php echo format_currency($this->go_cart->subtotal()); ?>
					</td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_vat_merchandise_only'), ($this->config->item('vat_tax_rate') * 100).' %');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
			    		+ <?php echo format_currency($this->go_cart->order_tax_vat());?>
			    	</td>
			</tr>
				
			<?php endif; ?>	
			
		<?php
		/**************************************************************
		Subtotal VAT
		 **************************************************************/
		?>
			
				<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?> <small><?php echo lang('subtotal_with_tax_vat');?><small></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
						<?php echo format_currency($this->go_cart->subtotal()); ?>
					</td>
			</tr>
			
			<?php if(!$this->config->item('additional_tax_shipping')): ?>
			
				<?php if($this->go_cart->order_tax() > 0) : ?>
				
				<?php
				/**************************************************************
				Additional Taxes Excluding Shipping
				 **************************************************************/
				?>	
				
			    <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_merchandise_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				   		+ <?php echo format_currency($this->go_cart->order_tax());?>
				   	</td>
			</tr>
				
				<?php
				/**************************************************************
				Subtotal TTC for Additional Taxes Excluding Shipping
				 **************************************************************/
				?>
				
			    <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
						<?php echo format_currency($this->go_cart->subtotal()+$this->go_cart->order_tax()); ?>
					</td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('shipping');?> <small><?php echo sprintf (lang('shipping_vat'), ($this->config->item('vat_tax_rate') * 100).' %', format_currency( round($this->go_cart->shipping_cost() - ($this->go_cart->shipping_cost() / ($this->config->item('vat_tax_rate') + 1)), 2, PHP_ROUND_HALF_DOWN) ) );?></small></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
		        		+ <?php echo format_currency($this->go_cart->shipping_cost()); ?>
		        	</td>
			</tr>
				
			<?php endif; ?>
		
		<?php
	/**************************************************************
		Subtotal Shipping
	 **************************************************************/
	?>		
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?>
				
				<?php if( $this->go_cart->coupon_discount() > 0 || ($this->go_cart->order_tax() > 0 && $this->config->item('additional_tax_shipping')) ) : ?>
				<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_shipping');?></strong>
				</td>
					<?php if(!$this->config->item('additional_tax_shipping')): ?>
			    	<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
			    		<?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()); ?>
			    	</td>
			    	<?php else: ?>
			    	<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
			    		<?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()-$this->go_cart->order_tax()); ?>
			    	</td>
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
			    	<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_shipping_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
			    	<?php else: ?>
			    	<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_merchandise_and_shipping'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
			    	<?php endif; ?>
			    	
					<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
						+ <?php echo format_currency($this->go_cart->order_tax());?>
					</td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo $name?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					<?php echo format_currency($price); ?>
				</td>
			</tr>	
			<?php endforeach;?>
			
			<?php endif; ?>
			
		<?php
	/**************************************************************
		Subtotal Additional Taxes
	 **************************************************************/
	?>		
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?>
				
				<?php if( $this->go_cart->coupon_discount() > 0 && ($this->go_cart->order_tax() > 0 && $this->config->item('additional_tax_shipping')) ) : ?>
				<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?> <?php echo lang('subtotal_with_tax_add');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
			    		<?php echo format_currency($this->go_cart->total()+$this->go_cart->coupon_discount()+$this->go_cart->gift_card_discount()); ?>
			    	</td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('coupon_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					&#8722; <?php echo format_currency($this->go_cart->coupon_discount());?>
				</td>
			</tr>
			<?php endif; ?>
		
			
		<?php
	/**************************************************************
		Gift Cards
	 **************************************************************/
	?>
		
			<?php if($this->go_cart->gift_card_discount() > 0) : ?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('gift_card_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					&#8722; <?php echo format_currency($this->go_cart->gift_card_discount()); ?>
				</td>
			</tr>
			<?php endif; ?>
						
			
		<?php
	/**************************************************************
		Grand Total
	 **************************************************************/
	?>
		<tr>
			<?php if($this->go_cart->shipping_cost() > 0) : ?>
			<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('cart_total_ttc');?></strong></td>
			<?php else: ?>
		    <td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('grand_total');?></strong></td>
		    <?php endif; ?>
		    <td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
		    	<?php echo format_currency($this->go_cart->total()); ?>
		    </td>
			</tr>

			
<?php elseif($this->go_cart->get_is_tax_vat() && !$this->go_cart->get_display_tax_vat()) : ?>
		
<?php
	/**************************************************************
VAT Non Display
	 **************************************************************/
	?>

		<?php
	/**************************************************************
		Subtotal NET
	 **************************************************************/
	?>
		
			<?php if(!$this->config->item('additional_tax_shipping') && $this->go_cart->order_tax() > 0 && $this->go_cart->shipping_cost() > 0) : ?>
			
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('taxable_total');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
	                <?php echo format_currency($this->go_cart->subtotal()); ?>
	            </td>
			</tr>
	        
	        <?php else: ?>
			
			<?php if($this->go_cart->total_items() > 1 && ($this->go_cart->coupon_discount() > 0 || $this->go_cart->shipping_cost() > 0)) : ?><?php /* Because everything is summed up otherwise in the Grand Total */ ;?>
			
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
	                <?php echo format_currency($this->go_cart->subtotal()); ?>
	            </td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_merchandise_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					+ <?php echo format_currency($this->go_cart->order_tax());?>
				</td>
			</tr>
			
	    <?php
		/**************************************************************
		Subtotal TTC for Additional Taxes Excluding Shipping
		 **************************************************************/
		?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?><?php echo lang('subtotal_with_tax_add');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					<?php echo format_currency($this->go_cart->subtotal()+$this->go_cart->order_tax()); ?>
				</td>
			</tr>
			<?php endif; ?>
			
        <?php
	/**************************************************************
		Discount Calculations
	 **************************************************************/
	?>
			<?php if($this->go_cart->coupon_discount() > 0): ?>
		    <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('coupon_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					&#8722; <?php echo format_currency($this->go_cart->coupon_discount());?>
				</td>
			</tr>
			<?php endif; ?>
			
			<?php if($this->go_cart->shipping_cost() > 0) : ?> 
			
			<?php if($this->go_cart->group_discount() > 0 || $this->go_cart->coupon_discount() > 0): ?> 
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('discounted_subtotal');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
	    			<?php echo format_currency($this->go_cart->discounted_subtotal()+$this->go_cart->order_tax());?>
	    		</td>
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
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo $name?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					<?php echo format_currency($price); ?>
				</td>
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
			<?php if($this->config->item('additional_tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('shipping');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					+ <?php echo format_currency($this->go_cart->shipping_cost()); ?>
				</td>
			</tr>
			<?php if(!$this->config->item('additional_tax_applied_only_to_shipping') && $this->go_cart->order_tax() > 0) : ?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('taxable_total');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					<?php echo format_currency($this->go_cart->total()-$this->go_cart->order_tax()); ?>
				</td>
			</tr>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php if($this->go_cart->order_tax() > 0) : ?>
		    <tr>
		    	<?php if($this->config->item('additional_tax_shipping') && !$this->config->item('additional_tax_applied_only_to_shipping')) : ?>
				
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_merchandise_and_shipping'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					+ <?php echo format_currency($this->go_cart->order_tax());?>
				</td>
				
		    	<?php elseif($this->config->item('additional_tax_shipping') && $this->config->item('additional_tax_applied_only_to_shipping')) : ?>
				
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo sprintf (lang('tax_add_shipping_only'), ($this->go_cart->tax_rate_in_use() * 100).' %');?></strong>
				</td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					+ <?php echo format_currency($this->go_cart->order_tax());?>
				</td>
				
				<?php endif; ?>
			</tr>
			<?php endif; ?>
			
			<?php /*Show shipping cost if added after taxes*/; ?>
			<?php if(!$this->config->item('additional_tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('shipping');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					+ <?php echo format_currency($this->go_cart->shipping_cost()); ?>
				</td>
			</tr>
			<?php endif; ?>
			
		<?php
	/**************************************************************
		Gift Cards
	 **************************************************************/
	?>
			
			<?php if($this->go_cart->gift_card_discount() > 0) : ?>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('gift_card_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					&#8722; <?php echo format_currency($this->go_cart->gift_card_discount()); ?>
				</td>
			</tr>
			<?php endif; ?>
			
		<?php
	/**************************************************************
		Grand Total
	 **************************************************************/
	?>
			<tr>
				<?php if($this->go_cart->order_tax() > 0) : ?>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('cart_total_ttc');?></strong></td>
				<?php else: ?>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('grand_total');?></strong></td>
				<?php endif; ?>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
					<?php echo format_currency($this->go_cart->total()); ?>
				</td>
			</tr>
		
<?php else: ?>

<?php
	/**************************************************************
Not VAT
	 **************************************************************/
	?>	
            
            <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('subtotal');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                <?php echo format_currency($this->go_cart->subtotal()); ?>
            </td>
			</tr>
            
            
	        <?php if($this->go_cart->coupon_discount() > 0)  :?> 
	        
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('coupon_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                &#8722;&nbsp;<?php echo format_currency($this->go_cart->coupon_discount()); ?> 
            </td>
			</tr>
			<tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('discounted_subtotal');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                <?php echo format_currency($this->go_cart->discounted_subtotal(), 2, '.', ','); ?>
            </td>
			</tr>
	        
            <?php endif;?>
	        
	        
	       	<?php if(!$this->config->item('tax_shipping')) :?> 
	        <?php if($this->go_cart->order_tax() != 0) : ?> 
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('taxes');?></strong> <?php echo '('. $this->go_cart->tax_rate_in_use() * 100 .' %)'?>
            </td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                +&nbsp;<?php echo format_currency($this->go_cart->order_tax()); ?> 
            </td>
			</tr>
	        <?php endif;?>
			<?php endif;?>
			
            <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('shipping');?>:</strong> <?php echo $shipping['method']?>
            </td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                +&nbsp;<?php echo format_currency($shipping['price'])?>
            </td>
			</tr>
	        
	        <?php if($this->config->item('tax_shipping')) :?> 
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('taxable_total');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                <?php echo format_currency($this->go_cart->subtotal()-$this->go_cart->coupon_discount()+$this->go_cart->shipping_cost()); ?> 
            </td>
			</tr>
	        
	        <?php if($this->go_cart->order_tax() != 0) : ?> 
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('taxes');?></strong> <?php echo '('. $this->go_cart->tax_rate_in_use() * 100 .' %)'?>
            </td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                +&nbsp;<?php echo format_currency($this->go_cart->order_tax()); ?> 
            </td>
			</tr>
	        <?php endif;?>
			<?php endif;?>
	        
           	<?php if($this->go_cart->gift_card_discount() != 0) : ?> 
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('gift_card_discount');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                &#8722;&nbsp;<?php echo format_currency($this->go_cart->gift_card_discount()); ?> 
            </td>
			</tr>
	        <?php endif;?>
	        
	        <tr>
				<td align="left" valign="top"
					style="width: 77%; padding: 0 0 0 0; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
				<strong><?php echo lang('grand_total');?></strong></td>
				<td align="right" valign="top"
					style="width: 23%; padding: 0 0 0 20px; font-size: 13px; line-height: 20px; font-family: Arial, sans-serif;">
                <?php echo format_currency($this->go_cart->total()); ?>
            </td>
			</tr>
	        
        <?php endif;?>
        </table>

		</td>
		<td
			style="width: 15px; height: 15px; background-color: #e64d56; padding: 0; margin: 0;"
			valign="bottom"><img
			src="http://clairetnathalie.com/uploads/wysiwyg/email/cn_corner-email-bottom-right.png"
			style="width: 15px; height: 15px; vertical-align: bottom;" /></td>
	</tr>
</table>
<!--/ end .columns-container-->

<br />

<?php if($this->go_cart->shipping_relay_point_info_html() != false):?>
<p style="width: 100%;">
	<?php echo $this->go_cart->shipping_relay_point_info_html();?>
</p>

<br />
<?php endif;?>


		