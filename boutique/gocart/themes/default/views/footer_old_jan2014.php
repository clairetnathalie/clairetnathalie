
</div>
<!-- END MAIN CONTAINER -->

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->config->item('category_style_couettabra2') && $this->data['category']->name == 'Couettabra'): ?>

<div class="row-fluid">
<div class="span12">
			
			<?php if($this->session->userdata('page_count') % 2 == 0):?>
			<br />
<br />
<div class="tablet-portrait" style="text-align: center;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_728x90.gif"
	width="728" height="90" border="0" /></a></div>
			<?php else:?>
			<br />
<br />
<div class="tablet-portrait" style="text-align: center;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_728x90.gif"
	width="728" height="90" border="0" /></a></div>
			<?php endif;?>
			
		</div>
</div>

<div class="row-fluid">
<div class="span12">
		
			<?php if($this->session->userdata('page_count') % 2 == 0):?>
			<div class="mobile" style="text-align: center;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_468x60.gif"
	width="468" height="60" border="0" /></a></div>
			<?php else:?>
			<div class="mobile" style="text-align: center;"><a
	href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_468x60.gif"
	width="468" height="60" border="0" /></a></div>
			<?php endif;?>
	
		</div>
</div>

<?php endif;?>

<!-- START FOOTER -->
<div id="footer-section" class="container">
<div class="row">
<div class="span12"><footer class="footer"> <nav class="text-center"
	style="text-align: center;">
						
						<?php if($this->config->item('language') == 'french'):?>
						<ul class="nav-footer-list" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/cgv">
	<div itemprop="name">Conditions Générales de Vente</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/mentions-legales">
	<div itemprop="name">Mentions légales</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/liens">
	<div itemprop="name">Liens</div>
	</a></li>
	<li><a itemprop="url" href="http://www.oeildeboeuf.net"
		title="Oeil de boeuf">
	<div itemprop="name">Design</div>
	</a></li>
	<li><a itemprop="url" href="http://www.flexiness.com" title="Flexiness">
	<div itemprop="name">Web Dev</div>
	</a></li>
</ul>
						<?php elseif($this->config->item('language') == 'english'):?>
						<ul class="nav-footer-list" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/terms-and-conditions">
	<div itemprop="name">Terms and Conditions</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/legal-notice">
	<div itemprop="name">Legal Notice</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/links">
	<div itemprop="name">Links</div>
	</a></li>
	<li><a itemprop="url" href="http://www.oeildeboeuf.net"
		title="Oeil de boeuf">
	<div itemprop="name">Design</div>
	</a></li>
	<li><a itemprop="url" href="http://www.flexiness.com" title="Flexiness">
	<div itemprop="name">Web Dev</div>
	</a></li>
</ul>
						<?php else:?>
						<ul class="nav-footer-list" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/terms-and-conditions">
	<div itemprop="name">Terms and Conditions</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/legal-notice">
	<div itemprop="name">Legal Notice</div>
	</a></li>
	<li><a itemprop="url"
		href="http://<?php echo $this->config->item('domain_name');?>/links">
	<div itemprop="name">Links</div>
	</a></li>
	<li><a itemprop="url" href="http://www.oeildeboeuf.net"
		title="Oeil de boeuf">
	<div itemprop="name">Design</div>
	</a></li>
	<li><a itemprop="url" href="http://www.flexiness.com" title="Flexiness">
	<div itemprop="name">Web Dev</div>
	</a></li>
</ul>
						<?php endif;?>
						
					</nav>

<p class="text-center" style="text-align: center;" itemscope
	itemtype="http://purl.org/goodrelations/v1#BusinessEntity"><small>
<meta itemprop="name"
	content="<?=$this->config->item('company_name');?>" />
