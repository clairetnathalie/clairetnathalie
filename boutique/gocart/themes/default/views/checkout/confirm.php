<div class="page-header-cn-couettabra" style="margin: 0 0 30px;">
<h2><?php echo lang('form_checkout_procedure');?></h2>
</div>

<?php include('order_details.php');?>
<?php include('summary.php');?>

<div class="row">
<div class="span12"><a class="btn btn-primary btn-large btn-block"
	href="<?php echo site_url('checkout/place_order');?>"><?php echo lang('submit_order');?></a>
		
		<?php if($this->go_cart->get_is_tax_vat() && !$this->go_cart->get_display_tax_vat()) : ?>
		<a class="btn btn-large btn-block" id="change_vat_tax_display_btn"
	href="<?php echo site_url('checkout/show_vat_tax_display');?>"><?php echo lang('btn_show_vat_tax_display');?></a>
		<?php endif;?>
		
		<?php if($this->go_cart->get_is_tax_vat() && $this->go_cart->get_display_tax_vat()) : ?>
		<a class="btn btn-large btn-block" id="change_vat_tax_display_btn"
	href="<?php echo site_url('checkout/hide_vat_tax_display');?>"><?php echo lang('btn_hide_vat_tax_display');?></a>
		<?php endif;?>
	</div>
</div>
