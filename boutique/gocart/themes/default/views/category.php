
<div class="span9">

	<?php
	$this_page_title = '';
	if (preg_match ( '/couettabra/', uri_string () )) {
		if (preg_match ( '/2-places/', uri_string () )) {
			$this_page_title = 'Housses 2 places';
			$this_page_title_logo_style_class = 'kit-2-places';
		} else if (preg_match ( '/1-place/', uri_string () )) {
			$this_page_title = 'Housses 1 place';
			$this_page_title_logo_style_class = 'kit-1-place';
		}
		
		$this_page_title_logo_bool = true;
		$this_page_title_logo_class = 'cn-box-logo-couettabra-category-products-housses';
		$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
	} else {
		$this_page_title = $page_title;
		$this_page_title_logo_bool = false;
		$this_page_title_logo_class = '';
		$box_bg_logo = "";
		$this_page_title_logo_style_class = '';
	}
	?>
	
	<?php if($this_page_title_logo_bool):?>
	<div class="page-header-cn-couettabra main-header"
	style="margin-top: 0; background: #6e6e6d; overflow: hidden;">
<h1 class="<?php echo $this_page_title_logo_style_class;?>">Couettabra<span
	class="registered-mark">&#174;</span> <?php echo $this_page_title; ?></h1>
</div>
	<?php else:?>
	<div class="page-header-cn-couettabra main-header middle"
	style="margin-top: 0; background: #6e6e6d; overflow: hidden;">
<h1><?php echo $this_page_title; ?></h1>
</div>
	<?php endif;?>
	
	<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
		<div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>
			<?php echo lang('no_products');?>
		</div>
	<?php endif;?>
	
	<div class="row"><br class="mobile" />

<div class="span6"><br class="desktop" />
				
		<?php if(!empty($base_url) && is_array($base_url)):?>
			<?php if(count($base_url) > 1):?>
				<ul class="breadcrumb" itemprop="breadcrumb">
				<?php
				$url_path = '';
				$count = 1;
				foreach ( $base_url as $bc ) :
					$url_path .= '/' . $bc;
					if ($count == count ( $base_url )) :
						?>
						<li class="active"><?php echo $bc;?></li>
					<?php else:?>
						<li><a href="<?php echo site_url($url_path);?>"><?php echo $bc;?></a></li>
	<span class="divider">/</span>
					
					<?php
endif;
					$count ++;
				endforeach
				;
				?>
 				</ul>
			<?php endif;?>
		<?php endif;?>
		</div>

<!-- 
		
		<br class="mobile" />
		
		<div class="span3">
		
			<br class="desktop" />
			
		<?php echo $this->pagination->create_links();?>
		
		</div>
		-->

<div class="span3"><br class="desktop" />

<select id="sort_products"
	onchange="window.location='<?php echo site_url(uri_string());?>/?'+$(this).val();"
	style="width: 100%; height: 34px; margin: 0;">
	<option value=''><?php echo lang('default');?></option>
	<option
		<?php echo(!empty($_GET['by']) && $_GET['by']=='name/asc')?' selected="selected"':'';?>
		value="by=name/asc"><?php echo lang('sort_by_name_asc');?></option>
	<option
		<?php echo(!empty($_GET['by']) && $_GET['by']=='name/desc')?' selected="selected"':'';?>
		value="by=name/desc"><?php echo lang('sort_by_name_desc');?></option>
	<option
		<?php echo(!empty($_GET['by']) && $_GET['by']=='price/asc')?' selected="selected"':'';?>
		value="by=price/asc"><?php echo lang('sort_by_price_asc');?></option>
	<option
		<?php echo(!empty($_GET['by']) && $_GET['by']=='price/desc')?' selected="selected"':'';?>
		value="by=price/desc"><?php echo lang('sort_by_price_desc');?></option>
</select> <br class="mobile" />

</div>

</div>

<br class="mobile" />

<div class="row">

<div class="span9">
		
			<?php if(count($products) > 0):?>
				
				<ul class="thumbnails">
				<?php if(isset($subcategories) && count($subcategories) > 0): ?>
					<li class="span3">
	<ul class="nav nav-list well cn-cat-list">
		<li class="nav-header cn-cat-list-header">
							<?php if(preg_match('/couettabra/', uri_string())):?>
							<?php echo lang('sub_category_couettabra_covers');?>
							<?php elseif(preg_match('/(housses|duvet-covers)/', uri_string())):?>
							<?php echo lang('sub_category_covers');?>
							<?php else:?>
							<?php echo lang('sub_category');?>
							<?php endif;?>
							</li>
		<br />
							<?php foreach($subcategories as $subcategory):?>
								<li class="cn-cat-list-item"><a
			href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>"><?php echo $subcategory->name;?></a></li>
							<?php endforeach;?>
						</ul>
	</li>
				<?php endif;?>
				
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
						
						$photo = '<img class="responsiveImage" src="' . $this->config->item ( 'upload_url' ) . 'images/thumbnails/' . $primary->filename . '" alt="' . $product->seo_title . '"/>';
						$photo_bg = "background-image: url('" . $this->config->item ( 'upload_url' ) . 'images/thumbnails/' . $primary->filename . "');";
					}
					?>
						
						<?php
					$housse_type = '';
					if ($product->price == 149.00) {
						$housse_type = '<br />' . lang ( 'kit_type_2_places' );
					} elseif ($product->price == 99.00) {
						$housse_type = '<br />' . lang ( 'kit_type_1_place' );
					} else {
						$housse_type = '';
					}
					?>
						<a class="thumbnail medium" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" style="<?php echo $photo_bg;?>" itemscope itemtype="http://schema.org/ImageObject">
							<?php /*echo $photo;*/ ?>
							<?php if(!empty($product->images[0])):?>
							<link
		href="<?php echo $this->config->item('upload_url').'images/thumbnails/'.$primary->filename; ?>"
		itemprop="contentURL" />
	<meta itemprop="representativeOfPage" content="false" />
							<?php endif;?>
						</a>
	<h2><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"
		<?php if($this->session->userdata('language') == 'english'):?>
		style="font-size: 16px;" <?php endif;?>><?php echo $product->name;?><?php echo $housse_type;?></a></h2>
						
						<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && preg_match('/Housse/i', $product->name)):?>
							<div class="excerpt">
								<?php if(!empty($primary->caption)):?>
								<small style="color: #6e6e6d;"><?php echo lang('cover_color');?><?php echo $primary->caption;?></small>
	<br />
								<?php endif;?>
							</div>
						<?php else:?>
							<?php if($product->excerpt != ''): ?>
							<div class="excerpt"><?php echo $product->excerpt; ?></div>
							<?php endif; ?>
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
						
						<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && preg_match('/Housse/i', $product->name)):?>
							<?php if($product->excerpt != ''): ?>
						<div>
	<div class="blurb"><em><?php echo $product->excerpt; ?></em></div>
	</div>
							<?php endif; ?>
						<?php endif; ?>
				
					</li>
				<?php endforeach?>
				</ul>
			<?php endif;?>
		</div>
</div>
	
	<?php if(!empty($category->description)): ?>
	<div class="row">
<div class="span12">
<div class="cn-category-description"><?php echo $category->description; ?></div>
</div>
</div>
	<?php endif; ?>

<script type="text/javascript">
	window.onload = function(){
		$('.product').equalHeights();
	}
</script></div>