<strong itemprop="legalName" style="color: #6ab5cb; font-weight: 500;"><?=$this->config->item('entreprise_name');?></strong>
<address style="text-align: center;"><strong
	style="color: #6ab5cb; font-weight: 500;">Adresse :</strong> <span
	itemscope itemprop="http://schema.org/address"
	itemtype="http://schema.org/PostalAddress"> <span
	itemprop="streetAddress"><?=$this->config->item('address1');?> <?=$this->config->item('address2');?>,</span>
<span itemprop="addressLocality"><?=$this->config->item('city');?>, <span
	itemprop="postalCode"><?=$this->config->item('zip');?></span>, <?=$this->config->item('country_full');?></span>
</span> <br>
<!-- The following properties use full URIs because they are attached to a **GoodRelations type** but come from schema.org -->
<strong style="color: #6ab5cb; font-weight: 500;">E-mail :</strong> <a
	itemprop="http://schema.org/email"
	href="mailto:contact@<?php echo $this->config->item('domain_name');?>">contact@<?php echo $this->config->item('domain_name');?></a>
</address>
<link itemprop="http://schema.org/url"
	href="http://<?php echo $this->config->item('domain_name');?>/" />
							
							<?php if(!preg_match('/couettabra\.com/', $_SERVER["HTTP_HOST"])):?>
							<link itemprop="author"
	href="https://plus.google.com/108232619274893307463?rel=author" />
							<?php else:?>
							<link itemprop="author"
	href="https://plus.google.com/104382625920076976269?rel=author" />
							<?php endif;?>
						</small></p>

</footer></div>
</div>
</div>
<!-- END FOOTER -->


<?php if($this->config->item('carousel_full_page')):?>

<?php echo theme_js('jquery.carousel.fullscreen.js', true, true) . "\n\r";?>
<?php echo theme_css('style_carousel_full_page.css', true) . "\n\r";?>

<?php else:?>

<?php 	if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category'):?>
<?php 		echo theme_css('style_carousel_span12_inset.css', true) . "\n\r";?>
<?php 	elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<?php 		echo theme_css('style_carousel_span12_inset.css', true) . "\n\r";?>
<?php 	else:?>
<?php 		echo theme_css('style_carousel_span12_inset.css', true) . "\n\r";?>
<?php 	endif;?>

<?php endif;?>
	
<?php if(!preg_match('/(secure|checkout|gw_gate|pp_gate|bnp_gate)/i', uri_string())):?>

	<?php if(!preg_match('/localhost/', $_SERVER["HTTP_HOST"])):?>
