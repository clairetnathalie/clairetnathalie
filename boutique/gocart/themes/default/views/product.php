<?php /*print_r_html($options);*/ ?>

<?php
$kit_type_sup = '';
$product_contents = '';

if ($product->price == "249.00" || $product->price == "169.00") {
	$kit_type_sup = lang ( 'kit_type_sup_2_places' );
	$product_contents = lang ( 'product_contents_kit_2' );
	$gamme = 'Couettabra';
} elseif ($product->price == "149.00") {
	$kit_type_sup = lang ( 'kit_type_sup_1_place' );
	$product_contents = lang ( 'product_contents_kit_1' );
	$gamme = 'Couettabra';
} else {
	$kit_type_sup = '';
}

$kit_type_redirect = '';
if ($product->price == "129.00" || $product->price == "99.00") {
	$kit_type_redirect = base_url () . 'couettabra/ensemble-duo';
	$gamme = 'Couettabra';
} elseif ($product->price == "79.00") {
	$kit_type_redirect = base_url () . 'couettabra/ensemble-solo';
	$gamme = 'Couettabra';
} else {
	$kit_type_redirect = '';
}
?>

<?php
if ($this->session->userdata ( 'language' ) == 'english') {
	$fin_de_collection_image = 'thumbnail_fin_de_collection3.png';
} else {
	$fin_de_collection_image = 'thumbnail_fin_de_collection2.png';
}
?>

<div class="span9"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:gr="http://purl.org/goodrelations/v1#"
	xmlns:vcard="http://www.w3.org/2006/vcard/ns#"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#">

<div class="row" style="height: auto;" itemprop="mainContentOfPage"
	content="true">

<div class="span12">

<div class="row">

<div class="span9">
			
					<?php
					$this_page_title = '';
					if ($page_title == 'Kit "Couettabra" 2 places' || $page_title == 'Ensemble Duo') {
						if ($page_title == 'Kit "Couettabra" 2 places') {
							$this_page_title = '2 places';
						} else if ($page_title == 'Ensemble Duo') {
							$this_page_title = 'Ensemble Duo';
						}
						$this_page_title_logo_bool = true;
						$this_page_title_logo_class = 'cn-box-logo-couettabra-product';
						$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
						$this_page_title_logo_style_class = 'kit-2-places';
					} elseif ($page_title == 'Kit "Couettabra" 1 place' || $page_title == 'Ensemble Solo') {
						if ($page_title == 'Kit "Couettabra" 1 place') {
							$this_page_title = '1 place';
						} else if ($page_title == 'Ensemble Solo') {
							$this_page_title = 'Ensemble Solo';
						}
						$this_page_title_logo_bool = true;
						$this_page_title_logo_class = 'cn-box-logo-couettabra-product';
						$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
						$this_page_title_logo_style_class = 'kit-1-place';
					} elseif ($page_title == 'Double "Couettabra" Kit' || $page_title == 'Twin Set') {
						$this_page_title = 'twin set';
						$this_page_title_logo_bool = true;
						$this_page_title_logo_class = 'cn-box-logo-couettabra-product';
						$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
						$this_page_title_logo_style_class = 'kit-2-places';
					} elseif ($page_title == 'Single "Couettabra" Kit' || $page_title == 'Single Set') {
						$this_page_title = 'single set';
						$this_page_title_logo_bool = true;
						$this_page_title_logo_class = 'cn-box-logo-couettabra-product';
						$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
						$this_page_title_logo_style_class = 'kit-1-place';
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
				
				</div>

</div>

<div class="row">

<div class="span5 primary-img-row"><br />

<div class="row primary-img-holder">

<div class="span5" id="primary-img" itemprop="primaryImageOfPage"
	itemscope itemtype="http://schema.org/ImageObject">
							<?php
							//$photo	= theme_img('no_picture.png', lang('no_image_available'));
							$photo = '<img class="responsiveImage" src="' . theme_img ( 'no_picture.png' ) . '" alt="' . lang ( 'no_image_available' ) . '"/>';
							$product->images = array_values ( $product->images );
							
							if (! empty ( $product->images [0] )) {
								$primary = $product->images [0];
								foreach ( $product->images as $photo ) {
									if (isset ( $photo->primary )) {
										$primary = $photo;
									}
								}
								
								$photo = '<img class="responsiveImage" src="' . $this->config->item ( 'upload_url' ) . 'images/full/' . $primary->filename . '" alt="' . $product->seo_title . '"/>';
							}
							echo $photo?>
							<?php if(!empty($product->images[0])):?>
							<link
	href="<?php echo $this->config->item('upload_url').'images/medium/'.$primary->filename; ?>"
	itemprop="contentURL" />
<meta itemprop="representativeOfPage" content="true" />
							<?php endif;?>
						</div>
</div>
					
					<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && !preg_match('/Housse/i', $product->name)):?>
						<?php if(!empty($primary->caption)):?>
					<div class="row">
