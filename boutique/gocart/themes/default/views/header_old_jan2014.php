<!DOCTYPE html>

<!--[if lt IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie6" xml:lang="<?=$this->session->userdata('lang_scope');?>" lang="<?=$this->session->userdata('lang_scope');?>"> <![endif]-->
<!--[if IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie7" xml:lang="<?=$this->session->userdata('lang_scope');?>" lang="<?=$this->session->userdata('lang_scope');?>"> <![endif]-->
<!--[if IE 8 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie8" xml:lang="<?=$this->session->userdata('lang_scope');?>" lang="<?=$this->session->userdata('lang_scope');?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html version="HTML+RDFa 1.1"
	xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js"
	xml:lang="<?=$this->session->userdata('lang_scope');?>"
	lang="<?=$this->session->userdata('lang_scope');?>">
<!--<![endif]-->

<?php if ($this->session->userdata('fb_authorized_userid') == TRUE): ?>
<head
	prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?php echo $this->config->item('fb_namespace').': http://ogp.me/ns/apps/'.$this->config->item('fb_namespace').'#';?>">
<?php else:?>



<head
	prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
<?php endif;?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-language"
	content="<?=$this->session->userdata('lang_scope');?>" />

<?php if(!preg_match('/couettabra\.com/', $_SERVER["HTTP_HOST"])):?>

<?php if( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'index' ):?>
<title><?php echo ucfirst(htmlspecialchars($seo_title)); ?></title>
<?php else:?>
<title><?php echo (!empty($seo_title)) ?  ucfirst(htmlspecialchars($seo_title)) .' - ' : ''; echo htmlspecialchars($this->config->item('company_name')); ?></title>
<?php endif;?>

<?php if(isset($meta)):?>
<meta name="description"
	lang="<?=$this->session->userdata('lang_scope');?>"
	content="<?php echo htmlspecialchars($meta);?>">
<?php else:?>
<meta name="description"
	lang="<?=$this->session->userdata('lang_scope');?>"
	content="<?=htmlspecialchars($this->lang->line("cn_description"));?>">
<?php endif;?>
<meta name="keywords"
	content="<?=htmlspecialchars($this->lang->line("cn_keywords"));?>">

<?php else:?>

<title><?php echo htmlspecialchars($this->lang->line("couettabra_title")); echo htmlspecialchars($this->config->item('company_name')); ?></title>
<meta name="description"
	lang="<?=$this->session->userdata('lang_scope');?>"
	content="<?=htmlspecialchars($this->lang->line("couettabra_description_1"));?>">
<meta name="keywords"
	content="<?=htmlspecialchars($this->lang->line("couettabra_keywords"));?>">

<?php endif;?>

<link rel="alternate" type="application/vnd.google-earth.kml+xml"
	href="<?=theme_url('assets/coord/clairetnathalie.kml');?>" />
<link rel="alternate" type="application/rdf+xml" title="Geo"
	href="<?=theme_url('assets/coord/Geo.rdf');?>" />
<link rel="alternate" type="application/rss+xml"
	title="Claire & Nathalie RSS"
	href="<?=base_url();?>/xml/sitemap/data_feed_google_merchant_cn_fr.xml" />

<meta name="publisher"
	content="<?=$this->config->item('company_name');?>">
<meta name="copyright"
	content="<?=$this->config->item('company_name');?>">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="geo.position" content="48.08888,-0.75492">
<meta name="geo.country" content="FR">
<meta name="geo.region" content="FR-75">
<meta name="dcterms.language" content="fr">
<meta name="dcterms.type" content="Service">
<meta name="dcterms.format" content="text/html">
<meta name="dcterms.audience" content="all">
<meta name="dcterms.rights"
	content="<?=$this->config->item('company_name');?>">
<meta name="dcterms.publisher"
	content="<?=$this->config->item('company_name');?>">
<meta name="designer" content="flexiness">
<meta name="dcterms.title"
	content="<?=$this->config->item('company_name');?>" />
<meta name="dcterms.description"
	content="<?=$this->lang->line("cn_description");?>" />

<meta property="og:site_name"
	content="<?=$this->config->item('company_name');?>" />
<meta property="fb:app_id" content="<?=$fb_appId;?>" />
<meta property="fb:admins" content="707122929" />
<?php if($this->config->item('language') == 'french'):?>
<meta property="og:locale" content="fr_FR" />
<?php elseif($this->config->item('language') == 'english'):?>
<meta property="og:locale" content="en_US" />
<?php endif;?>
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="en_US" />
<meta property="og:determiner" content="the" />

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<meta property="og:type" content="product" />
	<?php if($product->saleprice > 0):?>
<meta property="og:price:amount"
	content="<?php echo number_format(abs(((float)$product->saleprice)*((float)$this->session->userdata('currency_rate'))), $this->session->userdata('currency_decimal_place'), $this->config->item('currency_decimal'), $this->config->item('currency_thousands_separator')); ?>" />
	<?php else: ?>
<meta property="og:price:amount"
	content="<?php echo number_format(abs(((float)$product->price)*((float)$this->session->userdata('currency_rate'))), $this->session->userdata('currency_decimal_place'), $this->config->item('currency_decimal'), $this->config->item('currency_thousands_separator')); ?>" />
	<?php endif;?>
<meta property="og:price:currency"
	content="<?php echo $this->session->userdata('currency'); /*$this->config->item('currency');*/ ?>" />
<meta property="og:availability" content="instock" />
<?php else:?>
	<?php if ($this->session->userdata('fb_authorized_userid') == TRUE): ?>	
<meta property="og:type"
	content="<?php echo $this->config->item('fb_namespace');?>:website" />
	<?php else:?>
<meta property="og:type" content="website" />
	<?php endif;?>
<?php endif;?>
		
<meta property="og:url" content="<?=current_url(); ?>" />

<?php if(!preg_match('/couettabra\.com/', $_SERVER["HTTP_HOST"])):?>

<meta property="og:title"
	content="<?=htmlspecialchars($this->config->item('company_name'));?>" />
<meta property="og:description"
	content="<?=htmlspecialchars($this->lang->line("cn_description"));?>" /> 
<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product'):?>
<?php

		$image = theme_img ( 'no_picture.png' );
		$product->images = array_values ( $product->images );
		if (! empty ( $product->images [0] )) {
			$primary = $product->images [0];
			foreach ( $product->images as $photo ) {
				if (isset ( $photo->primary )) {
					$primary = $photo;
				}
			}
			
			$image = $this->config->item ( 'upload_url' ) . 'images/full/' . $primary->filename;
		}
		?>
<meta property="og:image" content="<?=$image;?>" />
<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category'):?>
<meta property="og:image"
	content="<?=base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/logo/cn_logo-couettabra.png');?>" />
<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page'):?>
<meta property="og:image"
	content="<?=theme_img('logo/cn_open_graph_1200x1200px_3.png');?>" />
<?php else:?>
<meta property="og:image"
	content="<?=theme_img('logo/cn_open_graph_1200x1200px_3.png');?>" />
<?php endif;?>

<?php else:?>

<meta property="og:title"
	content="<?php echo htmlspecialchars($this->lang->line("couettabra_title")); echo htmlspecialchars($this->config->item('company_name')); ?>" />
<meta property="og:description"
	content="<?=htmlspecialchars($this->lang->line("couettabra_description_1"));?>" />
<meta property="og:image"
	content="<?=theme_img('logo/cn_logo_google_plus_600x228_transparent.png');?>" />

<?php endif;?>


<link rel="apple-touch-icon"
	href="<?=theme_img('logo/apple-touch-icon.png');?>">
<link rel="apple-touch-icon" sizes="72x72"
	href="<?=theme_img('logo/apple-touch-icon-72x72.png');?>" />
<link rel="apple-touch-icon" sizes="114x114"
	href="<?=theme_img('logo/apple-touch-icon-114x114.png');?>" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<?php if(!preg_match('/couettabra\.com/', $_SERVER["HTTP_HOST"])):?>
<link rel="apple-touch-startup-image"
	href="<?=theme_img('logo/cn_logo-header_212x45px.png');?>" />
<?php else:?>
<link rel="apple-touch-startup-image"
	href="<?=theme_img('logo/cn_logo_google_plus_600x228_transparent.png');?>" />
<?php endif;?>


<?php if($this->session->userdata('mobile_user') == true):?>
	<?php if($this->session->userdata('mobile_user_type') == 'apple'):?>
		<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone')):?>
			<!-- <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/> -->
<meta name="viewport"
	content="user-scalable=no, width=320, initial-scale=1.0, maximum-scale=1.0" />
		<?php elseif(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')):?>
			<!-- <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/> -->
<meta name="viewport"
	content="user-scalable=no, width=768, initial-scale=1.0, maximum-scale=1.0" />
		<?php endif;?>
	<?php endif;?>
<?php endif;?>

<meta name="google-site-verification"
	content="ZAwLzvMezzCQ8HKNAJO1KaH7ofw7DlBglBnVLPp0aRI" />
<?php if(!preg_match('/couettabra\.com/', $_SERVER["HTTP_HOST"])):?>
<link href="https://plus.google.com/108232619274893307463"
	rel="publisher" />
<?php else:?>
<link href="https://plus.google.com/104382625920076976269"
	rel="publisher" />
<?php endif;?>

<?php if($this->config->item('kickstrap') == false):?>
<?php

	/*echo theme_css('bootstrap.min.css', true) . "\n\r";*/
	/*echo theme_css('bootstrap-cn.css', true) . "\n\r";*/
	/*echo theme_css('bootstrap-cn.min.css', true) . "\n\r";*/
	/*echo theme_css('bootstrap-responsive.min.css', true) . "\n\r";*/
	/*echo theme_css('social-buttons.css', true) . "\n\r";*/
	/* font-awesome required for socila buttons */
	/*echo '<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">' . "\n\r";*/
	/*echo'<link rel="stylesheet" href="'. $this->config->item('asset_url') .'default/assets/fonts/MyFontsWebfontsOrderM3527085_unhinted.css" type="text/css" media="all"/>' . "\n\r";*/
	/*echo theme_css('fonts.css', true) . "\n\r";*/
	?>
<?php else:?>
<?php

	echo '<link href="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/kickstrap.less" type="text/css" rel="stylesheet/less">' . "\n\r";
	echo '<script src="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/Kickstrap/js/less-1.3.3.min.js"></script>' . "\n\r";
	?>
<?php endif;?>

<?php /*echo theme_css('styles.css', true) . "\n\r";*/ ?>
<?php /*echo theme_css('styles.min.css', true) . "\n\r";*/ ?>

<?php $this->carabiner->display('bootstrap_css', 'css');?>

<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra' && $this->config->item('mobile_user')==false):?>
<?php echo theme_css('styles_category.css', true) . "\n\r";?>
<?php else:?>
<?php endif;?>		

		
<?php if(strstr(uri_string(),'place_order') && $this->go_cart->verify_payment_confirmed()):?>
	<script type="text/javascript">
		
		//alert('hey ya');
		
		var _gaq = _gaq || [];
		var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
		_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
		_gaq.push(['_setAccount', 'UA-40529120-3']);
		_gaq.push(['_set', 'currencyCode', '<?php echo $this->session->userdata('currency');?>']);
		_gaq.push(['_setDomainName', '<?php echo $this->config->item('domain_name');?>']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);
		
		// transaction ID - required
		// affiliation or store name
		// total - required
		// tax
		// shipping
		// city
		// state or province
		// country
		
		_gaq.push(['_addTrans',
		  '<?php echo $order_id ?>',
		  '<?=$this->config->item('company_name');?> Boutique eCommerce',
		  '<?php echo $go_cart['total'];?>',
		  '<?php echo $go_cart['order_tax'];?>',
		  '<?php echo $go_cart['shipping_cost'];?>',
		  '<?php echo $customer['bill_address']['city'];?>',
		  '<?php echo $customer['bill_address']['zone'];?>',
		  '<?php echo $customer['bill_address']['country'];?>'
		]);
		
		// add item might be called for every item in the shopping cart
		// where your ecommerce engine loops through each item in the cart and
		// prints out _addItem for each
		
		<?php foreach ($go_cart['contents'] as $cartkey=>$product):?>
		<?php /*$prod_categories = simplexml_load_string($product['category_xml_navigation']);*/?>
		
		// transaction ID - required
		// SKU/code - required
		// product name
		// category or variation
		// unit price - required
		// quantity - required
		
		_gaq.push(['_addItem',
		  '<?php echo $order_id ?>',
		  '<?php echo $product['id'] ;?>',
		  '<?php echo $product['name'];?>',
		  '<?php echo (isset($product['excerpt'])) ? $product['excerpt'] : '';?>',
		  '<?php echo $product['price'];?>',
		  '<?php echo $product['quantity'];?>'
		]);
		
		<?php endforeach; ?>
		
		_gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
		
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; // no remarketing
		  //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/u/ga_debug.js'; // debugging
		  //ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js'; // with remarketing
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>

<!-- Google Analytics -->
<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', 'UA-40529120-3');
		ga('require', 'ecommerce', 'ecommerce.js');
		ga('send', 'pageview');

		ga('ecommerce:addTransaction', {
		  'id': '<?php echo $order_id ?>',
		  'affiliation': '<?=$this->config->item('company_name');?> Boutique eCommerce',
		  'revenue': '<?php echo $go_cart['total']; ?>',
		  'tax': '<?php echo $go_cart['order_tax']; ?>',
		  'shipping': '<?php echo $go_cart['shipping_cost']; ?>',
		  'currency': '<?php echo $this->session->userdata('currency');?>'
		});

		<?php foreach ($go_cart['contents'] as $cartkey=>$product):?>
		ga('ecommerce:addItem', {
		  'id': '<?php echo $order_id ?>',
	      'name': '<?php echo $product['name'];?>',
	      'sku': '<?php echo $product['id'] ;?>',
	      'category': 'Home Linen',
	      'price': '<?php echo $product['price']; ?>',
	      'quantity': '<?php echo $product['quantity']; ?>',
	      'currency': '<?php echo $this->session->userdata('currency');?>'
		});
		<?php endforeach; ?>
		
		ga('ecommerce:send');
	</script>
<!-- End Google Analytics -->
<?php else:?> 
	
	<?php /*echo theme_js('google/ga_tracking.js', true) . "\n\r";*/?>
	
	<script type="text/javascript">
		var _gaq = _gaq || [];
		var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
		_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
		_gaq.push(['_setAccount', 'UA-40529120-3']);
		_gaq.push(['_set', 'currencyCode', '<?php echo $this->session->userdata('currency');?>']);
		_gaq.push(['_setDomainName', '<?php echo $this->config->item('domain_name');?>']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);
		
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  	ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js'; // with remarketing
			//ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; // no remarketing
		    //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/u/ga_debug.js'; // debugging
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>

<!-- Google Analytics -->
<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', 'UA-40529120-3');
		ga('require', 'linkid', 'linkid.js');
		ga('send', 'pageview');
	</script>
<!-- End Google Analytics -->
	
<?php endif;?>

	<!-- Added by Yahoo Commerce Central. DO NOT REMOVE/EDIT -->
<!--
	<meta name="google-site-verification" content="wN6Y2FlLtgUNdRjeL1od7-lEOMgOqwT5ozWAnMHGtoI"/>
	<script type="text/javascript">
	(function(d, w) {
	  var x = d.getElementsByTagName('SCRIPT')[0];
	  var g = d.createElement('SCRIPT');
	  g.type = 'text/javascript';
	  g.async = true;
	  g.src = ('https:' == d.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	  x.parentNode.insertBefore(g, x);
	  var f = function () {
	    var s = d.createElement('SCRIPT');
	    s.type = 'text/javascript';
	    s.async = true;
	    s.src = "//np.lexity.com/ed6f7069";
	    x.parentNode.insertBefore(s, x);
	  };
	  w.attachEvent ? w.attachEvent('onload', f) : w.addEventListener('load', f, false);
	}(document, window));
	</script>
	 -->
<!-- End of addition by Yahoo Commerce Central. DO NOT REMOVE/EDIT -->

<?php
//with this I can put header data in the header instead of in the body.
if (isset ( $additional_header_info )) {
	echo $additional_header_info;
}

?>

<base href="<?=current_url();?>" />

</head>

<?php
if ($this->agent->is_browser ()) {
	$agent = $this->agent->browser ();
	$browser_version = $this->agent->version ();
} elseif ($this->agent->is_robot ()) {
	$agent = $this->agent->robot ();
} elseif ($this->agent->is_mobile ()) {
	$agent = $this->agent->mobile ();
} else {
	$agent = '';
}
?>
	
<body class="<?php echo strtolower($agent);?>">

<?php if(!preg_match('/localhost/', $_SERVER["HTTP_HOST"])):?>
<div id="fb-root"></div>
<?php endif;?>

<?php if($this->config->item('kickstrap') == false):?>
<?php /*No Kickstrap*/?>

<?php /*echo theme_js('jquery-1.10.2.min.js', true, false) . "\n\r";*/?>
<?php /*echo theme_js('jquery-1.10.2.min.map', true) . "\n\r";*/?>
<?php /*echo theme_js('bootstrap.min.js', true, false) . "\n\r";*/?>
<?php /*echo '<script src="//use.edgefonts.net/abel:n4:all;advent-pro:n1,n2,n3,n4,n5,n6,n7:all.js"></script>' . "\n\r";*/ ?>

<?php else:?>
<?php /*With Kickstrap*/?>

<?php echo '<script src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/jquery-1.8.3.min.js"></script>' . "\n\r"; ?>
<?php echo '<script id="appList" src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/kickstrap.js"></script>' . "\n\r"; ?>

<?php endif;?>

<?php /*echo html_helper_tag_manager() . "\n\r";*/ ?>

<?php $this->carabiner->display('script_js', 'js');?>

<script type="text/javascript">
	
	<?php $carabiner_group = 'jquery_local';?>
	<?php $src_array = explode(',', $this->carabiner->display_src_string($carabiner_group, 'js')); ?>
	<?php $script_list[$carabiner_group] = '';?>
	<?php $count = 0; ?>
	<?php foreach($src_array as $src): ?>
	<?php $script_list[$carabiner_group] .= ($count > 0)?',':''; ?>
	<?php $script_list[$carabiner_group] .= '"'.$carabiner_group.'_'.$count.'"'; ?>
	<?php echo '$script("'.$src.'", "'.$carabiner_group.'_'.$count.'");'."\n\r"; ?>
	<?php $count += 1; ?>
	<?php endforeach; ?>

	<?php $carabiner_group = 'bootstrap_js';?>
	<?php $src_array = explode(',', $this->carabiner->display_src_string($carabiner_group, 'js')); ?>
	<?php $script_list[$carabiner_group] = '';?>
	<?php $count = 0; ?>
	<?php foreach($src_array as $src): ?>
	<?php $script_list[$carabiner_group] .= ($count > 0)?',':''; ?>
	<?php $script_list[$carabiner_group] .= '"'.$carabiner_group.'_'.$count.'"'; ?>
	<?php echo '$script("'.$src.'", "'.$carabiner_group.'_'.$count.'");'."\n\r"; ?>
	<?php $count += 1; ?>
	<?php endforeach; ?>

	<?php $carabiner_group = 'gocart_js';?>
	<?php $src_array = explode(',', $this->carabiner->display_src_string($carabiner_group, 'js')); ?>
	<?php $script_list[$carabiner_group] = '';?>
	<?php $count = 0; ?>
	<?php foreach($src_array as $src): ?>
	<?php $script_list[$carabiner_group] .= ($count > 0)?',':''; ?>
	<?php $script_list[$carabiner_group] .= '"'.$carabiner_group.'_'.$count.'"'; ?>
	<?php echo '$script("'.$src.'", "'.$carabiner_group.'_'.$count.'");'."\n\r"; ?>
	<?php $count += 1; ?>
	<?php endforeach; ?>
	
    $script.ready([<?php echo $script_list['jquery_local']; ?>], function() {
      	//alert('jquery is ready');
    }).ready([<?php echo $script_list['bootstrap_js']; ?>], function() {
      	//alert('bootstrap js is ready');
	}).ready([<?php echo $script_list['gocart_js']; ?>], function() {
      	//alert('gocart js is ready');
	});
    
</script>

<?php /*echo theme_js('squard.js', true, true) . "\n\r";*/?>
<?php /*echo theme_js('equal_heights.js', true, true) . "\n\r";*/?>
<?php /*echo theme_js('actual-height/jquery.actual.min.js', true, true) . "\n\r";*/?>

<?php /*echo theme_js('google/controller_ga_social_tracking.js', true, true) . "\n\r";*/?>
<?php /*echo '<script async type="text/javascript" src="http://code.createjs.com/createjs-2013.05.14.min.js"></script>' . "\n\r";*/?>
<?php /*echo '<script type="text/javascript" src="http://modernizr.com/downloads/modernizr.js"></script>' . "\n\r";*/ ?>
<?php /*echo '<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.0/modernizr.min.js"></script>' . "\n\r";*/ ?>

<?php if(!preg_match('/localhost/', $_SERVER["HTTP_HOST"])):?>
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({
	    	appId      				: '<?=$fb_appId;?>',
		    status     				: true,
		    cookie     				: true,
		    xfbml      				: true,
		    oauth      				: true,
		    frictionlessRequests	: true,
		    channelUrl				: '<?=($this->config->item('language') == 'french')?$this->config->item('base_url').'channel_fr.php':$this->config->item('base_url').'channel_en.php'?>'
	     });
	
	     //_ga.trackFacebook(); //Google Analytics tracking

<?php if($this->session->userdata('fb_auth_app_promo_already') == 'false' && $this->session->userdata('fb_promo_active') == 'true'):?>

		FB.getLoginStatus(function(response) {

	<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() != 'view_cart') :?>
	
		<?php if($this->config->item('language') == 'french'):?>

			if (response.status === 'connected') {
			   	//alert("connected");
			   	document.getElementById('status_connection_fb').innerHTML='Merci de nous avoir rejoint sur facebook';
			} else if (response.status === 'not_authorized') {
				//alert("not_authorized");
			   	//login();
			   	document.getElementById('status_connection_fb').innerHTML='Vous êtes connecté(e) au réseau social facebook mais vous n\'avez pas encore autorisé l\'application \"<?php echo $fb_app_link;?>\"';
		    } else {
		    	//alert("not_logged_in");
		    	//login();
		    	document.getElementById('status_connection_fb').innerHTML='Rejoignez \"<a onClick=login() class="highlight" style=\'text-decoration: none; cursor: pointer;font-weight:600;\'><?php echo $this->config->item('company_name');?></a>\" sur facebook pour bénéficier d\'un bon de réduction sur votre prochain commande';
		    }

		<?php else:?>

			if (response.status === 'connected') {
				//alert("connected");
				document.getElementById('status_connection_fb').innerHTML='Thank you for joining us on facebook';
			} else if (response.status === 'not_authorized') {
				//alert("not_authorized");
				//login();
				document.getElementById('status_connection_fb').innerHTML='You are connected to facebook but you haven\'t authorized the "<?php echo $fb_app_link;?>" yet';
		    } else {
		    	//alert("not_logged_in");
		   		//login();
		   		document.getElementById('status_connection_fb').innerHTML='Join \"<a onClick=login() class="highlight" style=\'text-decoration: none; cursor: pointer;font-weight:600;\'><?php echo $this->config->item('company_name');?></a>\" on facebook and benefit from a voucher on your next purchase';
		    }
		    
		<?php endif;?>

	<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'view_cart'):?>

		<?php if($this->config->item('language') == 'french'):?>
	
			if (response.status === 'connected') {
				//alert("connected");
				document.getElementById('promo_join_app_fb').innerHTML='En vous remerciant de nous avoir rejoint sur Facebook. Voici le code pour votre bon de réduction : <span style=\'font-family: Arial;\'>Promo-fb-JoinNTy</span>';
			} else if (response.status === 'not_authorized') {
				//alert("not_authorized");
			} else {
				//alert("not_logged_in");
		    }
		
		<?php else:?>
		
			if (response.status === 'connected') {
				//alert("connected");
				document.getElementById('promo_join_app_fb').innerHTML='Thank you for joining us on facebook. Here is your voucher code : <span style=\'font-family: Arial;\'>Promo-fb-JoinNTy</span>';
			} else if (response.status === 'not_authorized') {
				//alert("not_authorized");
			} else {
				//alert("not_logged_in");
		    }
		    
		<?php endif;?>
		
	<?php endif; ?>

		});
		
<?php endif;?>
	     
	};

	// Load the Facebook SDK Asynchronously
    (function(d){
      var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement('script'); 
      js.id = id; js.async = true;
      js.src = '//connect.facebook.net/<?=($this->config->item('language') == 'french')?'fr_FR':'en_US'?>/all.js';
      ref.parentNode.insertBefore(js, ref);
    }(document));

    function login() {
	    FB.login(function(response) {
	        if (response.authResponse) {
	            // connected
	        } else {
	            // cancelled
	        }
	    });
	};
    
</script>
<?php endif;?>
	
	<!-- START NAV -->
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">

<div id="btn-navbar-holder"><!-- .btn-navbar is used as the toggle for collapsed navbar content -->
<a class="btn btn-navbar" data-toggle="collapse"
	data-target=".nav-collapse"> <span class="icon-bar"></span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> </a>

<div class="modal hide" id="access-blog-modal" data-backdrop="true"
	style="width: 90%; max-width: 600px; z-index: 4000;">
<div class="modal-header" style="border: none;">
<button type="button" class="close" data-dismiss="modal"
	aria-hidden="true">&times;</button>
</div>
<div class="modal-body">
<p class="lead"
	style="text-align: center; margin: 20px 0 20px; padding: 0 20px;"><?php echo lang('join_us_to_access_blog');?></p>
</div>
<div class="modal-footer">
<div class="btn-group">
<div class="btn-holder"><a class="btn btn-social btn-facebook"
	href="<?php echo $fb_join_blog ;?>"><strong><i class="icon-facebook"
	alt="Facebook Login" title="Facebook Login"></i> <small>Facebook</small></strong></a>
</div>
</div>
</div>
</div>

</div>

<div xmlns="http://www.w3.org/1999/xhtml"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
	xmlns:gr="http://purl.org/goodrelations/v1#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:vcard="http://www.w3.org/2006/vcard/ns#" class="organization">

<div itemscope itemtype="http://schema.org/Organization"><a
	class="brand" href="<?php echo site_url();?>">
<div itemprop="name" content="<?=$this->config->item('company_name');?>"
	style="width: 212px; height: 45px;"><img itemprop="image"
	src="<?=theme_img('logo/cn_logo-header_212x45px.png');?>"
	alt="<?=$this->config->item('company_name');?>" />
<div class="circle"></div>
</div>
</a>

<div about="#company" typeof="gr:BusinessEntity">

<div property="gr:legalName"
	content="<?=$this->config->item('entreprise_name');?>"></div>

<div rel="vcard:adr">
<div typeof="vcard:Address">
<div property="vcard:country-name"
	content="<?=$this->config->item('country_full');?>"></div>
<div property="vcard:locality"
	content="<?=$this->config->item('city');?>"></div>
<div property="vcard:postal-code"
	content="<?=$this->config->item('zip');?>"></div>
<div property="vcard:street-address"
	content="<?=$this->config->item('address1');?> <?=$this->config->item('address2');?>"></div>
</div>
</div>
<div property="vcard:email"
	content="contact@<?php echo $this->config->item('domain_name');?>"></div>
<div rel="vcard:geo">
<div>
<div property="vcard:latitude" content="48.088877" datatype="xsd:float"></div>
<div property="vcard:longitude" content="-0.754924" datatype="xsd:float"></div>
</div>
</div>

<div rel="foaf:depiction"
	resource="<?=theme_img('logo/cn_logo-header_212x45px.png');?>"></div>
<div rel="foaf:page" resource=""></div>
</div>

</div>

</div>

<nav class="nav-collapse">

<ul id="nav-cn-navigation" class="nav" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">

	<li class="dropdown" itemprop="name" itemscope="itemscope"
		itemtype="http://schema.org/SiteNavigationElement"><a href="#"
		class="dropdown-toggle" data-toggle="dropdown" role="button">
	<div><?php echo lang('catalog');?></div>
	</a>
	<ul class="dropdown-menu">
								<?php foreach($this->categories as $cat_menu):?>
								<li><a
			href="<?php echo site_url($cat_menu['category']->slug);?>"
			itemprop="url">
		<div itemprop="name"><?php echo $cat_menu['category']->name;?></div>
		</a></li>
								<?php endforeach;?>
							</ul>
	</li>
						
						<?php foreach($this->pages as $menu_page):?>
							
						<?php if($this->session->userdata('language') == 'french') : ?>
							
							<?php
								
if (! preg_match ( '/des-questions/', $menu_page->slug ) && ! preg_match ( '/cgv/', $menu_page->slug ) && ! preg_match ( '/mentions-legales/', $menu_page->slug ) && ! preg_match ( '/liens/', $menu_page->slug )) :
									?>
							<li>
							<?php if(empty($menu_page->content)):?>
								<a href="<?php echo $menu_page->url;?>"
		<?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>
		itemprop="url">
	<div itemprop="name"><?php echo $menu_page->menu_title;?></div>
	</a>
							<?php else:?>
								<a href="<?php echo site_url($menu_page->slug);?>"
		itemprop="url">
	<div itemprop="name"><?php echo $menu_page->menu_title;?></div>
	</a>
							<?php endif;?>
							</li>
							<?php endif;?>
						
						<?php elseif($this->session->userdata('language') == 'english') :?>
						
							<?php
								
if (! preg_match ( '/any-questions/', $menu_page->slug ) && ! preg_match ( '/terms-and-conditions/', $menu_page->slug ) && ! preg_match ( '/legal-notice/', $menu_page->slug ) && ! preg_match ( '/links/', $menu_page->slug )) :
									?>
							<li>
							<?php if(empty($menu_page->content)):?>
								<a href="<?php echo $menu_page->url;?>"
		<?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>
		itemprop="url">
	<div itemprop="name"><?php echo $menu_page->menu_title;?></div>
	</a>
							<?php else:?>
								<a href="<?php echo site_url($menu_page->slug);?>"
		itemprop="url">
	<div itemprop="name"><?php echo $menu_page->menu_title;?></div>
	</a>
							<?php endif;?>
							</li>
							<?php endif;?>
							
						<?php endif;?>
							
						<?php endforeach;?>
						
						<?php if(!preg_match('/localhost/', $_SERVER["HTTP_HOST"])):?>
						<li><a href="#" data-toggle="modal"
		data-target="#access-blog-modal" role="button"> <span itemprop="url"
		content="https://www.facebook.com/pages/Couettabra/125326350915703">
	<div itemprop="name"><?php echo lang('latest_news'); ?></div>
	</span> </a></li>
						<?php else:?>
						<li><a
		href="https://www.facebook.com/pages/Couettabra/125326350915703"
		target="_blank" itemprop="url">
	<div itemprop="name"><?php echo lang('latest_news'); ?></div>
	</a></li>
						<?php endif;?>
						
					</ul>

<ul id="nav-cn-compte" class="nav" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">
						
						<?php if($this->Customer_model->is_logged_in(false, false)):?>
							<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown" role="button">
	<div itemprop="name"><?php echo lang('account');?></div>
	</a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo  site_url('secure/my_account');?>"
			rel="nofollow"><?php echo lang('my_account');?></a></li>
		<li><a href="<?php echo  site_url('secure/my_downloads');?>"
			rel="nofollow"><?php echo lang('my_downloads');?></a></li>
		<li class="divider"></li>
		<li><a href="<?php echo site_url('secure/logout');?>" rel="nofollow"><?php echo lang('logout');?></a></li>
	</ul>
	</li>
						<?php else: ?>
							<li><a href="<?php echo site_url('secure/login');?>"
		itemprop="url"> <span class="cn-offleft" itemprop="name"><?php echo lang('login');?></span>
	<img class="icon-compte"
		src="<?=theme_img('icons/cn_picto-compte_13x16px.png');?>"
		alt="<?php echo lang('login');?>" /> </a></li>
						<?php endif; ?>
							<li><a href="<?php echo site_url('cart/view_cart');?>"
		itemprop="url"> <span class="cn-offleft" itemprop="name"><?php echo lang('cart');?></span>
	<img class="icon-panier" src="<?=theme_img('icons/cn_picto-panier_17x13px.png');?>" style="<?php echo ($this->go_cart->total_items() >= 1)?'padding-right: 20px;':'padding-right: 0px;';?>" alt="<?php echo lang('cart');?>" />
								<?php
								if ($this->go_cart->total_items () == 0) {
									echo lang ( 'empty_cart' );
								} else {
									if ($this->go_cart->total_items () > 1) {
										echo sprintf ( lang ( 'multiple_items' ), $this->go_cart->total_items () );
									} else {
										echo sprintf ( lang ( 'single_item' ), $this->go_cart->total_items () );
									}
								}
								?>
								</a></li>
</ul>
					
					<?php if($this->config->item('category_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->data['category']->name == 'Couettabra' && $this->config->item('mobile_user')==false):?>
					
					<div id="navbarCategoryCouettbra">
<ul class="nav pull-left" style="font-size: 16px;">
	<li><a href="#concept">Couettabra</a></li>
							
							<?php $product_count = 1;?>
							<?php foreach($products as $product):?>
							
							<?php if(preg_match('/Kit "Couettabra" 2 places/i', $product->name)):?>
							<li><a
		href="#product-info-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"><?php echo preg_replace('/"Couettabra" /', '', $product->name);?></a></li><?php echo "\n\r";?>
							<?php elseif(preg_match('/Kit "Couettabra" 1 place/i', $product->name)):?>
							<li><a
		href="#product-info-<?php echo strtolower(preg_replace('/ /', '-', preg_replace('/"Couettabra" /', '',  $product->name)));?>"><?php echo preg_replace('/"Couettabra" /', '', $product->name);?></a></li><?php echo "\n\r";?>
							<?php else:?>
							<li><a
		href="#product-info-<?php echo strtolower(preg_replace('/ /', '-', $product->name));?>"><?php echo $product->name;?></a></li><?php echo "\n\r";?>
							<?php endif; ?>
							
							<?php $product_count += 1;?>
							<?php endforeach?>
							
							<?php if(isset($subcategories) && count($subcategories) > 0): ?>
							<li><a href="#product-info-housses">Housses</a></li>
							<?php endif;?>
							
						</ul>
</div>
					
					<?php elseif($this->config->item('homepage_style_couettabra') && $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'index' && $this->config->item('mobile_user')==false):?>
					
					<?php endif;?>
					
				</nav>

</div>
</div>
</div>
<!-- END NAV -->
	
	<?php
	if ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'index') {
		$page_type = 'itemscope itemtype="http://schema.org/WebPage"';
	} elseif ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'category') {
		$page_type = 'itemscope itemtype="http://schema.org/CollectionPage"';
	} elseif ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'product') {
		$page_type = 'itemscope itemtype="http://schema.org/ItemPage"';
	} elseif ($this->router->fetch_class () == 'checkout') {
		$page_type = 'itemscope itemtype="http://schema.org/CheckoutPage"';
	} else {
		$page_type = '';
	}
	?>
	
	<!-- START MAIN CONTAINER -->
<div id="skrollr-body" class="main container" <?php echo $page_type; ?>>
		
		
		
		<?php
		/*print_r_html($this->config->item('language'));*/
		?>
		
		<?php if ($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'index'):?>
		<br class="clearfix mobile">
		<?php else:?>
		<div class="page-header-cn-couettabra"
	style="background: #e64d56; height: auto; min-height: 35px; margin: 0 0 30px;">
			
			<?php if ($this->session->flashdata('message')):?>
				<div class="alert alert-info" id="header-flash-message"><a
	class="close" data-dismiss="alert">×</a>
					<?php echo $this->session->flashdata('message');?>
				</div>
			<?php endif;?>
			
			<?php if ($this->session->flashdata('error')):?>
				<div class="alert alert-error" id="header-flash-error"><a
	class="close" data-dismiss="alert">×</a>
					<?php echo $this->session->flashdata('error');?>
				</div>
			<?php endif;?>
			
			<?php if (!empty($error)):?>
				<div class="alert alert-error" id="header-error"><a class="close"
	data-dismiss="alert">×</a>
					<?php echo $error;?>
				</div>
			<?php endif;?>
			
		</div>
		<?php endif;?>
<?php
/*
End header.php file
*/