<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  window.___gcfg = {
		lang: '<?php echo (($this->config->item('language') == 'english') ? 'en' : 'fr');?>',
		parsetags: 'onload'
  };
  /*
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  */
  (function() {
    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
    po.src = "https://apis.google.com/js/plusone.js?publisherid=108232619274893307463";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>
<script type="text/javascript"
	src="http://platform.tumblr.com/v1/share.js"></script>
<?php endif;?>

<?php endif;?>

<?php if( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page' && !preg_match('/(liens)/i', uri_string()) ):?>
<script type="text/javascript">
	$script.ready(['jquery_local'], function() {
		$('.cn-accordion').find('.accordion-group').each(function() {
			if($(this).find('.accordion-body').hasClass('in'))
			{
				$(this).find('.accordion-heading').addClass('active');
			}
		});

	    $('.accordion-group').on('hide', function () {
	    	$(this).find('.accordion-heading').removeClass('active');
	    });

	    $('.accordion-group').on('show', function () {
	    	$(this).find('.accordion-heading').addClass('active');
	    });
	});
</script>
<?php endif;?>

<?php if( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page' && preg_match('/(liens|links)/i', uri_string()) ):?>
<script type="text/javascript">
	$script.ready(['jquery_local'], function() {
		$.fn.favicons = function (conf) {
		    var config = $.extend({
		        insert:        'appendTo', 
		        defaultIco: '<?=$this->config->item('asset_url').'default/assets/img/icons/cn_fleche-accordeon-drte.png';?>'
		    }, conf);
	
		    return this.each(function () {
		        $('a[href^="http://"]', this).each(function () {
		            var link        = $(this);
		            var faviconURL    = link.attr('href').replace(/^(http:\/\/[^\/]+).*$/, '$1') + '/favicon.ico';
		            var faviconIMG    = $('<img src="' + config.defaultIco + '" alt="" style="width: 20px; height: 20px; margin-top: -2px;" />')[config.insert](link);
		            var extImg        = new Image();
	
		            extImg.src = faviconURL;
	
		            if (extImg.complete) {
		                faviconIMG.attr('src', faviconURL);
		            }
		            else {
		                extImg.onload = function () {
		                    faviconIMG.attr('src', faviconURL);
		                };
		            }
		        });
		    });
		};
		$('#jquery-favicons-ext').favicons({insert: 'insertBefore'});
	});
</script>
<?php endif;?>

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<script type="text/javascript">
	$script.ready(['jquery_local'], function() {
		$('.product').equalHeights();
		
		this_primary_img_row_width = $('.primary-img-row').actual('width');
		$('#primary-img').css({
				'width': this_primary_img_row_width,
				'height': 'auto'
		});

		var this_primary_img_height = $('#primary-img').actual('height');

		$('.primary-img-holder').css({
				'height': this_primary_img_height
		});

		$('.product-additional-images').click(function() {
			$(this).children('img').squard2($(this).parent().parent().actual('width'), $('#primary-img'));
			var this_primary_img_height = $('#primary-img').actual('height');
			$('.primary-img-holder').css({
				'height': this_primary_img_height
			});
		});	
		
		$(window).resize(function() {

			this_primary_img_row_width = $('.primary-img-row').actual('width');
			$('#primary-img').css({
					'width': this_primary_img_row_width,
					'height': 'auto'
			});

			var this_primary_img_height = $('#primary-img').actual('height');

			$('.primary-img-holder').css({
					'height': this_primary_img_height
			});
		});
	});
</script>
<?php endif;?>

<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra' && $this->config->item('mobile_user')==false):?>

<div id="skrollr-category-bg-header"
	class="skrollr-item skrollr-category-bg-container header"></div>

<?php $product_bg_count = 1;?>				
	<?php foreach($photo_bg as $key => $url):?>
<div class="skrollr-item skrollr-category-bg-container product"><?php echo "\n\r"; ?>
	
		<div
	id="skrollr-product-element-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '', $key)));?>"
	class="skrollr-item product-element"><?php echo "\n\r"; ?>
			
			<?php if($key == 'Kit "Couettabra" 1 place'):?>
			
				<?php if(isset($url['front'])):?>
				<div id="kit-1-place-bg-boy" class="skrollr-item bg level-0 fade-in-1" style="<?php echo $url['front'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				
				<div class="skrollr-item bg level-4 fade-in-2 circle" id="circle4"
	data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<div class="skrollr-item bg level-3 fade-in-2 circle" id="circle3"
	data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<div class="skrollr-item bg level-2 fade-in-2 circle" id="circle2"
	data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				
				<?php if(isset($url['back-1'])):?>
				<div class="skrollr-item bg level-1 fade-in-2" style="<?php echo $url['back-1'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				
			<?php elseif($key == 'Kit "Couettabra" 2 places'):?>
			
				<?php if(isset($url['front'])):?>
				<div class="skrollr-item bg level-0 fade-in-1" style="<?php echo $url['front'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				<?php if(isset($url['back-4'])):?>
				<div class="skrollr-item bg level-4 fade-in-2" style="<?php echo $url['back-4'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				<?php if(isset($url['back-3'])):?>
				<div class="skrollr-item bg level-3 fade-in-2" style="<?php echo $url['back-3'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				<?php if(isset($url['back-2'])):?>
				<div class="skrollr-item bg level-2 fade-in-2" style="<?php echo $url['back-2'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				<?php if(isset($url['back-1'])):?>
				<div class="skrollr-item bg level-1 fade-in-2" style="<?php echo $url['back-1'] ;?>" data-anchor-target="#skrollr-category-product-<?php echo $product_bg_count;?>"></div><?php echo "\n\r"; ?>
				<?php endif;?>
				
			<?php endif;?>

		</div><?php echo "\n\r"; ?>
	
	</div><?php echo "\n\r"; ?>
	<?php $product_bg_count += 1;?>	
	<?php endforeach?>

<?php endif;?>

<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra' && $this->config->item('mobile_user')==false):?>
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_1200_and_above.css', false);?>"
	media="screen and (min-width: 1200px)" data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_980_to_1199.css', false);?>"
	media="screen and (min-width: 980px) and (max-width : 1199px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_768_to_979.css', false);?>"
	media="screen and (min-width: 768px) and (max-width : 979px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_481_to_767.css', false);?>"
	media="screen and (min-width: 481px) and (max-width : 767px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_category_480_and_below.css', false);?>"
	media="screen and (max-width : 480px)" data-skrollr-stylesheet />
<?php echo theme_js('skrollr-css/dist/skrollr.stylesheets.min.js', true, true) . "\n\r";?>
<?php echo theme_js('skrollr-master/dist/skrollr.min.js', true, true) . "\n\r";?>
<?php echo theme_js('skrollr-menu-master_0.1.5/dist/skrollr.menu.min.js', true, true) . "\n\r";?>
<?php echo '<!--[if lt IE 9]>' . "\n\r";?>
<?php echo theme_js('skrollr_ie/skrollr.ie.min.js', true, true) . "\n\r";?>
<?php echo '<![endif]-->' . "\n\r";?>

<script
	src="//use.edgefonts.net/sarina;acme:n4;lobster;sonsie-one;lobster-two.js"></script>
<!-- <script src="//use.edgefonts.net/abel:n4:all;advent-pro:n1,n2,n3,n4,n5,n6,n7:all.js"></script> -->

<?php echo theme_js('layout_skrollr_category.js', true, true) . "\n\r";?>
<script type="text/javascript">

$(window).ready(function(){

	if($(window).width() >= 980) {
		if($(window).height() >= 760) {
			var windowHeight = ($(window).height()) * 1.85;
			var spacerHeaderToProducts = windowHeight * 1.2;
		}
		else {
			var windowHeight = ($(window).height()) * 2.2;
			var spacerHeaderToProducts = windowHeight * 1.65;
		}
	}
	else if($(window).width() >= 768 && $(window).width() <= 979) {
		if($(window).height() >= 760) {
			var windowHeight = ($(window).height()) * 1.85;
			var spacerHeaderToProducts = windowHeight * 1.4;
		}
		else {
			var windowHeight = ($(window).height()) * 2.2;
			var spacerHeaderToProducts = windowHeight * 2.1;
		}
	}
	else if($(window).width() >= 481 && $(window).width() <= 767) {
		if($(window).height() >= 760) {
			var windowHeight = ($(window).height()) * 1.85;
			var spacerHeaderToProducts = windowHeight * 1.8;
		}
		else {
			var windowHeight = ($(window).height()) * 2.3;
			var spacerHeaderToProducts = windowHeight * 1.7;
		}
	}
	else {
		if($(window).height() >= 760) {
			var windowHeight = ($(window).height()) * 1.85;
			var spacerHeaderToProducts = windowHeight * 1.4;
		}
		else {
			var windowHeight = ($(window).height()) * 2.6;
			var spacerHeaderToProducts = windowHeight * 1.6;
		}
	}
		
	var constantWindowHeight = windowHeight / 2;
	var sections_total = <?php echo count($products) + 0;?>;
	
	s = skrollr.init({
		smoothScrolling: true,
		smoothScrollingDuration: 500,
		scale: 10,
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
	$('.skrollr-header-section').each(function() {
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

	$('.skrollr-category-product > centered').css("height", (windowHeight)+'px');

	//$('#subcategories-section').css("height", (windowHeight * 0.25)+'px');

	$('.main.container').css("height", (windowHeight*(sections_total+1)-spacerHeaderToProducts)+'px');

	if ( document.body.style[ '-webkit-mask-repeat' ] !== undefined ) {
		
	}
	else {
		$('.category-product-style-kit-2-places.bottom').addClass('no-cssmasks');
		$('.category-product-style-kit-1-place.bottom').addClass('no-cssmasks');
	}	
	
	s.refresh();

	$('body').scrollspy({ target: '#navbarCategoryCouettbra' });
});

$(window).resize(function() {
	setTimeout(function(){
		//s.refresh();
		window.location.reload();
	},1000);
});

</script>

<?php elseif($this->config->item('homepage_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'index'):?>
	<?php if($this->config->item('mobile_user') != true):?>
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_homepage_1200_and_above.css', false);?>"
	media="screen and (min-width: 1200px)" data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_homepage_980_to_1199.css', false);?>"
	media="screen and (min-width: 980px) and (max-width : 1199px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_homepage_768_to_979.css', false);?>"
	media="screen and (min-width: 768px) and (max-width : 979px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_homepage_481_to_767.css', false);?>"
	media="screen and (min-width: 481px) and (max-width : 767px)"
	data-skrollr-stylesheet />
<link rel="stylesheet" type="text/css"
	href="<?php echo theme_css('styles_homepage_480_and_below.css', false);?>"
	media="screen and (max-width : 480px)" data-skrollr-stylesheet />
<?php else:?>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo theme_css('styles_homepage_480_and_below_mob_portrait.css', false);?>" media="screen and (max-width : 480px) and (orientation:portrait)" data-skrollr-stylesheet /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo theme_css('styles_homepage_481_to_767_mob_landscape.css', false);?>" media="screen and (max-width : 767px) and (orientation:portrait)" data-skrollr-stylesheet /> -->
<?php endif;?>
<?php echo theme_js('skrollr-css/dist/skrollr.stylesheets.min.js', true, true) . "\n\r";?>
<?php echo theme_js('skrollr-master/dist/skrollr.min.js', true, true) . "\n\r";?>
<?php /*echo theme_js('skrollr-menu-master_0.1.5/dist/skrollr.menu.min.js', true, true) . "\n\r"*/;?>
<?php echo '<!--[if lt IE 9]>' . "\n\r";?>
<?php echo theme_js('skrollr_ie/skrollr.ie.min.js', true, true) . "\n\r";?>
<?php echo '<![endif]-->' . "\n\r";?>

<!-- <script src="//use.edgefonts.net/abel:n4:all;advent-pro:n1,n2,n3,n4,n5,n6,n7:all.js"></script> -->

<?php if($this->config->item('mobile_user') != true):?>
<script type="text/javascript">
		$(window).ready(function(){
			s = skrollr.init({
				smoothScrolling: true,
				smoothScrollingDuration: 500,
				scale: 10,
				forceHeight: true,
				easing: 'easeOutCubic'
			});
		});
		$(window).resize(function() {
			setTimeout(function(){
				window.location.reload();
			},1000);
		});
		</script>
<?php else:?>
<!--
		<script type="text/javascript">
		$(window).ready(function(){
			s = skrollr.init({
				smoothScrolling: true,
				smoothScrollingDuration: 500,
				scale: 10,
				forceHeight: false,
				easing: 'easeOutCubic'
			});
		});
		</script>
		-->
<?php endif;?>
	
<?php else:?>

<?php endif;?>	


<?php if(!preg_match('/(secure|gw_gate|pp_gate|bnp_gate)/i', uri_string())):?>

<?php $this->carabiner->display('google_js', 'js', TRUE);?>

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<!-- <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script> -->
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/990747914/?value=0&amp;guid=ON&amp;script=0" />
</div>
</noscript>

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 975255929;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<!-- <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script> -->
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/975255929/?value=0&amp;guid=ON&amp;script=0" />
</div>
</noscript>

<?php endif;?>

</body>
</html>