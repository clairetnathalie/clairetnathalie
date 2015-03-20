<!DOCTYPE html>

<!--[if lt IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie6" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie7" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 8 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie8" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html version="HTML+RDFa 1.1"
	xmlns:fb="https://www.facebook.com/2008/fbml"
	xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"
	lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>">
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

<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?></title>

<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="<?=$this->lang->line("mgm_keywords");?>">
<meta name="Description"
	content="<?=$this->lang->line("mgm_description");?>">
<?php endif;?>

<link rel="alternate" type="application/vnd.google-earth.kml+xml"
	href="<?=theme_url('assets/coord/clairetnathalie.kml');?>" />
<link rel="alternate" type="application/rdf+xml" title="Geo"
	href="<?=theme_url('assets/coord/Geo.rdf');?>" />

<meta name="publisher"
	content="<?=$this->config->item('company_name');?>">
<meta name="copyright"
	content="<?=$this->config->item('company_name');?>">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<link rel="shortcut icon" href="<?=theme_img('logo/cn_logo_1.ico');?>"
	type="image/x-icon" />
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
<meta http-equiv="content-language"
	content="<?=($this->config->item('language') == 'french')?'fr':'en'?>" />
<meta name="keywords" content="<?=$this->lang->line("mgm_keywords");?>" />
<meta name="description"
	lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"
	content="<?=$this->lang->line("mgm_description");?>" />
<meta name="dcterms.title"
	content="<?=$this->config->item('company_name');?>" />
<meta name="dcterms.description"
	content="<?=$this->lang->line("mgm_description");?>" />

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
	content="<?php echo $product->saleprice; ?>" />
	<?php else: ?>
<meta property="og:price:amount"
	content="<?php echo $product->price; ?>" />
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
		
<meta property="og:title"
	content="<?=urlencode($this->config->item('company_name'));?>" />
<meta property="og:description"
	content="<?=urlencode($this->lang->line("mgm_description"));?>" />
<meta property="og:image"
	content="<?=theme_img('logo/mgm_logo_2.png');?>" />
<meta property="og:url" content="<?=current_url(); ?>" />


<link rel="apple-touch-icon"
	href="<?=theme_img('logo/apple-touch-icon.png');?>">
<link rel="apple-touch-icon" sizes="72x72"
	href="<?=theme_img('logo/apple-touch-icon-72x72.png');?>" />
<link rel="apple-touch-icon" sizes="114x114"
	href="<?=theme_img('logo/apple-touch-icon-114x114.png');?>" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-startup-image"
	href="<?=theme_img('logo/mgm_logo_lg.png');?>" />

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

<!-- <meta name="google-site-verification" content="KJN3HlMPIh932gp-RrQ49qszKwJh_3Hrpeb_5TlhYDc" /> -->

<?php if($this->config->item('kickstrap') == false):?>
<?php

	echo theme_css ( 'bootstrap.min.css', true ) . "\n\r";
	/*echo theme_css('bootstrap.css', true) . "\n\r";*/
	echo theme_css ( 'bootstrap-responsive.min.css', true ) . "\n\r";
	echo theme_css ( 'social-buttons.css', true ) . "\n\r";
	/*echo '<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">' . "\n\r";*/
	/* echo'<link rel="stylesheet" href="'. $this->config->item('asset_url') .'default/assets/fonts/MyFontsWebfontsOrderM3527085_unhinted.css" type="text/css" media="all"/>' . "\n\r";*/
	echo theme_css ( 'fonts.css', true ) . "\n\r";
	?>
<?php else:?>
<?php

	echo '<link href="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/kickstrap.less" type="text/css" rel="stylesheet/less">' . "\n\r";
	echo '<script src="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/Kickstrap/js/less-1.3.3.min.js"></script>' . "\n\r";
	?>
<?php endif;?>

<?php echo theme_css('styles.css', true) . "\n\r";?>

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
		  	//ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; // no remarketing
		    //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/u/ga_debug.js'; // debugging
		    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js'; // with remarketing
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

<body itemscope itemtype="http://schema.org/WebPage">

<!--<div id="fb-root"></div>-->

<?php if($this->config->item('kickstrap') == false):?>

<?php echo theme_js('jquery-1.10.2.min.js', true) . "\n\r";?>
<?php /*echo theme_js('jquery-1.10.2.min.map', true) . "\n\r";*/?>
<?php echo theme_js('bootstrap.min.js', true) . "\n\r";?>
<?php /*echo '<script src="//use.edgefonts.net/abel:n4:all;advent-pro:n1,n2,n3,n4,n5,n6,n7:all.js"></script>' . "\n\r";*/ ?>

<?php else:?>

<?php echo '<script src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/jquery-1.8.3.min.js"></script>' . "\n\r"; ?>
<?php echo '<script id="appList" src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/kickstrap.js"></script>' . "\n\r"; ?>

<?php endif;?>

<?php /*echo html_helper_tag_manager() . "\n\r";*/ ?>

<?php echo theme_js('squard.js', true) . "\n\r";?>
<?php echo theme_js('equal_heights.js', true) . "\n\r";?>
<?php echo theme_js('google/controller_ga_social_tracking.js', true) . "\n\r";?>

<?php echo '<script src="http://code.createjs.com/createjs-2013.05.14.min.js"></script>' . "\n\r";?>

<?php echo '<script src="http://modernizr.com/downloads/modernizr.js"></script>' . "\n\r";?>

<!--
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
			   	document.getElementById('status_connection_fb').innerHTML='Vous êtes connecté(e) au réseau social facebook mais vous n\'avez pas encore authorisé l\'application \"<?php echo $fb_app_link;?>\"';
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
-->

<!-- START NAV -->
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container"><!-- .btn-navbar is used as the toggle for collapsed navbar content -->
<a class="btn btn-navbar" data-toggle="collapse"
	data-target=".nav-collapse"> <span class="icon-bar"></span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> </a>

<div xmlns="http://www.w3.org/1999/xhtml"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
	xmlns:gr="http://purl.org/goodrelations/v1#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:vcard="http://www.w3.org/2006/vcard/ns#"><a class="brand"
	href="<?php echo site_url();?>"><img
	src="<?=theme_img('logo/cn_logo-header_212x43px.png');?>" /></a>

<div about="#company" typeof="gr:BusinessEntity">
<div property="gr:legalName"
	content="<?=$this->config->item('company_name');?> S.A.S"></div>

<div rel="vcard:adr">
<div typeof="vcard:Address">
<div property="vcard:country-name" content="France"></div>
<div property="vcard:locality" content="Laval"></div>
<div property="vcard:postal-code" content="53000"></div>
<div property="vcard:street-address" content="6, rue Léonard de Vinci"></div>
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
	resource="<?=theme_img('logo/mgm_logo_2.png');?>"></div>
<div rel="foaf:page" resource=""></div>
</div>

</div>

<div class="nav-collapse">

<ul class="nav">
	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('catalog');?> <b class="caret"></b></a>
	<ul class="dropdown-menu">
								<?php foreach($this->categories as $cat_menu):?>
								<li><a
			href="<?php echo site_url($cat_menu['category']->slug);?>"><?php echo $cat_menu['category']->name;?></a></li>
								<?php endforeach;?>
							</ul>
							
							<?php foreach($this->pages as $menu_page):?>

								
	
	
	<li>
								<?php if(empty($menu_page->content)):?>
									<a href="<?php echo $menu_page->url;?>"
		<?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $menu_page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($menu_page->slug);?>"><?php echo $menu_page->menu_title;?></a>
								<?php endif;?>
								</li>
								
							<?php endforeach;?>
					</ul>

<ul class="nav pull-right">
						
						<?php if($this->Customer_model->is_logged_in(false, false)):?>
							<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('account');?> <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo  site_url('secure/my_account');?>"><?php echo lang('my_account');?></a></li>
		<li><a href="<?php echo  site_url('secure/my_downloads');?>"><?php echo lang('my_downloads');?></a></li>
		<li class="divider"></li>
		<li><a href="<?php echo site_url('secure/logout');?>"><?php echo lang('logout');?></a></li>
	</ul>
	</li>
						<?php else: ?>
							<li><a href="<?php echo site_url('secure/login');?>"><?php echo lang('login');?></a></li>
						<?php endif; ?>
							<li><a href="<?php echo site_url('cart/view_cart');?>">
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
					
				</div>

</div>
</div>
</div>
<!-- END NAV -->
	
	<?php
	if ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'index') {
		$page_type = 'itemscope itemtype="http://schema.org/Organization"';
	} elseif ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'category') {
		$page_type = 'itemscope itemtype="http://schema.org/CollectionPage"';
	} elseif ($this->router->fetch_class () == 'cart' && $this->router->fetch_method () == 'product') {
		$page_type = 'itemscope itemtype="http://schema.org/ItemPage"';
	} else {
		$page_type = '';
	}
	?>
	
	<!-- START MAIN CONTAINER -->
<div id="skrollr-body" class="main container" <?php echo $page_type; ?>>
		
		<?php if(!empty($base_url) && is_array($base_url)):?>
			<?php if(count($base_url) > 1):?>
			<div class="row">
<div class="span12">
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
</div>
</div>
			<?php endif;?>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('message')):?>
			<div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
				<?php echo $error;?>
			</div>
		<?php endif;?>
		
		<?php
		/*print_r_html($this->config->item('language'));*/
		?>
		
<?php
/*
End header.php file
*/