<div class="span5" id="product_caption">
							<?php echo $primary->caption;?>
						</div>
</div>
						<?php endif;?>
					<?php endif;?>
					
					<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/Housse/i', $product->name)):?>
						<?php if(count($product->images) > 2):?>
					<div class="row"><br />

<div class="span5 product-images">
							<?php foreach($product->images as $image):?>
							<?php /*var_dump($image);*/ ?>
							<?php if($image->alt != 'thumbnail'):?>
							<div class="span1 product-additional-images" style="float: left; background-image: url('<?php echo $this->config->item('upload_url').'images/medium/'.$image->filename;?>');">
<img
	src="<?php echo $this->config->item('upload_url').'images/full/'.$image->filename;?>"
	style="width: 100%; height: auto; opacity: 0;" /></div>
							<?php endif;?>
							<?php endforeach;?>
						
						</div>

</div>
						<?php endif;?>
					<?php else:?>
						<?php if(count($product->images) > 1):?>
					<div class="row product-images-holder"><br />

<div class="span5 product-images">
							<?php foreach($product->images as $image):?>
							<?php /*var_dump($image);*/ ?>
							<?php if($image->alt != 'thumbnail'):?>
							<div class="span1 product-additional-images" style="float: left; background-image: url('<?php echo $this->config->item('upload_url').'images/medium/'.$image->filename;?>');">
<img
	src="<?php echo $this->config->item('upload_url').'images/full/'.$image->filename;?>"
	style="width: 100%; height: auto; opacity: 0;" /></div>
							<?php endif;?>
							<?php endforeach;?>
						
						</div>

</div>
						<?php endif;?>
					<?php endif;?>
					
					<?php if(!empty($product->description)): ?>
						<div class="row desktop"><br class="mobile" />

<div class="span5">
<div class="cn-product-description"><?php echo $product->description; ?></div>
</div>
</div>
					<?php endif;?>
					
					<?php if(!empty($product->related_products)):?>
					<div class="row related_products desktop">
<div class="span5">
<h3 style="margin-top: 20px;"><?php echo lang('related_products_title');?></h3>
<ul class="thumbnails">
							<?php $pos_number = 0;?>
							<?php $row_number = 0;?>
							<?php foreach($product->related_products as $relate):?>
							
								<?php if($pos_number % 2):?>
								<!-- Even -->
	<li class="span2 product">
								<?php else:?>
								<!-- Odd -->
	
	
	<li class="span2 offset1 product">
								<?php endif;?>
									<?php
							$photo = theme_img ( 'no_picture.png', lang ( 'no_image_available' ) );
							
							$relate->images = array_values ( ( array ) json_decode ( $relate->images ) );
							
							if (! empty ( $relate->images [0] )) {
								$primary = $relate->images [0];
								foreach ( $relate->images as $photo ) {
									if (isset ( $photo->primary )) {
										$primary = $photo;
									}
								}
								
								$photo = '<img src="' . $this->config->item ( 'upload_url' ) . 'images/thumbnails/' . $primary->filename . '" alt="' . $relate->seo_title . '"/>';
							}
							?>
									<a class="thumbnail"
		href="<?php echo site_url($relate->slug); ?>">
										<?php echo $photo; ?>
									</a>
	<h5 style="margin-top: 5px;"><a
		href="<?php echo site_url($relate->slug); ?>"><?php echo $relate->name;?></a></h5>

	<div>
										<?php if($relate->saleprice > 0):?>
											<span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($relate->price); ?></span>
	<span class="price-sale"><?php echo lang('product_sale');?> <?php echo format_currency($relate->saleprice); ?></span>
										<?php else: ?>
											<span class="price-reg"><?php echo lang('product_price');?> <?php echo format_currency($relate->price); ?></span>
										<?php endif; ?>
									</div>
				                    <?php if((bool)$relate->track_stock && $relate->quantity < 1 && config_item('inventory_enabled')) { ?>
										<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
									<?php } ?>
								
								<?php if($pos_number % 2):?>
								<!-- Even --></li>
								<?php else:?>
								<!-- Odd -->
	</li>
								<?php $row_number += 1;?> 
								<?php endif;?>
								
								<?php $pos_number += 1;?>
								
							<?php endforeach;?>
							</ul>
</div>
</div>
<!-- end related products desktop-->
					<?php else:?>
					<?php if(!preg_match('/(kit|ensemble)/', current_url())):?>
					<?php if($this->session->userdata('page_count') % 2 == 0):?>
					<!-- 1&1 Ad Block -->
<div class="row only-desktop" style="padding-top: 17px;"><br />
<br />
<div class="span5" style="height: 60px; overflow: hidden;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/DIY/fr_diy_an_468x60.gif"
	width="468" height="60" border="0" /></a></div>
</div>
					<?php else:?>
					<!-- AdSense Block -->
