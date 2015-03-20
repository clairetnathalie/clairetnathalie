<?php include('header.php'); ?>

<div class="page-header-cn-couettabra" style="margin: 0 0 30px;">

<h1><?php echo $page_title; ?></h1>

<!-- 
		 <blockquote style="text-align: center; border: none;">
	    	<p><em style="color: #fff;">“<?php echo $excerpt; ?>”</em></p>
	    </blockquote>
	    --></div>

<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
<br />
<div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>
			<?php echo lang('no_products');?>
		</div>
<?php endif;?>

<div class="row">
<div class="span12">
<blockquote
	style="text-align: center; border: none; padding: 0 0 25px; margin-right: 5px;">
<p><em style="color: #6ab5cb;">“<?php echo $excerpt; ?>”</em></p>
</blockquote>
</div>
</div>

<div class="row">
<div class="span8 pull-left">
<div class="well cn-notice" style="text-align: justify;">Pour une
première acquisition, le kit est nécessaire. Par la suite, on peut
acheter des housses seules.</div>
</div>
</div>

<div class="row">
		
		<?php if(isset($subcategories) && count($subcategories) > 0): ?>
		<div class="span8">
		<?php else:?>
		<div class="span12">
		<?php endif;?>
		
			<?php if(count($products) > 0):?>
			
				<ul class="thumbnails">
				<?php foreach($products as $product):?>
					<li class="span4 product">
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
						$housse_type = '<br />(2 places)';
					} elseif ($product->price == 99.00) {
						$housse_type = '<br />(1 place)';
					} else {
						$housse_type = '';
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
	<h5><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?><?php echo $housse_type;?></a></h5>
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
		<div class="span3 offset1">

<div class="well cn-notice" style="text-align: justify;">
<div style="font-size: 15px;">Vous possedez déjà votre couette
"Couettabra" et vous voulez changer de housse ?﻿</div>
</div>

<ul class="nav nav-list well">
	<li class="nav-header">
				<?php if(preg_match('/couettabra/', uri_string())):?>
				Les Housses "Couettabra"
				<?php elseif(preg_match('/housses/', uri_string())):?>
				Les Types de Housses
				<?php else:?>
				Sous-categories
				<?php endif;?>
				</li>
				
				<?php foreach($subcategories as $subcategory):?>
					<li><a
		href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>"><?php echo $subcategory->name;?></a></li>
				<?php endforeach;?>
			</ul>
</div>
		<?php endif;?>
		
	</div>
	
	<?php if(!empty($category->description)): ?>
	<div class="row">
<div class="span12">
<div class="cn-category-description couettabra-2"><?php echo $category->description; ?></div>
</div>
</div>
	<?php endif; ?>
	
	<?php if(count($products) > 0): ?>
		
		<?php include('social.php'); ?>
			
	<?php endif;?>

<script type="text/javascript">
	$script.ready(['jquery_local_0'], function() {
		window.onload = function(){
			$('.product').equalHeights();
		}
	});
</script>
<?php include('footer.php'); ?>