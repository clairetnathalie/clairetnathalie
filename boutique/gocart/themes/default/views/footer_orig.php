
<!-- START FOOTER -->
<footer class="footer">

<p class="text-center" style="text-align: center;" itemscope
	itemtype="http://purl.org/goodrelations/v1#BusinessEntity"><small> <strong
	itemprop="legalName">Claire & Nathalie S.A.S</strong>
<address style="text-align: center;"><strong>Adresse :</strong> <span
	itemscope itemprop="http://schema.org/address"
	itemtype="http://schema.org/PostalAddress"> <span
	itemprop="streetAddress">6, rue Léonard de Vinci</span> <span
	itemprop="postalCode">53000</span> <span itemprop="addressLocality">Laval,
France</span> </span> <br>
<!-- The following properties use full URIs because they are attached to a **GoodRelations type** but come from schema.org -->
<strong>E-mail :</strong> <a itemprop="http://schema.org/email"
	href="mailto:contact@clairetnathalie.com">contact@clairetnathalie.com</a>
</address>
<link itemprop="http://schema.org/url"
	href="http://clairetnathalie.com/" />
</small></p>

</footer>
<!-- END FOOTER -->

</div>
<!-- END MAIN CONTAINER -->

<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra Test'):?>

<div id="skrollr-category-bg-header"
	class="skrollr-item skrollr-category-bg-container header"></div>

<?php $product_bg_count = 1;?>				
	<?php foreach($photo_bg as $key => $url):?>
<div class="skrollr-item skrollr-category-bg-container product"><?php echo "\n\r"; ?>
	
		<div
	id="skrollr-product-element-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '', $key)));?>"
	class="skrollr-item product-element"><?php echo "\n\r"; ?>
	
			<?php if(isset($url['front'])):?>
			<div class="skrollr-item bg level-0 fade-in-1" style="<?php echo $url['front'] ;?>"></div><?php echo "\n\r"; ?>
			<?php endif;?>
			<?php if(isset($url['back-4'])):?>
			<div class="skrollr-item bg level-4 fade-in-2" style="<?php echo $url['back-4'] ;?>"></div><?php echo "\n\r"; ?>
			<?php endif;?>
			<?php if(isset($url['back-3'])):?>
			<div class="skrollr-item bg level-3 fade-in-2" style="<?php echo $url['back-3'] ;?>"></div><?php echo "\n\r"; ?>
			<?php endif;?>
			<?php if(isset($url['back-2'])):?>
			<div class="skrollr-item bg level-2 fade-in-2" style="<?php echo $url['back-2'] ;?>"></div><?php echo "\n\r"; ?>
			<?php endif;?>
			<?php if(isset($url['back-1'])):?>
			<div class="skrollr-item bg level-1 fade-in-2" style="<?php echo $url['back-1'] ;?>"></div><?php echo "\n\r"; ?>
			<?php endif;?>
			
		</div><?php echo "\n\r"; ?>
	
	</div><?php echo "\n\r"; ?>
	<?php endforeach?>

<?php else:?>

<?php endif;?>	
	