<div class="row only-desktop" style="padding-top: 17px;"><br />
<br />
<div class="span5" style="height: 60px; overflow: hidden;"><script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - banner - 1 --> <ins class="adsbygoogle"
	style="display: inline-block; width: 468px; height: 60px"
	data-ad-client="ca-pub-9537579192121159" data-ad-slot="3205313820"></ins>
<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script></div>
</div>
					<?php endif;?>
					<?php endif;?>
					<?php endif;?>
					
				</div>
<!-- End span5 primary-img-row-->

<div class="span4 individual-product" itemscope
	itemtype="http://schema.org/IndividualProduct">

<div class="row"><br class="desktop" />

<div class="span4 pull-left">
<div>
<h2 style="font-weight: normal;">
<div itemprop="name" class="product-header-cn"><?php echo preg_filter(array("/'/", '/"/'), array("&#39;", "&#34;"),$product->name);?></div>
									
									<?php foreach($product->images as $image):?>
									<?php if($image->alt == 'thumbnail'):?>
									<!--
									<div itemprop="http://purl.org/goodrelations/v1#color">
										<<meta property="gr:color" content="<?php echo $image->caption; ?>" />
									</div>
									-->
									<?php endif;?>
									<?php endforeach;?>
									
									<div class="pull-left" itemprop="offers" itemscope
	itemtype="http://schema.org/Offer">
<meta itemprop="seller" content="Claire &#38; Nathalie" />
										<?php if($product->saleprice > 0):?>
											<small><?php echo lang('on_sale');?></small> <span
	class="price-slash"><?php echo format_currency($product->price); ?></span>
<span class="price-sale"><span itemprop="price"><?php echo format_currency($product->saleprice); ?></span></span>
										<?php else: ?>
											<small><?php echo lang('product_price');?></small> <span
	class="price-reg"><span itemprop="price"><?php echo format_currency($product->price); ?></span></span>
										<?php endif;?>
										<meta itemprop="priceCurrency"
	content="<?php echo $this->session->userdata('currency');?>" />
										<?php if ($product->quantity < 1): ?>
										<meta itemprop="itemCondition" content="new"
	href="http://schema.org/NewCondition" />
<meta itemprop="availability" content="out_of_stock"
	href="http://schema.org/OutOfStock" />
										<?php else: ?>
										<meta itemprop="itemCondition" content="new"
	href="http://schema.org/NewCondition" />
<meta itemprop="availability" content="in_stock"
	href="http://schema.org/InStock" />
										<?php endif;?>
									</div>
</h2>
</div>
</div>
</div>

<div class="row">

<div class="span4">
							
							<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/Housse/i', $product->name)):?>
							
							<br class="desktop" />

<div>
								<?php if(!empty($primary->caption)):?>
								<div style="color: #6e6e6d;"><?php echo lang('cover_color');?><?php echo $primary->caption;?></div>
<br />
								<?php endif;?>
								<?php if($product->excerpt != ''): ?>
								<div
	style="text-transform: uppercase; font-size: 12px; font-wight: 300; color: #6ab5cb;"><?php echo $product->excerpt; ?></div>
								<?php endif; ?>
							</div>
							<?php else:?>
							<div>
								<?php if($this->session->userdata('lang_scope') == 'en' && preg_match('/(duvet-covers|the-couettabra-range)/', current_url()) ):?>
								<div style="height: 27.5px;">&nbsp;</div>
								<?php endif; ?>
								<div
	style="text-transform: uppercase; font-size: 12px; font-wight: 300; color: #6ab5cb;"><?php echo $product->excerpt; ?></div>
								<?php if($this->session->userdata('lang_scope') == 'en' && preg_match('/(duvet-covers|the-couettabra-range)/', current_url()) ):?>
								<div style="height: 27.5px;">&nbsp;</div>
								<?php endif; ?>
								
							</div>
							<?php endif;?>
						</div>

</div>

<div class="row">

<div class="span3 sku-pricing" itemprop="productID"
	content='<?php if(!empty($product->sku)):?><?php echo $product->sku; ?><?php else:?><?php echo preg_filter(array("/'/", '/"/'), array("&#39;", "&#34;"),$product->name);?><?php endif;?>'>
							<?php if(!empty($product->sku)):?><div><?php echo lang('sku');?>: <?php echo $product->sku; ?></div><?php endif;?>&nbsp;
						</div>
						<?php if((bool)$product->track_stock && config_item('inventory_enabled')):?>
							<?php if($product->quantity < 1):?>
						<div class="span3 out-of-stock">
<div><?php echo lang('out_of_stock');?></div>
</div>
							<?php elseif($product->quantity <= $this->config->item('limit_fin_de_collection') && $product->quantity >= 1):?>
						<!--		
						<div class="span3 fin-de-collection">
							<div><?php echo lang('fin_de_collection');?></div>
						</div>
						-->
							<?php endif;?>
						<?php endif;?>
						
					</div>

