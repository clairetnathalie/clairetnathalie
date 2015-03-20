<?php include('header.php'); ?>

<div class="skrollr-scrollspy-marker">

<div class="row-fluid" id="concept">

<div class="span12">

<div
	style="width: 300px; height: 100px; display: table; position: fixed; left: 50%; bottom: 6%; margin-left: -150px;"
	data-anchor-target="#concept" data-top="opacity:1; bottom: 6%;"
	data--5-top="opacity:0;" data--10-top="bottom: 100%;">
<div id="skrollr-notice"
	style="display: table-cell; margin: 0 auto; text-align: center; vertical-align: middle; height: 50px; font-size: 1.6em; line-height: 1.4em">
&#9650;<br /><?php echo lang('just_scroll_it'); ?><br />
&#9660;</div>
</div>

<div class="row-fluid">

<div class="span12 skrollr-header-section">

<div class="skrollr-text page-header" data-top="opacity:1;top:80px;"
	data--500-top="opacity:1;top:80px;" data--600-top="opacity:0;top:0px;">
<h1><?php echo $page_title; ?></h1>
</div>
						
						<?php if(!empty($category->description)): ?>
						<div class="page-description" data-top="opacity: 1;">
							<?php echo $category->description; ?>
						</div>
						<?php endif; ?>
						
						
						<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
						<div class="alert alert-info"><a class="close"
	data-dismiss="alert">×</a>
							<?php echo lang('no_products');?>
						</div>
						<?php endif;?>
					
					</div>

</div>

</div>

</div>

<div class="row" style="margin-bottom: 400px;">

<ul class="span12 skrollr-category-products list-unstyled">
			
				<?php if(count($products) > 0):?>
					
					<!--	
					<div class="pull-right" style="margin-top:20px;">
						<select id="sort_products" onchange="window.location='<?php echo site_url(uri_string());?>/?'+$(this).val();">
							<option value=''><?php echo lang('default');?></option>
							<option<?php echo(!empty($_GET['by']) && $_GET['by']=='name/asc')?' selected="selected"':'';?> value="by=name/asc"><?php echo lang('sort_by_name_asc');?></option>
							<option<?php echo(!empty($_GET['by']) && $_GET['by']=='name/desc')?' selected="selected"':'';?>  value="by=name/desc"><?php echo lang('sort_by_name_desc');?></option>
							<option<?php echo(!empty($_GET['by']) && $_GET['by']=='price/asc')?' selected="selected"':'';?>  value="by=price/asc"><?php echo lang('sort_by_price_asc');?></option>
							<option<?php echo(!empty($_GET['by']) && $_GET['by']=='price/desc')?' selected="selected"':'';?>  value="by=price/desc"><?php echo lang('sort_by_price_desc');?></option>
						</select>
					</div>
					<div style="float:left;"><?php echo $this->pagination->create_links();?></div>
					<br style="clear:both;"/>
					-->	
					
					<?php $product_count = 1;?>
					<?php $photo_bg = array(); ?>
					<?php foreach($products as $product):?>
					
					<div class="skrollr-category-product"
		id="skrollr-category-product-<?php echo $product_count;?>">

	<li class="product skrollr-item skrollr-category-product">
							<?php
						$photo = theme_img ( 'no_picture.png', lang ( 'no_image_available' ) );
						$product->images = array_values ( $product->images );
						
						if (! empty ( $product->images [0] )) {
							$primary = $product->images [0];
							foreach ( $product->images as $photo ) {
								if (isset ( $photo->primary )) {
									$primary = $photo;
								}
							}
							
							$photo = '<img src="' . $this->config->item ( 'upload_url' ) . 'images/thumbnails/' . $primary->filename . '" alt="' . $product->seo_title . '"/>';
							
							$bg_element = array ();
							
							if (preg_match ( '/(Kit "Couettabra" 2 places|Ensemble Duo)/i', $product->name )) {
								$bg_element ['front'] = 'background-image:url(' . $this->config->item ( 'upload_url' ) . 'images/full/test-images/kit-2-places_b.png);';
							} elseif (preg_match ( '/(Kit "Couettabra" 1 place|Ensemble Solo)/i', $product->name )) {
								$bg_element ['front'] = 'background-image:url(' . $this->config->item ( 'upload_url' ) . 'images/full/test-images/boy.png);';
							} else {
								$bg_element ['front'] = 'background-image:url(' . $this->config->item ( 'upload_url' ) . 'images/full/test-images/no-image.jpg);';
							}
							
							if (preg_match ( '/(Kit "Couettabra" 2 places|Ensemble Duo)/i', $product->name )) {
								$bg_element ['back-1'] = 'background-image:url(' . $this->config->item ( 'upload_url' ) . 'images/full/test-images/kit-2-places_bg.png);';
								$bg_element ['back-2'] = null;
								$bg_element ['back-3'] = null;
								$bg_element ['back-4'] = null;
							
							} elseif (preg_match ( '/(Kit "Couettabra" 1 place|Ensemble Solo)/i', $product->name )) {
								$bg_element ['back-1'] = 'background: rgba(197, 66, 49, 1);';
								$bg_element ['back-2'] = null;
								$bg_element ['back-3'] = null;
								$bg_element ['back-4'] = null;
							} else {
								$bg_element ['back'] = 'background-image:url(' . $this->config->item ( 'upload_url' ) . 'images/full/test-images/no-image.jpg);';
							}
							
							$photo_bg [$product->name] = $bg_element;
						}
						?>
							
							<?php if(preg_match('/(Kit "Couettabra" 2 places|Ensemble Duo)/i', $product->name)):?>
							
								<div class="centered">

	<div
		id="product-info-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"
		class="category-product-info">

	<div
		id="category-product-section-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"
		data-anchor-target="#skrollr-category-product-<?php echo $product_count;?>">

	<div class="product-title"><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>">
	<p class="category-product-style-kit-2-places top wrapword"><?php echo $product->name;?></p>
	<p class="category-product-style-kit-2-places bottom wrapword wipe"><?php echo $product->name;?></p>
	</a></div>

	<div class="well well-small"
		style="margin-left: auto; margin-right: auto; text-align: center; max-width: 200px;">
	<a class="btn btn-large btn-primary" style="margin-top: 5px;"
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo lang('inspect_this_product');?></a>
	<div class="category-product-price" style="margin-bottom: -10px;">
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

	</div>

	</div>

	</div>
								
							<?php elseif(preg_match('/(Kit "Couettabra" 1 place|Ensemble Solo)/i', $product->name)):?>
							
								<div class="centered">

	<div
		id="product-info-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"
		class="category-product-info">

	<div
		id="category-product-section-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"
		data-anchor-target="#skrollr-category-product-<?php echo $product_count;?>">

	<div class="product-title"><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>">
	<p class="category-product-style-kit-1-place top wrapword"><?php echo $product->name;?></p>
	<p class="category-product-style-kit-1-place bottom wrapword wipe"><?php echo $product->name;?></p>
	</a></div>

	<div class="well well-small"
		style="margin-left: auto; margin-right: auto; text-align: center; max-width: 200px;">
	<a class="btn btn-large btn-primary" style="margin-top: 5px;"
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo lang('inspect_this_product');?></a>
	<div class="category-product-price" style="margin-bottom: -10px;">
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

	</div>

	</div>

	</div>
									
							<?php else:?>
								
								<div class="centered">

	<div
		id="product-info-<?php echo strtolower(preg_replace('/ /', '-', $product->name));?>"
		class="category-product-info"><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>">
											<?php echo $photo;?>
										</a>

	<h5 style="margin-top: 5px;"
		id="category-product-title-<?php echo $product_count;?>"><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5>
										
										<?php if($product->excerpt != ''): ?>
										<div class="excerpt"><?php echo $product->excerpt; ?></div>
										<?php endif; ?>
										<div>
	<div>
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

	</div>

	</div>
								
							<?php endif; ?>
							
						</li>
	</div>	
					<?php $product_count += 1;?>
					<?php endforeach?>
					<?php /*print_r_html($photo_bg);*/ ?>
				<?php endif;?>
			</ul>
