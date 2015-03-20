<?php include('header.php'); ?>

<?php echo theme_js('jquery.carousel.fullscreen.js', true) . "\n\r";?>
<?php echo theme_js('Lettering.js-master/jquery.lettering.js', true) . "\n\r";?>
<?php echo theme_js('jquery.transit-master/jquery.transit.js', true) . "\n\r";?>

<?php if($this->session->userdata('mobile_user') == true):?>
	<?php if($this->session->userdata('mobile_user_type') == 'apple'):?>
		<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone')):?>
			<?php echo theme_css('styles_homepage_plein_ecran_mobile.css', true) . "\n\r";?>
		<?php elseif(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')):?>
			<?php echo theme_css('styles_homepage_plein_ecran_ipad.css', true) . "\n\r";?>
		<?php endif;?>
	<?php else: ?>
		<?php echo theme_css('styles_homepage_plein_ecran.css', true) . "\n\r";?>
	<?php endif;?>
<?php else: ?>
		<?php echo theme_css('styles_homepage_plein_ecran.css', true) . "\n\r";?>
<?php endif;?>

<script
	src="//use.edgefonts.net/sarina;acme:n4;lobster;sonsie-one;lobster-two.js"></script>
<script type="text/javascript">
$(window).ready(function(){
	if ( document.body.style[ '-webkit-mask-repeat' ] !== undefined ) {
		
	}
	else {
		$('.banniere-product-style-kit-2-places.bottom').addClass('no-cssmasks');
		$('.banniere-product-style-kit-1-place.bottom').addClass('no-cssmasks');
		$('.banniere-product-style-souscrire-au-newsletter.bottom').addClass('no-cssmasks');
		$('.banniere-product-style-carte-cadeau.bottom').addClass('no-cssmasks');
	}
	
	$(".top3").lettering();
	$(".bottom3").lettering();

	var coeff_transf_1 = 0;
	$('.top3 > span').each(function() {
		$(this).css("transform","rotate(" + coeff_transf_1*7 + "deg)");
		coeff_transf_1 ++;
	});

	var coeff_transf_2 = -90;
	var coeff_transf_3 = 0;
	$('.bottom3 > span').each(function() {
		$(this).css({ transformOrigin: 'center center' });
		//$(this).css({ translate: [(coeff_transf_2*0)+'%',(coeff_transf_2*2.5)+'%'] });
		$(this).css({ rotate: coeff_transf_2*7 +'deg' });
		$(this).css({ translate: ['0%',(91 + (coeff_transf_3 * (0.275))) + '%'] });
		//$(this).css({ translate: ['0%','92%'] });
		
		coeff_transf_2 --;
		coeff_transf_3 ++;
	});

});
</script>

<div id="frame-homepage-plein-ecran" class="row">
<div class="span12">
<div id="carousel-homepage-plein-ecran"
	class="carousel slide carousel-fade"><!-- Carousel items -->
<div class="carousel-inner">
					<?php $active_banner = 'active ';?>
					<?php $count_banner = 0;?>
					<?php foreach($banners as $banner):?>
					
					<?php if($count_banner == 4): ?>
					
						<?php if(preg_match('/banniere-couettabra-kit-2-places/i', $banner->title)):?>
						<?php $banner_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$banner->image.')';?>
						<div id="carousel-element-homepage-plein-ecran-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>" class="carousel-element-homepage-plein-ecran item" itemscope itemtype="http://schema.org/Product" style="<?php echo $banner_image;?>" data-anchor-target="#footer-section">
<meta itemprop="image"
	content="<?php echo $this->config->item('upload_url').'images/full/'.$banner->image?>" />
<meta itemprop="brand" content="Couettabra" />
<a href="<?php echo $banner->link;?>">
<div class="carousel-bg-element"
	id="carousel-bg-element-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"></div>
<div
	id="banniere-product-info-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	class="banniere-product-info">
<div
	id="banniere-product-section-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	data-anchor-target="#footer-section">
<div class="banniere-product-title"><a
	href="<?php echo $banner->link;?>">
<p class="banniere-product-style-kit-2-places top wrapword"
	itemprop="name"><?php echo ucwords(strtolower(preg_replace('/-/', ' ', preg_replace('/banniere-/', '',  $banner->title))));?></p>
<p class="banniere-product-style-kit-2-places bottom wrapword wipe"><?php echo ucwords(strtolower(preg_replace('/-/', ' ', preg_replace('/banniere-/', '',  $banner->title))));?></p>
</a></div>

<div class="well well-small"
	style="margin-left: auto; margin-right: auto; text-align: center; max-width: 200px;">
<a class="btn btn-large btn-primary" style="margin-top: 5px;"
	href="<?php echo $banner->link;?>"><?php echo lang('inspect_this_product');?></a>
<div class="banniere-product-price" style="margin-bottom: -10px;"
	itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span
	class="price-reg"><?php echo lang('product_price');?> <span
	itemprop="price"><?php echo format_currency('299'); ?></span></span>
<meta itemprop="priceCurrency"
	content="<?php echo $this->session->userdata('currency');?>" />
<meta itemprop="url"
	content="<?php echo 'http://clairetnathalie.com'.$banner->link;?>" />
<meta itemprop="sameAs" content="http://www.couettabra.com" />
<meta itemprop="seller" content="Maison Gueneau Mauger" />
</div>
</div>
</div>
</div>
</a></div>
						
						<?php elseif(preg_match('/banniere-couettabra-kit-1-place/i', $banner->title)):?>
						<?php $banner_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$banner->image.')';?>
						<div class="carousel-element-homepage-plein-ecran item" itemscope
	itemtype="http://schema.org/Product">
<meta itemprop="image"
	content="<?php echo $this->config->item('upload_url').'images/full/'.$banner->image?>" />
<meta itemprop="brand" content="Couettabra" />
<a href="<?php echo $banner->link;?>">
<div class="circle" id="circle4"></div>
<div class="circle" id="circle3"></div>
<div class="circle" id="circle2"></div>
<div class="carousel-bg-element" id="carousel-bg-element-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>" style="<?php echo $banner_image;?>"></div>
<div
	id="banniere-product-info-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	class="banniere-product-info">
<div
	id="banniere-product-section-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	data-anchor-target="#footer-section">
<div class="banniere-product-title"><a
	href="<?php echo $banner->link;?>">
<p class="banniere-product-style-kit-1-place top wrapword"
	itemprop="name"><?php echo ucwords(strtolower(preg_replace('/-/', ' ', preg_replace('/banniere-/', '',  $banner->title))));?></p>
<p class="banniere-product-style-kit-1-place bottom wrapword wipe"><?php echo ucwords(strtolower(preg_replace('/-/', ' ', preg_replace('/banniere-/', '',  $banner->title))));?></p>
</a></div>
<div class="well well-small"
	style="margin-left: auto; margin-right: auto; text-align: center; max-width: 200px;">
<a class="btn btn-large btn-primary" style="margin-top: 5px;"
	href="<?php echo $banner->link;?>"><?php echo lang('inspect_this_product');?></a>
<div class="banniere-product-price" style="margin-bottom: -10px;"
	itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span
	class="price-reg"><?php echo lang('product_price');?> <span
	itemprop="price"><?php echo format_currency('199'); ?></span></span>
<meta itemprop="priceCurrency"
	content="<?php echo $this->session->userdata('currency');?>" />
<meta itemprop="url"
	content="<?php echo 'http://clairetnathalie.com'.$banner->link;?>" />
<meta itemprop="sameAs" content="http://www.couettabra.com" />
<meta itemprop="seller" content="Maison Gueneau Mauger" />
</div>
</div>
</div>
</div>
</a></div>
						
						<?php elseif(preg_match('/banniere-carte-cadeau/i', $banner->title)):?>
						<?php $banner_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$banner->image.')';?>
						<div
	id="carousel-element-homepage-plein-ecran-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	class="carousel-element-homepage-plein-ecran item"><a
	href="<?php echo $banner->link;?>">
<div class="carousel-bg-element" id="carousel-bg-element-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>" style="<?php echo $banner_image;?>"></div>
<!-- 
								<div class="circle" id="logo-circle4"></div>
								<div class="circle" id="logo-circle3"></div>
								<div class="circle" id="logo-circle2"></div>
								-->
<div class="x0">
<div class="x1">
<div class="x2">
<h3 class="top3">Maison Gueneau Mauger</h3>
<div class="x3">
<div class="x4" style="<?php echo "background-image:url(".base_url((!preg_match('/localhost/', current_url())?'':'clairetnathalie/').CONTENT_FOLDER.'default/assets/img/logo/mgm_logo_3.png'.");");?>">
</div>
</div>
<div class="x3sub">
<div class="bottom3">Depuis 2012</div>
</div>
</div>
</div>
</div>
<div class="banniere-product-title"><a
	href="<?php echo $banner->link; ?>">
<p class="banniere-product-style-carte-cadeau top wrapword"><?php echo lang('give_a_gift_to_someone');?></p>
<p class="banniere-product-style-carte-cadeau bottom wrapword wipe"><?php echo lang('give_a_gift_to_someone');?></p>
</a></div>

<div
	id="banniere-product-info-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	class="banniere-product-info">
<div
	id="banniere-product-section-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	data-anchor-target="#footer-section">
<div class="well well-small"
	style="margin-left: auto; margin-right: auto; text-align: center; max-width: 200px;">
<a class="btn btn-large btn-primary"
	style="margin-top: 5px; margin-bottom: 5px;"
	href="<?php echo $banner->link;?>"><?php echo lang('make_a_gift');?></a>
</div>
</div>
</div>
</a></div>
						
						<?php elseif(preg_match('/banniere-souscrire-au-newsletter/i', $banner->title)):?>
						<?php $banner_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$banner->image.')';?>
						<div class="carousel-element-homepage-plein-ecran item">
<div class="carousel-bg-element" id="carousel-bg-element-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>" style="<?php echo $banner_image;?>"></div>
<div
	id="banniere-product-info-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	class="banniere-product-info">
<div
	id="banniere-product-section-<?php echo strtolower(preg_replace('/banniere-/', '',  $banner->title));?>"
	data-anchor-target="#footer-section">
<div class="banniere-product-title">

<p class="banniere-product-style-souscrire-au-newsletter top wrapword"><?php echo lang('subscribe_to_newsletter');?></p>
<p
	class="banniere-product-style-souscrire-au-newsletter bottom wrapword wipe"><?php echo lang('subscribe_to_newsletter');?></p>

</div>
<div class="envelope"
	style="margin-left: auto; margin-right: auto; text-align: center; max-width: 320px;">
<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup" class="envelope-bg"><formaction
	="http://maison-gueneau-mauger.us7.list-manage.com/subscribe/post?u=b49def70967c935ba6cbfb2ce&amp;id=b7df4688ad
	" method="post" id="mc-embedded-subscribe-form"
	name="mc-embedded-subscribe-form" class="validate form-horizontal"
	target="_blank" novalidate>
<div class="control-group mc-field-group"><label class="control-label"
	for="mce-EMAIL"><?php echo lang('signup_email');?></label>
<div class="controls"><input type="email" name="EMAIL"
	class="required email" id="mce-EMAIL" placeholder=""></div>
</div>
<div class="control-group mc-field-group"><label class="control-label"
	for="mce-LNAME"><?php echo lang('signup_lastname');?></label>
<div class="controls"><input type="text" name="LNAME" class="required"
	id="mce-LNAME" placeholder=""></div>
</div>
<div class="control-group mc-field-group"><label class="control-label"
	for="mce-FNAME"><?php echo lang('signup_firstname');?></label>
<div class="controls"><input type="text" name="FNAME" class="required"
	id="mce-FNAME" placeholder=""></div>
</div>
<div id="mce-responses" class="clear">
<div class="response" id="mce-error-response" style="display: none"></div>
<div class="response" id="mce-success-response" style="display: none"></div>
</div>
<div class="clear"><input type="submit"
	value="<?php echo lang('signup_button');?>" name="subscribe"
	id="mc-embedded-subscribe" class="btn btn-large btn-primary"></div>
</form>
</div>

<script type="text/javascript">
											var fnames = new Array();var ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='PREF_LANG';ftypes[3]='text';
											try {
											    var jqueryLoaded=jQuery;
											    jqueryLoaded=true;
											} catch(err) {
											    var jqueryLoaded=false;
											}
											var head= document.getElementsByTagName('head')[0];
											if (!jqueryLoaded) {
											    var script = document.createElement('script');
											    script.type = 'text/javascript';
											    script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';
											    head.appendChild(script);
											    if (script.readyState && script.onload!==null){
											        script.onreadystatechange= function () {
											              if (this.readyState == 'complete') mce_preload_check();
											        }    
											    }
											}
											var script = document.createElement('script');
											script.type = 'text/javascript';
											script.src = 'http://downloads.mailchimp.com/js/jquery.form-n-validate.js';
											head.appendChild(script);
											var err_style = '';
											try{
											    err_style = mc_custom_error_style;
											} catch(e){
											    err_style = '#mc_embed_signup input.mce_inline_error{border-color:#6B0505;} #mc_embed_signup div.mce_inline_error{margin: 0 0 1em 0; padding: 5px 10px; background-color:#6B0505; font-weight: bold; z-index: 1; color:#fff;}';
											}
											var head= document.getElementsByTagName('head')[0];
											var style= document.createElement('style');
											style.type= 'text/css';
											if (style.styleSheet) {
											  style.styleSheet.cssText = err_style;
											} else {
											  style.appendChild(document.createTextNode(err_style));
											}
											head.appendChild(style);
											setTimeout('mce_preload_check();', 250);

											var mce_preload_checks = 0;
											function mce_preload_check(){
											    if (mce_preload_checks>40) return;
											    mce_preload_checks++;
											    try {
											        var jqueryLoaded=jQuery;
											    } catch(err) {
											        setTimeout('mce_preload_check();', 250);
											        return;
											    }
											    try {
											        var validatorLoaded=jQuery("#fake-form").validate({});
											    } catch(err) {
											        setTimeout('mce_preload_check();', 250);
											        return;
											    }
											    mce_init_form();
											}
											function mce_init_form(){
											    jQuery(document).ready( function($) {
											      var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
											      var mce_validator = $("#mc-embedded-subscribe-form").validate(options);
											      $("#mc-embedded-subscribe-form").unbind('submit');//remove the validator so we can get into beforeSubmit on the ajaxform, which then calls the validator
											      options = { url: 'http://maison-gueneau-mauger.us7.list-manage.com/subscribe/post-json?u=b49def70967c935ba6cbfb2ce&id=b7df4688ad&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
											                    beforeSubmit: function(){
											                        $('#mce_tmp_error_msg').remove();
											                        $('.datefield','#mc_embed_signup').each(
											                            function(){
											                                var txt = 'filled';
											                                var fields = new Array();
											                                var i = 0;
											                                $(':text', this).each(
											                                    function(){
											                                        fields[i] = this;
											                                        i++;
											                                    });
											                                $(':hidden', this).each(
											                                    function(){
											                                        var bday = false;
											                                        if (fields.length == 2){
											                                            bday = true;
											                                            fields[2] = {'value':1970};//trick birthdays into having years
											                                        }
											                                    	if ( fields[0].value=='MM' && fields[1].value=='DD' && (fields[2].value=='YYYY' || (bday && fields[2].value==1970) ) ){
											                                    		this.value = '';
																				    } else if ( fields[0].value=='' && fields[1].value=='' && (fields[2].value=='' || (bday && fields[2].value==1970) ) ){
											                                    		this.value = '';
																				    } else {
																				        if (/\[day\]/.test(fields[0].name)){
											    	                                        this.value = fields[1].value+'/'+fields[0].value+'/'+fields[2].value;									        
																				        } else {
											    	                                        this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
												                                        }
												                                    }
											                                    });
											                            });
											                        return mce_validator.form();
											                    }, 
											                    success: mce_success_cb
											                };
											      $('#mc-embedded-subscribe-form').ajaxForm(options);
											      
											      
											    });
											}
											function mce_success_cb(resp){
											    $('#mce-success-response').hide();
											    $('#mce-error-response').hide();
											    if (resp.result=="success"){
											        $('#mce-'+resp.result+'-response').show();
											        $('#mce-'+resp.result+'-response').html(resp.msg);
											        $('#mc-embedded-subscribe-form').each(function(){
											            this.reset();
											    	});
											    } else {
											        var index = -1;
											        var msg;
											        try {
											            var parts = resp.msg.split(' - ',2);
											            if (parts[1]==undefined){
											                msg = resp.msg;
											            } else {
											                i = parseInt(parts[0]);
											                if (i.toString() == parts[0]){
											                    index = parts[0];
											                    msg = parts[1];
											                } else {
											                    index = -1;
											                    msg = resp.msg;
											                }
											            }
											        } catch(e){
											            index = -1;
											            msg = resp.msg;
											        }
											        try{
											            if (index== -1){
											                $('#mce-'+resp.result+'-response').show();
											                $('#mce-'+resp.result+'-response').html(msg);            
											            } else {
											                err_id = 'mce_tmp_error_msg';
											                html = '<div id="'+err_id+'" style="'+err_style+'"> '+msg+'</div>';
											                
											                var input_id = '#mc_embed_signup';
											                var f = $(input_id);
											                if (ftypes[index]=='address'){
											                    input_id = '#mce-'+fnames[index]+'-addr1';
											                    f = $(input_id).parent().parent().get(0);
											                } else if (ftypes[index]=='date'){
											                    input_id = '#mce-'+fnames[index]+'-month';
											                    f = $(input_id).parent().parent().get(0);
											                } else {
											                    input_id = '#mce-'+fnames[index];
											                    f = $().parent(input_id).get(0);
											                }
											                if (f){
											                    $(f).append(html);
											                    $(input_id).focus();
											                } else {
											                    $('#mce-'+resp.result+'-response').show();
											                    $('#mce-'+resp.result+'-response').html(msg);
											                }
											            }
											        } catch(e){
											            $('#mce-'+resp.result+'-response').show();
											            $('#mce-'+resp.result+'-response').html(msg);
											        }
											    }
											}
										</script> <!--End mc_embed_signup-->

<div class="back">
<div class="t"></div>
<div class="r"></div>
<div class="b"></div>
<div class="l"></div>
<div class="tl"></div>
<div class="tr"></div>
<div class="br"></div>
<div class="bl"></div>
</div>

</div>
</div>
</div>
</div>
						<?php else:?>
						<?php $banner_image = 'background-image:url('.$this->config->item('upload_url').'images/full/'.$banner->image.')';?>
						<div
	class="carousel-element-homepage-plein-ecran <?php echo $active_banner;?>item"
	style="opacity: 1;">
<div class="carousel-bg-element" id="carousel-bg-element-<?php echo preg_replace('/ /', '-',  strtolower($banner->title));?>" style="opacity: 1;<?php echo $banner_image;?>"></div>
<a href="<?php echo $banner->link;?>">
<div
	id="banniere-product-info-<?php echo preg_replace('/ /', '-',  strtolower($banner->title));?>"
	class="banniere-product-info" data-anchor-target="#footer-section">
<div
	id="banniere-product-section-<?php echo preg_replace('/ /', '-',  strtolower($banner->title));?>"
	class="banniere-product-section" data-anchor-target="#footer-section">
<div class="banniere-product-title"><!-- 
											<span><?php echo $banner->title;?></span>
											 --></div>
</div>
</div>
</a></div>
						<?php endif; ?>
						
					<?php endif; ?>
						
					<?php $active_banner = false;?>
					<?php $count_banner++;?>
					<?php endforeach;?>
				</div>
				
				<?php if($count_banner > 0):?>
				<!-- Carousel nav --> <!-- 
				<a class="carousel-control left" href="#carousel-homepage-plein-ecran" data-slide="prev" style="position:fixed; top: 50%; left: 5%; height: 40px; margin-top: -20px; z-index:3;">&lsaquo;</a>
				<a class="carousel-control right" href="#carousel-homepage-plein-ecran" data-slide="next" style="position:fixed; top: 50%; right: 5%; height: 40px; margin-top: -20px; z-index:3;">&rsaquo;</a>
				-->
				<?php endif;?>
				
			</div>
</div>
</div>

<script type="text/javascript">
	$('.carousel').carousel({
	  interval: 1
	});
	</script>

<div class="row">
	
		<?php foreach($banners as $banner):?>
			<?php if(preg_match('/banniere-couettabra-housse-2-places/i', $banner->title)):?>
				
					<?php foreach($boxes as $box):?>
					<div class="span3">
						<?php
					
					$box_image = '<img class="responsiveImage" src="' . base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $box->image ) . '" />';
					if ($box->link != '') {
						$target = false;
						if ($box->new_window) {
							$target = 'target="_blank"';
						}
						echo '<a href="' . $box->link . '" ' . $target . ' >' . $box_image . '</a>';
					} else {
						echo $box_image;
					}
					?>
					</div>
					<?php endforeach;?>
					
			<?php endif; ?>
		<?php endforeach;?>
		
	</div>


<?php include('footer.php'); ?>