<!-- Start Good Relations Metadata -->
<div about="#offering" typeof="gr:Offering" style="height: 0px;">
						<?php if($product->saleprice > 0):?>
						<div property="gr:name"
	content="Claire &#38; Nathalie | Boutique | <?php echo (isset($gamme))?$gamme:htmlspecialchars($product->name); ?> | <?php echo format_currency($product->saleprice); ?> | Produit <?php echo $product->id ; ?>"
	xml:lang="fr"></div>
						<?php else: ?>
						<div property="gr:name"
	content="Claire &#38; Nathalie | Boutique | <?php echo (isset($gamme))?$gamme:htmlspecialchars($product->name); ?> | <?php echo format_currency($product->price); ?> | Produit <?php echo $product->id ; ?>"
	xml:lang="fr"></div>
						<?php endif;?>
					    <div property="gr:description"
	content="<?php echo htmlspecialchars($product->description); ?>"
	xml:lang="fr"></div>
					    <?php if(!empty($product->images[0])):?>
					    <div rel="foaf:depiction"
	resource="<?php echo $this->config->item('upload_url').'images/medium/'.$primary->filename ; ?>">
</div>
					    <?php endif;?>
					    <div property="gr:BusinessEntity"
	content="Claire &#38; Nathalie" datatype="xsd:string"></div>
<div rel="gr:hasBusinessFunction"
	resource="http://purl.org/goodrelations/v1#Sell"></div>
<div property="gr:Brand"
	content="<?php echo (isset($gamme))?$gamme:htmlspecialchars($product->name); ?>"
	datatype="xsd:string"></div>
<div property="gr:condition" content="new" datatype="xsd:string"></div>
					    <?php if((bool)$product->track_stock && config_item('inventory_enabled')):?>
					    <div rel="gr:hasInventoryLevel">
							<?php if($product->quantity < 1):?>
					      <div typeof="gr:QuantitativeValue">
<div property="gr:hasMinValue" content="0"></div>
</div>
							<?php else:?>
						 <div typeof="gr:QuantitativeValue">
<div property="gr:hasMinValue" content="1"></div>
</div>	
							<?php endif;?>
						</div>
						<?php endif;?>
							
					    <div rel="gr:hasPriceSpecification">
<div typeof="gr:UnitPriceSpecification">
<div property="gr:hasCurrency"
	content="<?php echo $this->session->userdata('currency');?>"
	datatype="xsd:string"></div>
					        <?php if($product->saleprice > 0):?>
							<div property="gr:hasCurrencyValue"
	content="<?php echo number_format(abs(((float)$product->saleprice)*((float)$this->session->userdata('currency_rate'))), $this->session->userdata('currency_decimal_place'), $this->config->item('currency_decimal'), $this->config->item('currency_thousands_separator')); ?>"
	datatype="xsd:float"></div>
							<?php else: ?>
							<div property="gr:hasCurrencyValue"
	content="<?php echo number_format(abs(((float)$product->price)*((float)$this->session->userdata('currency_rate'))), $this->session->userdata('currency_decimal_place'), $this->config->item('currency_decimal'), $this->config->item('currency_thousands_separator')); ?>"
	datatype="xsd:float"></div>
							<?php endif;?>
					      </div>
</div>
<div rel="gr:acceptedPaymentMethods"
	resource="http://purl.org/goodrelations/v1#PayPal"></div>
<div rel="gr:acceptedPaymentMethods"
	resource="http://purl.org/goodrelations/v1#MasterCard"></div>
<div rel="gr:acceptedPaymentMethods"
	resource="http://purl.org/goodrelations/v1#VISA"></div>
<div rel="foaf:page"
	resource="<?php echo base_url('cart/product' . $product->id); ?>"></div>
</div>
<!-- End Good Relations Metadata -->

<div class="row">
<div class="span4">
							<?php
							
if (preg_match ( '/(kit|ensemble)/', current_url () )) {
								$product_cart_form_class_extension = '-kit';
							} else {
								$product_cart_form_class_extension = '';
							}
							?>
							<div
	class="product-cart-form<?php echo $product_cart_form_class_extension ?>">
<!-- start form -->
								<?php echo form_open('cart/add_to_cart', 'class="form-horizontal" style="padding: 0; margin: 0;"');?>
									<input type="hidden" name="cartkey"
	value="<?php echo $this->session->flashdata('cartkey');?>" /> <input
	type="hidden" name="id" value="<?php echo $product->id?>" />
<fieldset><!-- START PRODUCT OPTIONS -->
										<?php if(count($options) > 0): ?>
											<?php
											
