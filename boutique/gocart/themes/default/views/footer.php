
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

<?php /*$this->carabiner->display('social_js', 'js', TRUE);*/ ?>

<script type="text/javascript">
$script.ready(['social_js_0'], function() {
	
	window.___gcfg = {
		lang: '<?php echo (($this->config->item('language') == 'english') ? 'en' : 'fr');?>',
		parsetags: 'onload'
  	};
  	(function() {
    	var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
    	po.src = "https://apis.google.com/js/plusone.js?publisherid=108232619274893307463";
    	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
  	})();

	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	
});  	
</script>

<?php endif;?>
<?php endif;?>

<?php if( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page' && !preg_match('/(liens|links)/i', uri_string()) ):?>
<script type="text/javascript">
	$script.ready(['jquery_local_0'], function() {
		$(document).ready(function(){

			//alert('jquery is ready');
			$(".embed-responsive").fitVids();
			
			$('.cn-accordion').find('.accordion-group').each(function() {
				if($(this).find('.accordion-body').hasClass('in'))
				{
					$(this).find('.accordion-heading').addClass('active');
				}
			});
		    
		});
	});
	
	$script.ready(['bootstrap_js_0'], function() {
		$(document).ready(function(){

			$('.accordion-group').on('hide', function () {
		    	$(this).find('.accordion-heading').removeClass('active');
		    });
	
		    $('.accordion-group').on('show', function () {
		    	$(this).find('.accordion-heading').addClass('active');
		    });
		    
		});
	});
</script>
<?php endif;?>

<?php if( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page' && preg_match('/(liens|links)/i', uri_string()) ):?>
<script type="text/javascript">
	$script.ready(['jquery_local_0'], function() {
		$(document).ready(function(){
			
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
	});
</script>
<?php endif;?>

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<script type="text/javascript">
	$script.ready(['gocart_js_0'], function() {
		$(document).ready(function(){

			if( $('.product').length )  
			{	
				$('.product').equalHeights();
			}
			
			if( $('.primary-img-row').length)  
			{
				//this_primary_img_row_width = $('.primary-img-row').actual('width');
				this_primary_img_row_width = $('.primary-img-row').width();
				$('#primary-img').css({
						'width': this_primary_img_row_width,
						'height': 'auto'
				});
			}
	
			if( $('#primary-img').length)  
			{		
				//var this_primary_img_height = $('#primary-img').actual('height');
				var this_primary_img_height = $('#primary-img').height();
				
				$('.primary-img-holder').css({
						'height': this_primary_img_height
				});
			}
	
			
			$(window).resize(function() {
	
				if( $('.primary-img-row').length)  
				{
					//this_primary_img_row_width = $('.primary-img-row').actual('width');
					this_primary_img_row_width = $('.primary-img-row').width();
					$('#primary-img').css({
							'width': this_primary_img_row_width,
							'height': 'auto'
					});
				}
	
				if( $('#primary-img').length)  
				{
					//var this_primary_img_height = $('#primary-img').actual('height');
					var this_primary_img_height = $('#primary-img').height();
					
					$('.primary-img-holder').css({
						'height': this_primary_img_height
					});
				}
			});
	
			$('.product-additional-images').click(function() {
				//$(this).children('img').squard2($(this).parent().parent().actual('width'), $('#primary-img'));
				//var this_primary_img_height = $('#primary-img').actual('height');
				$(this).children('img').squard2($(this).parent().parent().width(), $('#primary-img'));
				var this_primary_img_height = $('#primary-img').height();
				$('.primary-img-holder').css({
					'height': this_primary_img_height
				});
			});
			
		});
	});
</script>
<?php endif;?>

<?php if(!preg_match('/(localhost|test\.clairetnathalie\.com)/', $_SERVER["HTTP_HOST"])):?>
<?php if(!preg_match('/(gw_gate|pp_gate|bnp_gate)/i', uri_string())):?>

<script type="text/javascript">
<?php $carabiner_group = 'google_js';?>
<?php $src_array = explode(',', $this->carabiner->display_src_string($carabiner_group, 'js')); ?>
<?php $script_list[$carabiner_group] = '';?>
<?php $count = 0; ?>
<?php foreach($src_array as $src): ?>
<?php $script_list[$carabiner_group] .= ($count > 0)?',':''; ?>
<?php $script_list[$carabiner_group] .= '"'.$carabiner_group.'_'.$count.'"'; ?>
<?php echo '$script("'.$src.'", "'.$carabiner_group.'_'.$count.'");'."\n\r"; ?>
<?php $count += 1; ?>
<?php endforeach; ?>

$script.ready(['google_js_0'], function() {
  	//alert('google js is ready');
});
</script>



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
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/990747914/?value=0&amp;guid=ON&amp;script=0" />
</div>
</noscript>

<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 975255929;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/975255929/?value=0&amp;guid=ON&amp;script=0" />
</div>
</noscript>



<!-- Adroll SmartPixel for Remarketing Tag -->
<script type="text/javascript">
adroll_adv_id = "VHMMQJULYBBI7EXBVHL7MW";
adroll_pix_id = "RGE4EQBW55FBFP6YEIC6XP";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

<?php endif;?>
<?php endif;?>



<?php if(!preg_match('/(localhost|test\.clairetnathalie\.com)/', $_SERVER["HTTP_HOST"])):?>
<!-- Google Code for Conversion Page -->

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<!-- View product page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "224UCIam-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=224UCIam-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'giftcard'):?>
<!-- View giftcard page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "7cC3CN7C9gYQirq22AM";
var google_conversion_value = 0;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=7cC3CN7C9gYQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'view_cart'):?>
<!-- View cart page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "K81TCPan-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=K81TCPan-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'place_order'):?>
<!-- Order placed page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "lBVtCMat-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=lBVtCMat-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'step_1'):?>
<!-- Adress form - step 1 -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "4b5kCO6o-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=4b5kCO6o-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'step_2'):?>
<!-- Shipping form - step 2 -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "N2PsCN6q-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=N2PsCN6q-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'step_3'):?>
<!-- Payment form - step 3 -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "2yXvCNar-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=2yXvCNar-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'checkout' && $this->router->fetch_method() == 'step_4'):?>
<!-- Confirm form - step 4 -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "Yyx4CM6s-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=Yyx4CM6s-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'secure' && $this->router->fetch_method() == 'my_account'):?>
<!-- Register - My Account page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "6Qi2CP6v9gYQirq22AM";
var google_conversion_value = 0;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=6Qi2CP6v9gYQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>


<?php if($this->router->fetch_class() == 'secure' && $this->router->fetch_method() == 'register'):?>
<!-- Signup page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990747914;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "bbKYCL6u-gQQirq22AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript"
	src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display: inline;"><img height="1" width="1"
	style="border-style: none;" alt=""
	src="//www.googleadservices.com/pagead/conversion/990747914/?value=0&amp;label=bbKYCL6u-gQQirq22AM&amp;guid=ON&amp;script=0" />
</div>
</noscript>
<?php endif;?>

<?php endif;?>

</body>
</html>