</div>
		
		<?php if(isset($subcategories) && count($subcategories) > 0): ?>
		<div id="product-info-housses"><!-- 
			<div class="span3">&nbsp;</div>
			
			<div class="span6">
				<ul id="category-subcategories-list" class="nav nav-list" style="text-align:center;">
					<li class="nav-header well" style="font-size: 1.4em;line-height:1.4em;letter-spacing: 0.08em;">
					<?php echo ucwords(strtolower(lang('subcategories_housses'))); ?>
					</li>
					
					<?php foreach($subcategories as $subcategory):?>
						<li><a href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>"><?php echo $subcategory->name;?></a></li>
					<?php endforeach;?>
				</ul>
			</div>
			
			<div class="span3">&nbsp;</div>
			-->


<div id="subcategories-carousel" class="carousel slide">

<ul class="nav nav-list"
	style="text-align: center; padding-top: 20px; padding-bottom: 0px;">
	<li id="subcategories-carousel-header">
						<?php echo lang('subcategories_housses'); ?>
						</li>
</ul>

<!-- Carousel items -->
<div class="carousel-inner">
						<?php $active_banner = 'active ';?>
						
						<?php foreach($subcategories as $subcategory):?>
							<?php $subcategory_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$subcategory->image.')';?>
							<div id="subcategory-carousel-element" class="<?php echo $active_banner;?>item" style="<?php echo $subcategory_image;?>">
<a
	href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>">
<div><span><?php echo $subcategory->name;?></span></div>
</a></div>
						<?php $active_banner = false;?>
						<?php endforeach;?>
					</div>
<!-- Carousel nav --> <a class="carousel-control left"
	href="#subcategories-carousel" data-slide="prev"
	style="margin-top: 108px; z-index: 3;">&lsaquo;</a> <a
	class="carousel-control right" href="#subcategories-carousel"
	data-slide="next" style="margin-top: 108px; z-index: 3;">&rsaquo;</a></div>

</div>
		<?php endif;?>
		
		<?php if(count($products) > 0): ?>
		
			<?php include('social.php'); ?>
			
		<?php endif;?>
	
	</div>

<script type="text/javascript">
	$script.ready(['jquery_local_0'], function() {
		window.onload = function(){
			$('.product').equalHeights();
		}
	});
</script>
<?php include('footer.php'); ?>