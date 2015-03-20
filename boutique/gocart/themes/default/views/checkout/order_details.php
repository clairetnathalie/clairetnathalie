<div class="row">
<div class="span12">
<div class="row">
		<?php if(!empty($customer['ship_address'])):?>
			<div class="span3"><a
	href="<?php echo site_url('checkout/step_1');?>"
	class="btn btn-block btn-checkout cn-summary-btn"
	style="margin-bottom: 10px;">
				
					<?php
			
if ($customer ['ship_address'] != @$customer ['bill_address']) {
				echo lang ( 'shipping_address_button' );
			} else {
				echo lang ( 'shipping_address_button' );
			}
			?>
				</a>

<p>
					<?php echo format_address($customer['ship_address'], true);?>
				</p>
<p>
					<?php echo $customer['ship_address']['phone'];?><br />
					<?php echo $customer['ship_address']['email'];?>
				</p>

<br class="mobile" />
</div>
		<?php endif;?>
		
		<?php if(config_item('require_shipping')):?>
			<?php if($this->go_cart->requires_shipping()):?>
				<div class="span6">
<div class="row">
<div class="span3">
							<?php if($this->go_cart->shipping_relay_point_info_txt() != false && $this->router->fetch_class() == 'checkout' && ($this->router->fetch_method() == 'step_3' || $this->router->fetch_method() == 'step_4')):?>
							<a href="<?php echo site_url('checkout/billing_address');?>"
	class="btn btn-block btn-checkout cn-summary-btn"
	style="margin-bottom: 10px;"><?php echo lang('billing_address_button');?></a>
<p>
								<?php echo $customer['bill_address']['firstname'] . ' ' . $customer['bill_address']['lastname'];?><br />
								<?php echo (!empty($customer['company']))?$customer['company'].'<br/>':'';?>
								<?php echo $customer['bill_address']['phone'];?><br />
								<?php echo $customer['bill_address']['email'];?><br />
</p>
							<?php else:?>
							<a href="<?php echo site_url('checkout/billing_address');?>"
	class="btn btn-block btn-checkout cn-summary-btn"
	style="margin-bottom: 10px;"><?php echo lang('billing_address_button');?></a>
<p>
								<?php echo format_address($customer['bill_address'], true);?>
							</p>
<p>
								<?php echo $customer['bill_address']['phone'];?><br />
								<?php echo $customer['bill_address']['email'];?><br />
</p>
							<?php endif;?>
							
							<br class="mobile" />
</div>
					
						<?php
				if (! empty ( $shipping_method ) && ! empty ( $shipping_method ['method'] )) :
					?>
						<div class="span3">
<p><a href="<?php echo site_url('checkout/step_2');?>"
	class="btn btn-block btn-checkout cn-summary-btn"><?php echo lang('shipping_method_button');?></a></p>
<strong><?php echo lang('shipping_method');?></strong><br />
							<?php echo $shipping_method['method'].': '.format_currency($shipping_method['price']);?>
						</div>
						<?php endif;?>
						
						<br class="mobile" />
</div>
					<?php if($this->go_cart->shipping_relay_point_info_txt() != false && $this->router->fetch_class() == 'checkout' && ($this->router->fetch_method() == 'step_3' || $this->router->fetch_method() == 'step_4')):?>
					<div class="row">
<div class="span6">
<div class="row">
<div class="span3"><br>
<p style="text-align: center;"><a
	href="<?php echo site_url('checkout/step_2_point_relais');?>"
	class="btn btn-block btn-checkout cn-summary-btn"><?php echo lang('change_relay_point_btn');?></a>
</p>
</div>

<div class="span3">
<p class="shipping-relay-point-info">
										<?php echo $this->go_cart->shipping_relay_point_info_txt();?>
									</p>
</div>
</div>
</div>
<br class="mobile" />
</div>
					<?php endif;?>
				</div>
			<?php endif;?>
		<?php endif;?>
		
		<?php if(!empty($payment_method)  && $this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'step_4'):?>
			<div class="span3">
<p><a href="<?php echo site_url('checkout/step_3');?>"
	class="btn btn-block btn-checkout cn-summary-btn"><?php echo lang('billing_method_button');?></a></p>
				<?php echo $payment_method['description'];?>
			</div>
<br class="mobile" />
		<?php endif;?>
		</div>
</div>
</div>