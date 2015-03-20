
<div class="span9">
			
			<?php $logo_panier = "background-image: url('".theme_img('icons/cn_picto-panier_white_200x200px.png')."')"?>
			<div class="row-fluid">
<div class="span12">
<div class="page-header-cn-couettabra main-header middle" style="margin: 0 0 30px; background: #6e6e6d; <?php echo $logo_panier;?>; background-repeat: no-repeat; background-position: 20px center; -webkit-background-size: auto 50px;">
<h1><?php echo lang('your_cart');?></h1>
</div>
</div>
</div>
			
<?php if ($this->go_cart->total_items()==0):?>
			<div class="row-fluid">
<div class="span12">
<div class="alert alert-info cn-alert-panier"><a class="close"
	data-dismiss="alert">×</a>
						<?php echo lang('empty_view_cart');?>
					</div>
</div>
</div>
<?php else: ?>
		
		<?php echo form_open('cart/update_cart', array('id'=>'update_cart_form'));?>
				
			<?php include('checkout/summary.php');?>
			
			<div class="row-fluid">
<div class="span12">
<div class="row-fluid">
<div class="desktop">
<div class="span4"><a href="<?php echo base_url();?>" class="btn span4"
	style="width: 100%; min-height: 31px; margin: 0; padding-left: 0; padding-right: 0;"><?php echo lang('continue_shopping');?></a>
</div>
<div class="span4">&nbsp;</div>
</div>
<div class="span4">
							<?php if ($this->Customer_model->is_logged_in(false,false) || !$this->config->item('require_login')): ?>
								<input class="btn btn-primary"
	style="width: 100%; min-height: 31px; margin: 0 0 10px 0;"
	type="submit" onclick="$('#redirect_path').val('checkout');"
	value="<?php echo lang('form_checkout');?>" />
							<?php endif; ?>
						</div>
</div>
</div>
</div>

<div class="row-fluid">
<div class="span12"><input id="redirect_path" type="hidden"
	name="redirect" value="" />
<div class="row-fluid">
				<?php if(!$this->Customer_model->is_logged_in(false,false)): ?>
						<div class="span4"><input class="btn" type="submit"
	onclick="$('#redirect_path').val('checkout/login');"
	value="<?php echo lang('login');?>"
	style="width: 100%; min-height: 31px; margin: 0 0 10px 0;" /></div>
<div class="span4"><input class="btn" type="submit"
	onclick="$('#redirect_path').val('checkout/register');"
	value="<?php echo lang('register_now');?>"
	style="width: 100%; min-height: 31px; margin: 0 0 10px 0;" /></div>
				<?php endif; ?>
						<div class="span4"><input class="btn" type="submit"
	value="<?php echo lang('form_update_cart');?>"
	style="width: 100%; min-height: 31px; margin: 0 0 10px 0;" /></div>
</div>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<div class="mobile"><a href="<?php echo base_url();?>" class="btn span4"
	style="width: 100%; min-height: 31px; margin: 0 0 10px 0;"><?php echo lang('continue_shopping');?></a>
</div>
</div>
</div>

<div class="row-fluid">
<div class="span12 pull-left"
	style="text-align: left; padding: 15px 0 7.5px 0;">
<p id="promo_join_app_fb" style="font-size: 13px; letter-spacing: 1px;"></p>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6">
<div class="row-fluid">
<div class="span12" style="text-align: left;"><label><?php echo lang('coupon_label');?></label>
</div>
</div>
<div class="row-fluid">
<div class="span4"><input type="text" name="coupon_code"
	style="width: 99%;"></div>
<div class="span8"><input class="btn" type="submit"
	value="<?php echo lang('apply_coupon');?>"
	style="width: 100%; min-height: 31px;" /></div>
</div>
</div>

<br class="mobile" />
						
						<?php if($gift_cards_enabled):?>
						<div class="span6">
<div class="row-fluid">
<div class="span12" style="text-align: left;"><label><?php echo lang('gift_card_label');?></label>
</div>
</div>
<div class="row-fluid">
<div class="span4"><input type="text" name="gc_code" style="width: 99%;">
</div>
<div class="span8"><input class="btn" type="submit"
	value="<?php echo lang('apply_gift_card');?>"
	style="width: 100%; min-height: 31px;" /></div>
</div>
</div>
						<?php endif;?>
					</div>
</div>
</div>

</form>
			
<?php endif; ?>

</div>