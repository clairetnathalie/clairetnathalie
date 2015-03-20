<?php include('header.php'); ?>

<div id="carousel-spacer" class="row">
<div class="span12">
<div id="myCarousel" class="carousel slide"><!-- Carousel items --> <img
	class="carousel-top-left-img"
	src="<?=theme_img('icons/cn_corner-carousel-top-left.png');?>"
	rel="noindex" /> <img class="carousel-bottom-right-img"
	src="<?=theme_img('icons/cn_corner-carousel-bottom-right.png');?>"
	rel="noindex" />
<div class="carousel-inner">
					<?php
					$active_banner = 'active ';
					foreach ( $banners as $banner ) :
						?>
						<div class="<?php echo $active_banner;?>item">
<div style="position: relative; height: 100%; witdh: 100%;" itemscope
	itemtype="http://schema.org/ImageObject">
							<?php if($banner->link): ?>
								<?php
							$target = false;
							if ($banner->new_window) {
								$target = ' target="_blank"';
							}
							?>
								<a href="<?php echo $banner->link;?>" <?php echo $target;?>
	style="height: 100%; witdh: 100%;">
							<?php endif;?>
								
								<?php if(!$this->session->userdata('mobile_user')):?>
								
								<?php if($banner->description != ''):?>
								
								<div class="banner-overlays">
								
								<?php if($this->agent->is_robot()):?>
								<?php if($banner->template == 1 && $banner->title == 'slide-couettabra-kit-2-places'): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/d051a35c2f7978477f12c10ca154500b.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 1 && $banner->title == 'slide-couettabra-kit-1-place'): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/f720b0ddf58b08eedbb1d75bdfa768ee.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 2): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/e69775f03244b839c4ab8f05b7f6e5bf.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 3): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/801dbbe7ec21cdb3a44e63f81738d1bf.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 4): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/f875e68d5aaea4da095c18d82aeba102.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 5): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/56c0474dd71983bfeac292010fd71cff.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 6): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/56b9e1aec9fc261fcf25e7301c3178f9.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php elseif($banner->template == 7): ?>
								<div rel="noindex" style="<?php echo "position: absolute; height: 100%; width: 100%; background: url('".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/5b19688c94113f01ba566ca08cafac4c.png'); background-repeat: no-repeat; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;";?>">&nbsp;</div>
								<?php endif;?>
								<?php endif;?>
								
								<div
	style="position: absolute; top: 1%; left: 6%; height: 98%; width: 88%; z-index: 2;">
								
									<?php if($banner->template == 1): ?>
									<div
	style="position: absolute; top: 52%; right: 0%; height: 48%;">
<div style="position: absolute; top: 0%; right: 0%;">
<div style="height: 4vw;">
<h1 class="slider-main-title-reset"
	style="font-size: 6.5vw; font-weight: 600; color: #fff; font-style: normal;"
	itemprop="name">couettabra<span
	style="position: absolute; margin-top: -1vw; font-size: 1.2vw; font-weight: 300;">&#174;</span></h1>
</div>
<div class="slide-1-descript-holder"
	style="float: right; height: 4vw; vertical-align: top;">
<h3 class="slide-1-descript-txt"
	style="font-size: 1.5vw; line-height: 1.5vw; font-weight: 300; color: #fff;"
	itemprop="description"><?php echo $banner->description;?></h3>
</div>
</div>
</div>
									<?php elseif($banner->template == 2): ?>
									<div
	style="position: absolute; top: 25%; left: 50%; height: 75%; width: 50%;">
<div style="position: relative; width: 100%;"><img
	style="height: auto; width: 98%;"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/logo/MGM002_logo-coeur_1002x180px.png'); ?>" />
<div
	style="position: absolute; top: 78%; left: 49%; width: 50%; text-align: center;">
<h2 class="slider-main-title-reset"
	style="font-size: 1.1vw; line-height: 1.12vw; font-weight: 300; color: #e64d56; font-style: normal;"
	itemprop="name"><?php echo lang('creators_of_cuddle_therapy'); ?></h2>
</div>
</div>
<div style="position: relative; width: 100%;">
<div style="position: relative; padding-top: 5%; left: 1%;">
<h3
	style="font-size: 2vw; line-height: 3.5vw; font-weight: 300; color: #fff;"
	itemprop="description"><?php echo $banner->description;?></h3>
</div>
</div>
</div>
									<?php else: ?>
									<div style="position: relative; top: 20%; height: 80%;">