<?php if(!preg_match('/(secure|checkout|gw_gate|pp_gate)/i', uri_string())):?>
<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  window.___gcfg = {lang: '<?php echo (($this->config->item('language') == 'english') ? 'en' : 'fr');?>'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>
<script type="text/javascript"
	src="http://platform.tumblr.com/v1/share.js"></script>
<?php endif;?>

<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra Test'):?>

<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_1200_and_above.css', false);?>"
	media="screen and (min-width: 1200px)" data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_980_to_1199.css', false);?>"
	media="screen and (min-width: 980px) and (max-width : 1199px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_768_to_979.css', false);?>"
	media="screen and (min-width: 360px) and (max-width : 979px)"
	data-skrollr-stylesheet />

<!-- 
<link rel="stylesheet" type="text/css" href="<?php echo theme_css('styles_category_768_to_979.css', false);?>" media="screen and (min-width: 768px) and (max-width : 979px)" data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css" href="<?php echo theme_css('styles_category_481_to_767.css', false);?>" media="screen and (min-width: 481px) and (max-width : 767px)" data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css" href="<?php echo theme_css('styles_category_480_and_below.css', false);?>" media="screen and (max-width : 480px)" data-skrollr-stylesheet />
-->

<?php echo theme_js('skrollr-css/dist/skrollr.stylesheets.min.js', true) . "\n\r";?>
<?php echo theme_js('skrollr-master/dist/skrollr.min.js', true) . "\n\r";?>
<?php echo theme_js('skrollr-menu/dist/skrollr.menu.min.js', true) . "\n\r";?>
<?php echo '<!--[if lt IE 9]>' . "\n\r";?>
<?php echo theme_js('skrollr_ie/skrollr.ie.min.js', true) . "\n\r";?>
<?php echo '<![endif]-->' . "\n\r";?>

<script
	src="//use.edgefonts.net/sarina;acme:n4;lobster;sonsie-one;lobster-two.js"></script>
<?php echo theme_js('layout_skrollr_category.js', true) . "\n\r";?>
<script type="text/javascript">

$(document).ready(function(){

	var windowHeight = ($(window).height()) * 1.85;
	//var windowHeight = (760) * 1.85;

	//var spacerHeaderToProducts = 0;
	if($(window).width() >= 980) {
		var spacerHeaderToProducts = windowHeight;
	}
	else if($(window).width() >= 768 && $(window).width() <= 979) {
		var spacerHeaderToProducts = windowHeight * 1.2;
	}
	else if($(window).width() >= 481 && $(window).width() <= 767) {
		var spacerHeaderToProducts = windowHeight * 1.6;
	}
	else {
		var spacerHeaderToProducts = windowHeight * 1.8;
	}
	var constantWindowHeight = windowHeight / 2;
	var sections_total = <?php echo count($products) + 0;?>;
	
	s = skrollr.init({
		smoothScrolling: true,
		smoothScrollingDuration: 500,
		scale: 0.1,
		forceHeight: true,
		constants: {
			foobar: constantWindowHeight
		}
	});

	skrollr.menu.init(s, {
		animate: true, //skrollr will smoothly animate to the new position using `animateTo`.
		duration: 1500, //How long the animation should take in ms.
		easing: 'sqrt' //The easing function to use.
	});
	
	var count_bg = 0;
	$('.skrollr-category-bg-container').each(function() {
		if(count_bg == 0)
		{
			$(this).css("height", (windowHeight)+'px');
			$(this).css("top", '0%');
			//$(this).css({zIndex: -301});
		}
		else
		{
			$(this).css("height", windowHeight+'px');
			$(this).css("top", ((windowHeight*(count_bg))+spacerHeaderToProducts)+'px');
		}
		count_bg ++;
	});
	$('.skrollr-category-header-section').each(function() {
		$(this).css("height", windowHeight+'px');
	});

	$('.skrollr-category-products').css("margin-top", spacerHeaderToProducts+'px');

	var count_product = 1;
	$('.skrollr-category-product').each(function() {
		if (count_product%2 == 0)
		{	
			//$(this).css("background","#186d0f");
			//$(this).css("background","rgba(24, 109, 15, 0.5)");
		}
		else 
		{
			//$(this).css("background","#27b519");
			//$(this).css("background","rgba(39, 181, 25, 0.5)");
		}
		count_product ++;
	});

	<?php
	/*
	$product_count = 1;
	foreach($products as $product)
	{
		$product_count += 1;
	}
	*/
	?>
	
	$('.skrollr-category-product > centered').css("height", (windowHeight)+'px');

	$('.main.container').css("height", (windowHeight*(sections_total+1)-spacerHeaderToProducts)+'px');
	
	s.refresh();

	//$('#navbarCategoryCouettbra').scrollspy();
	$('body').scrollspy({ target: '#navbarCategoryCouettbra' });
});

</script>
<?php else:?>
<?php endif;?>

</body>
</html>