foreach ( $options as $option ) :
												$required = '';
												if ($option->required) {
													$required = '<span class="help-block">' . lang ( 'option_required' ) . '</span>';
												}
												?>
											<div class="control-group">
													<?php
												/*
													this is where we generate the options and either use default values, or previously posted variables
													that we either returned for errors, or in some other releases of Go Cart the user may be editing
													and entry in their cart.
													*/
												
												//if we're dealing with a textfield or text area, grab the option value and store it in value
												if ($option->type == 'checklist') {
													$value = array ();
													if ($posted_options && isset ( $posted_options [$option->id] )) {
														$value = $posted_options [$option->id];
													}
												} else {
													if (isset ( $option->values [0] )) {
														$value = $option->values [0]->value;
														if ($posted_options && isset ( $posted_options [$option->id] )) {
															$value = $posted_options [$option->id];
														}
													} else {
														$value = false;
													}
												}
												?>
													<?php if($option->type == 'textfield'):?><?php /* START OPTION TYPES */ ?>
													<label class="control-label"><?php echo $option->name;?></label>
<div class="controls"><input type="text"
	name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>"
	class="span4" />
															<?php echo $required;?>
														</div>
													<?php elseif($option->type == 'textarea'):?>
													<label class="control-label"><?php echo $option->name;?></label>
<div class="controls"><textarea class="span4"
	name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
															<?php echo $required;?>
														</div>
													<?php elseif($option->type == 'droplist'):?>
													<label class="control-label"><?php echo $option->name;?></label>
<div class="controls"><select name="option[<?php echo $option->id;?>]">
	<option value=""><?php echo lang('choose_option');?></option>
					
															<?php
													
foreach ( $option->values as $values ) :
														$selected = '';
														if ($value == $values->id) {
															$selected = ' selected="selected"';
														}
														?>
					
																<option <?php echo $selected;?>
		value="<?php echo $values->id;?>">
																	<?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
																</option>
					
															<?php endforeach;?>
															</select>
															<?php echo $required;?>
														</div>
													<?php elseif($option->type == 'radiolist'):?>
													
														<?php if(preg_match('/(kit|ensemble)/', current_url())):?>
														
														<div class="lead cn-lead" style="margin-top: -25px;">
															<?php if($product_contents != ''):?>
															
															<!-- 
															<p style="text-align:left;color:#e64d56;padding: 10px 0;"><?php echo $product_contents;?></p>
															-->
															
															<?php endif;?>
															<!-- 
															<p style="text-align:center;"><?php echo lang('label_housse_selection');?><?php echo $kit_type_sup;?></p>
															<p style="text-align:center;"><small style="color: #fff;"><?php echo lang('option_housse_required');?></small></p>
															--></div>
<div class="well well-small" style="padding: 0; margin: 0;">
<div class="row-fluid" id="cn-housse-list-options">
<div class="span12">
																	<?php $pos_number = 0;?>
																	<?php $row_number = 0;?>
																	<?php /*print_r_html($option->values)*/;?>
																	<?php
														
foreach ( $option->values as $values ) :
															$checked = '';
															if ($value == $values->id) {
																$checked = ' checked="checked"';
															}
															?>
																	<?php if($pos_number % 2):?>
																	<!-- Even -->
<div class="housse-options span4"
	style="margin: 0; padding: 0; cursor: pointer;">
																	<?php else:?>
																	<!-- Odd -->
<div class="row-fluid">
<div class="housse-options span4"
	style="margin: 0; padding: 0; cursor: pointer;">
																	<?php endif;?>
																	
																		<?php if(isset($values->quantity)):?>
																		<div class="row-fluid">
<div class="span12" style="margin: 0; height: auto;">
<table style="margin: 0; width: inherit; border-top: none;"
	class="housse-option-tbl"
	id="housse-option-tbl-<?php echo $values->child_connected_product_id;?>">
	<tr class="housse-options-tbl-row"
		id="housse-options-tbl-row-<?php echo $values->child_connected_product_id;?>"
		<?php if(isset($values->excerpt)):?> data-toggle="popover"
		title="<?php echo $values->name;?>" data-trigger="hover"
		data-html="true" data-animation="true" data-color="blue"
		data-content="<?=htmlspecialchars('<div style="max-width: 320px;"><img src="'.$values->image.'" style="width: 320px; height: auto;" /><br /><p>'.$values->excerpt.'</p></div>');?>"
		<?php else:?> data-toggle="popover"
		title="<?php echo $values->name;?>" data-trigger="hover"
		data-html="true" data-animation="true" data-color="blue"
		data-content="<?=htmlspecialchars('<div style="max-width: 320px;"><img src="'.$values->image.'" style="width: 320px; height: auto;" /></div>');?>"
		<?php endif;?>>
		<td class="housse-option-radio"
			style="width: 5%; vertical-align: middle;"><label class="radio"
			style="margin-top: 2px;"> <input <?php echo $checked;?> type="radio"
			name="option[<?php echo $values->option_id;?>]"
			value="<?php echo $values->id;?>" /> <input type="hidden"
			name="option[stock_quantity]" value="<?php echo $values->quantity;?>" />
		<input type="hidden" name="option[child_connected_product_id]"
			value="<?php echo $values->child_connected_product_id;?>" /> </label>
		</td>
		<!-- <td class="housse-option-details" style="background-image: <?php if($values->quantity <= $this->config->item('limit_fin_de_collection')):?>url('<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetathalie/').CONTENT_FOLDER.'default/assets/img/'.$fin_de_collection_image);?>'), <?php endif;?>url('<?php echo $values->image;?>');"> -->
		<td class="housse-option-details" style="background-image: url('<?php echo $values->image;?>');">
																							<?php if($this->session->userdata('language') == 'french') : ?>
																							<div class="housse-option-name"><?php echo preg_replace('/Housse/', 'Housse<br class="txt-br-housse-option-name"/>', $option->name);?> <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
																							<?php elseif($this->session->userdata('language') == 'english') :?>
																							<div class="housse-option-name"><?php echo preg_replace('/Duvet Cover/', 'Duvet Cover<br class="txt-br-housse-option-name"/>', $option->name);?> <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
																							<?php endif;?>
																						</td>
	</tr>
																					<?php if(isset($values->caption)):?>
																					
																					<?php endif;?>
																				</table>