<div class="slide-3" itemprop="description">
											<?php echo $banner->description;?>
										</div>
</div>
									<?php endif;?>
								</div>
								
								<?php if($this->agent->is_browser()):?>
								<?php if($banner->template == 1 && $banner->title == 'slide-couettabra-kit-2-places'): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/d051a35c2f7978477f12c10ca154500b.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 1 && $banner->title == 'slide-couettabra-kit-1-place'): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/f720b0ddf58b08eedbb1d75bdfa768ee.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 2): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/e69775f03244b839c4ab8f05b7f6e5bf.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 3): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/801dbbe7ec21cdb3a44e63f81738d1bf.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 4): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/f875e68d5aaea4da095c18d82aeba102.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 5): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/56c0474dd71983bfeac292010fd71cff.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 6): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/56b9e1aec9fc261fcf25e7301c3178f9.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php elseif($banner->template == 7): ?>
								<img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER)."/images/full/5b19688c94113f01ba566ca08cafac4c.png";?>"
	style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" />
								<?php endif;?>
								<?php endif;?>
								
								</div>
								
								<?php endif;?>
								
								<?php endif;?>
								
								<?php if($banner->image != ''): ?>
								<div><img
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').IMG_UPLOAD_FOLDER.'images/full/'.$banner->image);?>"
	alt="<?php echo $banner->alt_text;?>"
	style="width: 100%; height: auto; margin: 0; padding: 0;"
	itemprop="contentURL" /></div>
								<?php else: ?>
								<div><img rel="noindex"
	src="<?php echo base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/blank_slide.png');?>"
	style="width: 100%; height: auto; margin: 0; padding: 0;" /></div>
								<?php endif;?>
								
							<?php if($banner->link): ?>
								</a>
							<?php endif;?>
							</div>
</div>
					<?php
						$active_banner = false;
					endforeach
					;
					?>
				</div>
<!-- Carousel nav --> <a class="carousel-control left" href="#myCarousel" data-slide="prev" style="background-image: url('<?=theme_img('icons/cn_fleche-slider_40x40px G.png');?>');"></a>
<a class="carousel-control right" href="#myCarousel" data-slide="next" style="background-image: url('<?=theme_img('icons/cn_fleche-slider_40x40px D.png');?>');"></a>
</div>
</div>
</div>

<script type="text/javascript">
		$script.ready(['bootstrap_js_0'], function() {
			$(document).ready(function(){

				$('.carousel').carousel({
				  interval: 5000
				});
				
			});
		});
	</script>

<div class="row">
	<?php $count_boxes = 0;?>
		
	<?php foreach($boxes as $box):?>
		
	<?php if(($count_boxes)%4 == 0 && $count_boxes != 0):?>
	<?php echo "</div>";?>
	<?php echo '<br class="desktop" />';?>
	<?php echo '<div class="row">';?>
	<?php endif;?>
		
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
		$box_bg = "background: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $box->image ) . "'); background-repeat: no-repeat; -webkit-background-size: 100% 80%; -moz-background-size: 100% 80%; -o-background-size: 100% 80%; background-size: 100% 80%;";
		
		if (preg_match ( '/(Couettabra|Ensemble|Housses)/i', $box->title )) {
			$box_bg_logo = "background-image: url('" . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/logo/cn_logo-couettabra.png' ) . "')";
		}
		?>
			
			<?php if(preg_match('/(Couettabra|Ensemble|Housses)/i', $box->title)):?>
			<div class="cn-box-std" style="<?php echo $box_bg;?>">
<h2 class="cn-offleft desktop" itemprop="name"><?php echo $box_alt;?></h2>
<div class="cn-box-logo-couettabra" style="<?php echo $box_bg_logo;?>">&nbsp;</div>
</div>
			<?php else:?>
			<div class="cn-box-std" style="<?php echo $box_bg;?>">
<h2 class="cn-offleft desktop" itemprop="name"><?php echo $box_alt;?></h2>
<div class="cn-box-logo-couettabra">&nbsp;</div>
</div>
			<?php endif;?>
			<?php if($box->link != ''):?>
			</a>
			<?php endif;?>
			<div class="cn-box-title-logo">
<div class="cn-box-title-color-std" itemprop="alternateName"><?php echo ucwords($box_title);?></div>
</div>

</div>
		
		<?php $count_boxes++;?>
        
		<?php endforeach;?>
	</div>

<?php include('social.php'); ?>

<?php include('footer.php'); ?>