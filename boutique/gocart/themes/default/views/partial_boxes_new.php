

<div class="span3">
		
		<?php foreach($boxes as $box):?>
			
			<?php $uri_string = '|/'.uri_string().'|';?>
			<?php $box_link = $box->link;?>
			
			<?php if(!preg_match($uri_string, $box_link)):?>
			
			<div class="row">

<div class="span3 cn-box-holder" itemscope="itemscope"
	itemtype="http://schema.org/SiteNavigationElement">
					<?php
				$box_title = '';
				if (preg_match ( '/Couettabra/i', $box->title )) {
					$box_alt = $box->title;
					$box_title = preg_replace ( '/Couettabra/', '', $box->title );
				} else {
					$box_alt = $box->title;
					$box_title = $box->title;
				}
				?>
					
					<?php if($box->link != ''):?>
					<?php
					$target = false;
					if ($box->new_window) {
						$target = ' target="_blank"';
					}
					?>
					<a class="cn-box-link" itemprop="url"
	href="<?php echo $box->link ;?>" <?php echo $target ;?>>
					<?php endif; ?>
					
					<?php
				$box_bg = "background: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $box->image ) . "'); background-repeat: no-repeat; background-position: center center; -webkit-background-size: auto 115%; -moz-background-size: auto 115%; -o-background-size: auto 115%; background-size: auto 115%;";
				
				if (preg_match ( '/(Couettabra|Ensemble)/i', $box->title )) {
					$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
				}
				?>
					
					<?php if(preg_match('/(Couettabra|Ensemble)/i', $box->title)):?>
					<div class="cn-box-std" style="<?php echo $box_bg;?>">
<div class="cn-box-logo-couettabra" style="<?php echo $box_bg_logo;?>">&nbsp;</div>
<h1 class="cn-offleft desktop" itemprop="name"
	style="background: #6ab5cc;"><?php echo $box_alt;?></h1>
</div>
					<?php else:?>
					<div class="cn-box-std" style="<?php echo $box_bg;?>">
<div class="cn-box-logo-couettabra">&nbsp;</div>
<h1 class="cn-offleft desktop" itemprop="name"
	style="background: #6ab5cc;"><?php echo $box_alt;?></h1>
</div>
					<?php endif;?>
					<?php if($box->link != ''):?>
					</a>
					<?php endif;?>
					<div class="cn-box-title-logo">
<div class="cn-box-title-color-std" itemprop="alternateName"><?php echo ucwords($box_title);?></div>
</div>

</div>

</div>

<br />
<br />
			
			<?php endif;?>
		
		<?php endforeach;?>
			
		<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->config->item('category_style_couettabra2') && $this->data['category']->name == 'Couettabra'): ?>
		
		<div class="row">
<div class="span3">
<div class="desktop">
				
					<?php if($this->session->userdata('page_count') % 2 == 0):?>
					<script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Text & Display - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="8553843422" data-ad-format="auto"></ins> <script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					<?php else:?>
					<a href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_250x250.gif"
	width="270" height="250" border="0" /></a>
					<?php endif;?>
					
				</div>
</div>
</div>
		
		<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'product' && preg_match('/kit/', current_url()) ): ?>
		
		<div class="row">
<div class="span3">
<div class="desktop">
				
					<?php if($this->session->userdata('page_count') % 2 == 0):?>
					<script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Text & Display - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="8553843422" data-ad-format="auto"></ins> <script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					<?php else:?>
					<a href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_250x250.gif"
	width="270" height="250" border="0" /></a>
					<?php endif;?>
					
				</div>
</div>
</div>
		
		<?php elseif( $this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'page' && preg_match('/(des-questions|any-questions)/i', uri_string()) ):?>
		
		<div class="row">
<div class="span3">
<div class="desktop">
				
					<?php if($this->session->userdata('page_count') % 2 == 0):?>
					<script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Text & Display - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="8553843422" data-ad-format="auto"></ins> <script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					<?php else:?>
					<a href="https://www.1and1.fr/?kwk=214056621" target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_250x250.gif"
	width="270" height="250" border="0" /></a>
					<?php endif;?>
					
				</div>
</div>
</div>
		
		<?php elseif($this->router->fetch_class() == 'cart' && $this->router->fetch_method() == 'category' && $this->config->item('category_style_housses') && ($this->data['category']->name == 'Housses' || $this->data['category']->name == 'Duvet Covers')): ?>
		
		<div class="row">
<div class="span3">
<div class="desktop">

<div class="fb-like-box"
	data-href="https://www.facebook.com/pages/Couettabra-Claire-Nathalie/125326350915703"
	data-height="270" data-colorscheme="light" data-show-faces="true"
	data-header="false" data-stream="true" data-show-border="true"></div>

</div>
</div>
</div>

<br />
<br />

<div class="row">
<div class="span3">
<div class="desktop">

<div class="fb-activity" data-app-id="<?=$fb_appId;?>"
	data-site="http://clairetnathalie.com"
	data-action="likes, recommends, reviews" data-height="180"
	data-colorscheme="light" data-header="false"
	data-ref="fb-activity-feed-<?=$fb_appId;?>"></div>

</div>
</div>
</div>

<br />
<br />

<div class="row">
<div class="span3">
<div class="desktop"><script async
	src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CN - Responsive - Text & Display - 1 --> <ins class="adsbygoogle"
	style="display: block" data-ad-client="ca-pub-9537579192121159"
	data-ad-slot="8553843422" data-ad-format="auto"></ins> <script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script></div>
</div>
</div>


<br />
<br />

<div class="row">
<div class="span3">
<div class="desktop"><a href="https://www.1and1.fr/?kwk=214056621"
	target="_blank"><img
	src="http://imagesrv.adition.com/banners/268/xml/1und1am/FR_WM/WH/fr_wh_an_250x250.gif"
	width="270" height="250" border="0" /></a></div>
</div>
</div>
		
		<?php endif;?>
		
	</div>