</div>
</div>
																		<?php else:?>
																		<div class="row-fluid" style="">
<div class="span12 pull-left" style="margin: 0; height: 90px;">
<table class="table"
	style="margin: 0; width: inherit; height: 90px; border-top: none;">
	<tr>
		<td class="housse-option-radio"
			style="width: 5%; vertical-align: middle;"><label class="radio"
			style="margin-top: 2px;"> <input <?php echo $checked;?> type="radio"
			name="option[<?php echo $option->id;?>]"
			value="<?php echo $values->id;?>" /> </label></td>
		<td class="housse-option-name"
			style="width: 95%; vertical-align: middle;">
		<div style="padding-top: 1.5px;"><?php echo $option->name;?> <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
		</td>
	</tr>
</table>
</div>
</div>
																		<?php endif;?>
																			
																	<?php if($pos_number % 2):?>
																	<!-- Even --></div>
</div>
<!-- .row-fluid -->
																	<?php else:?>
																	<!-- Odd --></div>
																	<?php $row_number += 1;?> 
																	<?php endif;?>
																	
																	<?php $pos_number += 1;?>
																	
																	<?php endforeach;?>
																	
																	<script type="text/javascript">
																		$script.ready(['bootstrap_js_0'], function() {
																			$(document).ready(function(){
																				$('.housse-options-tbl-row').hover(function() {
																					$(this).popover({
																							placement: function(){
																					        if($(window).width() <= 767) {
																					        	return 'top'
																					        }else{
																					        	return 'left'
																					        }
																					    }
																					})
																					$(this).popover('show');
																				});
																			});
																		});
																	</script>
																	
																	<?php if(preg_match('/(Housse|Duvet Cover)/', $this->session->flashdata('error'))):?>
																	<div class="row-fluid clearfix">
<div class="span12" style="text-align: center; margin-top: 5px;">
																	<?php $required = '<span class="label label-important" style="vertical-align: bottom;">'.lang('option_housse_required').'</span>';?>
																	<?php echo $required;?>
																		</div>
</div>
																	<?php else:?>
																	<?php $required = '<span class="label" style="vertical-align: bottom;">'.lang('option_housse_required').'</span>';?>
																	<?php endif;?>
																</div>
</div>
</div>
<!-- .well -->
														
														<?php else:?>	
														
														<label class="control-label"><?php echo $option->name;?></label>
<div class="controls">
																<?php
														
foreach ( $option->values as $values ) :
															
															$checked = '';
															if ($value == $values->id) {
																$checked = ' checked="checked"';
															}
															?>
																	<label class="radio"> <input <?php echo $checked;?>
	type="radio" name="option[<?php echo $option->id;?>]"
	value="<?php echo $values->id;?>" />
																		<?php echo $option->name;?> <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
																	</label>
																<?php endforeach;?>
																<?php echo $required;?>
															</div>
															
														<?php endif;?>	
													
													<?php elseif($option->type == 'checklist'):?>
													<label class="control-label"><?php echo $option->name;?></label>
<div class="controls">
															<?php
													
foreach ( $option->values as $values ) :
														
														$checked = '';
														if (in_array ( $values->id, $value )) {
															$checked = ' checked="checked"';
														}
														?>
																<label class="checkbox"> <input <?php echo $checked;?>
	type="checkbox" name="option[<?php echo $option->id;?>][]"
	value="<?php echo $values->id;?>" />
																	<?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
																</label>
																
															<?php endforeach; ?>
														</div>
														<?php echo $required;?>
													<?php endif;?><?php /* END OPTION TYPES */ ?>
													</div>
												<?php endforeach;?>
											<?php endif;?>
										<!-- END PRODUCT OPTIONS --> <br>
										
										<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/(kit|ensemble)/i', uri_string())):?>
										<div id="cn-add-to-cart"
	style="margin: -18px 0 -20px; padding: 22px 0 22px; height: 44px;"> 
									 	<?php else:?>
										<div id="cn-add-to-cart"
	style="margin: -18px 0 -20px; padding: 22px 0 22px; height: 44px;"> 
									 	<?php endif; ?>
										
										<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/(kit|ensemble)/i', uri_string())):?>
											<div class="control-group"
	style="margin: 0 auto; width: 100%;">
