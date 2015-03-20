
<div class="span9">

<div class="page-header-cn-couettabra main-header"
	style="margin: 0; background: #6e6e6d; overflow: hidden;">

<h1 class="cn-box-logo-couettabra-category-product"><?php echo $page_title; ?><span
	class="registered-mark">&#174;</span></h1>

<blockquote
	style="text-align: center; border: none; padding: 0 10px 0; margin-right: 5px;">
<p><em style="color: #fff;">“<?php echo $excerpt; ?>”</em></p>
</blockquote>

</div>
	
	<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
		<br />
<div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>
			<?php echo lang('no_products');?>
		</div>
	<?php endif;?>
	
	<!--
	<div class="row">
		<div class="span12">
		    <blockquote style="text-align: center; border: none; padding: 0 0 25px; margin-right: 5px;">
		    	<p><em style="color: #6ab5cb;">“<?php echo $excerpt; ?>”</em></p>
		    </blockquote>
		</div>
	</div>
	--> <br class="mobile" />

<div class="row">
		
		<?php if(isset($subcategories) && count($subcategories) > 0): ?>
		<div class="span6 pull-left"><br class="desktop tablet-landscape" />

<div class="well cn-notice couettabra-2b" style="text-align: center;"><br
	class="tablet-portrait" />

<div>
					<?php echo lang('initial_couettabra_kit_notice_desktop');?>
				</div>
				
				<?php if($this->session->userdata('lang_scope') == 'fr'): ?>
				<br class="tablet-landscape" />
<br class="tablet-portrait" />
				<?php elseif($this->session->userdata('lang_scope') == 'en'): ?>
				<br class="tablet-landscape" />
				<?php endif;?>
				
				<div
	style="position: relative; padding-top: 15px; text-align: center;">
&#9660;</div>
</div>
</div>

<div class="span3 pull-right desktop"><br
	class="desktop tablet-landscape" />

<div class="well cn-notice couettabra-2b" style="text-align: center;">
			
				<?php if($this->session->userdata('lang_scope') == 'en'): ?>
				<br class="tablet-portrait" />
				<?php endif;?>
				
				<div style="font-size: 15px;"><?php echo lang('subsequent_couettabra_cover_notice');?>﻿</div>

<div style="position: relative; padding-top: 15px; text-align: center;">
&#9660;</div>
</div>
</div>
<div class="span6">
		
		<?php else:?>
		
		<div class="span12">
<div class="well cn-notice" style="text-align: justify;">
				<?php echo lang('initial_couettabra_kit_notice_mobile');?>
			</div>
</div>
<div class="span12">
		
		<?php endif;?>
			
			<?php if(count($products) > 0):?>
			
				<ul class="thumbnails">
				<?php foreach($products as $product):?>
					<li class="span3 product">
						<?php
					//$photo	= theme_img('no_picture.png', lang('no_image_available'));
					$photo = '<img class="responsiveImage" src="' . theme_img ( 'no_picture.png' ) . '" alt="' . lang ( 'no_image_available' ) . '"/>';
					$photo_bg = "background-image: url('" . theme_img ( 'no_picture.png' ) . "');";
					$product->images = array_values ( $product->images );
					
					if (! empty ( $product->images [0] )) {
						$primary = $product->images [0];
						foreach ( $product->images as $photo ) {
							if (isset ( $photo->primary )) {
								$primary = $photo;
							}
						}
						
						$photo = '<img class="responsiveImage" src="' . $this->config->item ( 'upload_url' ) . 'images/medium/' . $primary->filename . '" alt="' . $product->seo_title . '"/>';
						$photo_bg = "background-image: url('" . $this->config->item ( 'upload_url' ) . 'images/medium/' . $primary->filename . "');";
					}
					?>
						
						<?php
					$kit_type = '';
					if ($product->name == 'Kit "Couettabra" 2 places') {
						$kit_type = '<div style="text-align: center; padding: 0; margin: 0;">"Couettabra"<br />(Kit 2 places)</div>';
					} elseif ($product->name == 'Kit "Couettabra" 1 place') {
						$kit_type = '<div style="text-align: center; padding: 0; margin: 0;">"Couettabra"<br />(Kit 1 place)</div>';
					} elseif ($product->name == 'Double "Couettabra" Kit') {
						$kit_type = '<div style="text-align: center; padding: 0; margin: 0;">"Couettabra"<br />(Double kit)</div>';
					} elseif ($product->name == 'Single "Couettabra" Kit') {
						$kit_type = '<div style="text-align: center; padding: 0; margin: 0;">"Couettabra"<br />(Single kit)</div>';
					} else {
						$kit_type = $product->name;
					}
					?>
						<a class="thumbnail large" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" style="<?php echo $photo_bg;?>" itemscope itemtype="http://schema.org/ImageObject">
							<?php /*echo $photo;*/ ?>
							<?php if(!empty($product->images[0])):?>
							<link
		href="<?php echo $this->config->item('upload_url').'images/thumbnails/'.$primary->filename; ?>"
		itemprop="contentURL" />
	<meta itemprop="representativeOfPage" content="false" />
							<?php endif;?>
						</a>
	<h2 id="cn-product-couettabra-2b"
		<?php if($this->session->userdata('language') == 'english'):?>
		style="font-size: 20px;" <?php endif;?>><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $kit_type;?></a></h2>
						<?php if($product->excerpt != ''): ?>
						<div class="excerpt"><?php echo $product->excerpt; ?></div>
						<?php endif; ?>
						<div>
	<div class="product-price-holder">
								<?php if($product->saleprice > 0):?>
									<span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($product->price); ?></span>
	<span class="price-sale"><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span>
								<?php else: ?>
									<span class="price-reg"><?php echo lang('product_price');?> <?php echo format_currency($product->price); ?></span>
								<?php endif; ?>
							</div>
							
		                    <?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
								<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
							<?php } ?>
						</div>

	</li>
				<?php endforeach?>
				</ul>
			<?php endif;?>
		</div>
		
		<?php if(isset($subcategories) && count($subcategories) > 0): ?>
		<div class="span3">

<div class="well cn-notice couettabra-2b mobile"
	style="text-align: center;">
<div style="font-size: 15px;"><?php echo lang('subsequent_couettabra_cover_notice');?></div>
<div
	style="position: relative; height: 100%; width: 100%; padding-top: 15px; text-align: center;">
&#9660;</div>
</div>

<ul
	class="nav nav-list well cn-cat-list<?php echo ' '.$this->session->userdata('lang_scope'); ?>">
	<li class="nav-header cn-cat-list-header">
				<?php if(preg_match('/couettabra/', uri_string())):?>
				<?php echo lang('sub_category_couettabra_covers');?>
				<?php elseif(preg_match('/(housses|duvet-covers)/', uri_string())):?>
				<?php echo lang('sub_category_covers');?>
				<?php else:?>
				<?php echo lang('sub_category');?>
				<?php endif;?>
				<br />
	<br class="mobile" />
	<br class="only-desktop" />
	</li>
				<?php foreach($subcategories as $subcategory):?>
					<li class="cn-cat-list-item"><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>"><?php echo $subcategory->name;?></a></li>
				<?php endforeach;?>
			</ul>
</div>
		<?php endif;?>	
		
	</div>
	
	<?php if(!empty($category->description)): ?>
	<br />

<div class="row">
<div class="span9">
<div class="cn-category-description couettabra-2"><?php echo $category->description; ?></div>
</div>
</div>
	<?php endif; ?>

</div>

<script type="text/javascript">
	window.onload = function(){
		$('.product').equalHeights();
	}
</script>