<div style="text-align: center;">
													<?php if(!config_item('inventory_enabled') || config_item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0) : ?>
													<button class="btn btn-primary btn-large" type="submit"
	value="submit" style="margin-bottom: 10px;"><i
	class="icon-shopping-cart icon-white"></i> <?php echo lang('form_add_to_cart');?></button>
													<?php endif;?>
												</div>
</div>
										<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/housse/i', uri_string())):?>
											<?php if(!$product->fixed_quantity) : ?>
											<div class="control-group"
	style="margin: 0 auto; width: 100%;">
<div style="text-align: center; width: inherit;"><label
	class="control-label" for="quantity" style="text-align: right;"><?php echo lang('quantity') ?>&nbsp;&nbsp;&nbsp;</label>
<div class="controls"><input class="span1" type="text" name="quantity"
	value="" style="margin-top: -3px; float: left; max-width: 60px;" /></div>
</div>
</div>
<br />
<br />
											<?php endif; ?>
											<div class="control-group"
	style="margin: 0 auto; width: 100%;">
<div style="text-align: center;">
													<?php if(!config_item('inventory_enabled') || config_item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0) : ?>
													<button class="btn btn-primary btn-large"
	data-toggle="modal" data-target="#confirm-housse-modal"
	style="margin-bottom: 10px;"><i class="icon-shopping-cart icon-white"></i> <?php echo lang('form_add_to_cart');?></button>
													<?php endif;?>
												</div>
</div>
										<?php else:?>
											<?php if(!$product->fixed_quantity) : ?>
											<div class="control-group"
	style="margin: 0 auto; width: 100%;">
<div style="text-align: center; width: inherit;"><label
	class="control-label" for="quantity" style="text-align: right;"><?php echo lang('quantity') ?>&nbsp;&nbsp;&nbsp;</label>
<div class="controls"><input class="span1" type="text" name="quantity"
	value="" style="margin-top: -3px; float: left; max-width: 60px;" /></div>
</div>
</div>
<br />
<br />
											<?php endif; ?>
											<div class="control-group"
	style="margin: 0 auto; width: 100%;">
<div style="text-align: center;">
													<?php if(!config_item('inventory_enabled') || config_item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0) : ?>
													<button class="btn btn-primary btn-large" type="submit"
	value="submit" style="margin-bottom: 10px;"><i
	class="icon-shopping-cart icon-white"></i> <?php echo lang('form_add_to_cart');?></button>
													<?php endif;?>
												</div>
</div>
										<?php endif; ?>
											
											<div class="modal hide" id="confirm-housse-modal"
	data-backdrop="true" style="width: 90%; max-width: 600px;">
<div class="modal-body">
<p class="lead"
	style="text-align: center; margin: 20px 0 20px; padding: 0 20px;"><?php echo lang('are_you_sure_you_dont_need_a_duvet');?></p>
</div>
<div class="modal-footer"><a id="confirm-housse-modal-yes-back"
	class="btn btn-primary pull-left confirm-housse-modal-btn"
	href="<?php echo $kit_type_redirect;?>"><?php echo lang('ah_yes_I_need_a_duvet');?></a>
<button id="confirm-housse-modal-no-continue"
	class="btn btn-primary pull-right confirm-housse-modal-btn"
	type="submit" value="submit"><?php echo lang('bah_no_I_already_have_one');?></button>
</div>
</div>

</div>

</fieldset>
</form>
<!-- end form --></div>
<!-- End product-cart-form --></div>
<!-- End span4 --></div>
<!-- End row -->
					
					<?php if(!empty($product->description)): ?>
					<div class="row mobile">
<div class="span9"><br class="mobile" />

<div class="cn-product-description"><?php echo $product->description; ?></div>
</div>
</div>
					<?php endif;?>
					
					<?php if(!empty($product->related_products)):?>
					<div class="row related_products mobile">
<div class="span9">
<h3 style="margin-top: 20px;"><?php echo lang('related_products_title');?></h3>
<ul class="thumbnails">	
							<?php foreach($product->related_products as $relate):?>
								<li class="span3 product">
									<?php
							$photo = theme_img ( 'no_picture.png', lang ( 'no_image_available' ) );
							
							$relate->images = array_values ( ( array ) json_decode ( $relate->images ) );
							
							if (! empty ( $relate->images [0] )) {
								$primary = $relate->images [0];
								foreach ( $relate->images as $photo ) {
									if (isset ( $photo->primary )) {
										$primary = $photo;
									}
								}
								
								$photo = '<img src="' . $this->config->item ( 'upload_url' ) . 'images/thumbnails/' . $primary->filename . '" alt="' . $relate->seo_title . '"/>';
							}
							?>
									<a class="thumbnail"
		href="<?php echo site_url($relate->slug); ?>">
										<?php echo $photo; ?>
									</a>
	<h5 style="margin-top: 5px;"><a
		href="<?php echo site_url($relate->slug); ?>"><?php echo $relate->name;?></a></h5>

	<div>
										<?php if($relate->saleprice > 0):?>
											<span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($relate->price); ?></span>
	<span class="price-sale"><?php echo lang('product_sale');?> <?php echo format_currency($relate->saleprice); ?></span>
										<?php else: ?>
											<span class="price-reg"><?php echo lang('product_price');?> <?php echo format_currency($relate->price); ?></span>
										<?php endif; ?>
									</div>
				                    <?php if((bool)$relate->track_stock && $relate->quantity < 1 && config_item('inventory_enabled')) { ?>
										<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
									<?php } ?>
								</li>
							<?php endforeach;?>
							</ul>
</div>
</div>
<!-- end related products desktop-->
					<?php endif;?>
					
					<?php if(!preg_match('/(kit|ensemble)/', current_url())):?>
					<br />
<br />

<div class="row only-desktop">
<div class="span4" style="height: 420px; overflow: hidden;">

<div class="fb-like-box"
	data-href="https://www.facebook.com/pages/Couettabra-Claire-Nathalie/125326350915703"
	data-height="420" data-colorscheme="light" data-show-faces="true"
	data-header="false" data-stream="true" data-show-border="false"></div>

</div>
</div>
					<?php endif;?>
					
				</div>
<!-- End span4 Individual Product --></div>
			
			<?php if(!preg_match('/(kit|ensemble)/', current_url())):?>
			<div class="row desktop">

<div class="span9">
					
					<?php if($this->session->userdata('page_count') % 2 == 0):?>
					<!-- AdSense Block -->
<div class="row tablet-portrait" style="margin-top: 10px;">
<div class="span9">
<div class="fb-like-box"
	data-href="https://www.facebook.com/pages/Couettabra-Claire-Nathalie/125326350915703"
	data-height="238" data-colorscheme="light" data-show-faces="true"
	data-header="false" data-stream="true" data-show-border="true"></div>
</div>
</div>
<div class="row">
<div class="span9"
	style="height: 70px; padding-top: 25px; vertical-align: middle; overflow: hidden;">

<script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Display Only - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="1868181425" data-ad-format="auto"></ins> <script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script></div>
</div>
					<?php else:?>
					<!-- AdSense Block -->
<div class="row tablet-portrait" style="margin-top: 10px;">
<div class="span9">
<div class="row">
<div class="span4">
<div style="width: 290px;">
<div class="fb-activity" data-app-id="<?=$fb_appId;?>"
	data-site="http://clairetnathalie.com"
	data-action="likes, recommends, reviews" data-height="240"
	data-colorscheme="light" data-header="false" data-show-border="true"
	data-ref="fb-activity-feed-<?=$fb_appId;?>"></div>
</div>
</div>
<div class="span4 offset1">
<div style="text-align: left;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_250x250.gif"
	width="240" height="240" border="0" /></a></div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="span9"
	style="height: 70px; padding-top: 25px; vertical-align: middle; overflow: hidden;">

<div style="text-align: center;"><script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Display Only - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="1868181425" data-ad-format="auto"> </ins> <script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script> <!-- <a href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_728x90.gif" width="728" height="90"  border="0"/></a> -->

</div>

</div>
</div>
					<?php endif;?>
					
				</div>

</div>
			<?php endif;?>
			
		</div>
<!-- span12 --></div>
<!-- End row mainContentOfPage --> <script type="text/javascript">
		$script.ready(['jquery_local_0'], function() {
			$(document).ready(function(){
				$(function(){ 
					$('.category_container').each(function(){
						$(this).children().equalHeights();
					});	
					
				});
				
				$('.housse-options').click(function() {
					$('.housse-options').each(function() {
						$(this).find('input[type="radio"]').prop('checked',false);
						$(this).find('input[name="option[stock_quantity]"]').attr("disabled",true);
						$(this).find('input[name="option[child_connected_product_id]"]').attr("disabled",true);
						$(this).removeClass('active');
					});
					$(this).find('input[type="radio"]').prop('checked',true);
					$(this).find('input[name="option[stock_quantity]"]').removeAttr('disabled');
					$(this).find('input[name="option[child_connected_product_id]"]').removeAttr('disabled');
					$(this).addClass('active');
					//$('.product-cart-form-kit').find('#cn-add-to-cart').css({'border': '2px solid #6ab5cb'});
				});
				
			});
		});
	</script></div>
<!-- End span9 namespace -->