
<div class="row">
<div class="span12" style="text-align: center; padding-top: 20px;">

<div class="span3">&nbsp;</div>
<div class="span6" style="text-align: center;">
<p id="status_connection_fb"
	style="font-size: 12px; letter-spacing: 1px;"></p>
</div>
<div class="span3">&nbsp;</div>

</div>
</div>

<div class="row">
<div class="span12" style="text-align: center; padding-top: 10px;">

<div class="span1">&nbsp;</div>

<form class="form-inline">
<div class="span3"><br class="mobile" />
<div class="fb-like" data-href="<?php echo current_url(); ?>"
	data-send="false" data-layout="button_count" data-width="90"
	data-show-faces="false" data-font="lucida grande" data-share="true"
	data-ref="<?php echo ($this->uri->total_segments() == 0)?$this->uri->segment(0, 'homepage'):preg_replace(array('/(cart\s)/', '/(-|\s)/'), array('', '_'), implode(' ', $this->uri->segment_array())); ?>"
	style="width: 100px; text-align: center; margin: 0 0 0 -50px;"></div>
</div>
<!--
					<div class="span2">
						<a class="twitter-share-button" href="https://twitter.com/share" data-url="<?php echo current_url(); ?>" data-text="<?php echo $this->lang->line("just_looked_at"); ?> <?php echo ($this->uri->total_segments() == 0)?$this->uri->segment(0, 'home'):preg_replace(array('/(cart\s)/', '/(-|_)/'), array('', ' '), implode(' ', $this->uri->segment_array())); ?> <?php echo $this->lang->line("on_the_site"); ?> <?php echo $this->config->item('company_name'); ?>" data-via="Couettabra" data-lang="fr" data-hashtags="linge, maison, innovation, housse, couette, duvet, couverture, cover, blanket" data-counturl="http://<?php echo $this->config->item('domain_name');?>" data-count="none" style="width: 100px; text-align: center; margin: 0 auto;">Tweeter</a>
					</div>
					-->
<div class="span2"><br class="mobile" />
<a class="pinterest-pin"
	href="<?php echo "http://pinterest.com/pin/create/button/?url=" . urlencode(current_url()) . '&media=' . urlencode(theme_img('logo/cn_logo-header_212x45px.png')) . '&description=' . urlencode($this->lang->line("mgm_description")) ; ?>"
	data-pin-do="buttonPin" data-pin-config="beside"
	style="width: 100px; text-align: center; margin: 0 auto;"><img
	src="//assets.pinterest.com/images/pidgets/pin_it_button.png"
	title="Pin It" /></a></div>
<div class="span2"><br class="mobile" />
<!-- 
						<a class="instagram" href="http://instagram.com/claireetnathalie" style="width: 96px; height: 22px; margin: 0 auto;"><img src="<?php echo theme_img('icons/Instagram_button_2.png'); ?>" title="FOLLOW US on INSTAGRAM" style="width: 96px; height: 25px; margin-top: -2px;" /></a>
						-->

<style>
.ig-b- {
	display: inline-block;
	margin-top: -1px;
}

.ig-b- img {
	visibility: hidden;
}

.ig-b-:hover {
	background-position: 0 -50.5px;
}

.ig-b-:active {
	background-position: 0 -101px;
}

.ig-b-v-24 {
	width: 137px;
	height: 24px;
	background: url(<? php 						echo theme_img ( 'icons/ig-badge-view-sprite-24.png' );
						?>) no-repeat 0 0;
	background-size: 137px auto;
}

@media only screen and (-webkit-min-device-pixel-ratio: 2) , only screen and
		(min--moz-device-pixel-ratio: 2) , only screen and
		(-o-min-device-pixel-ratio: 2 / 1) , only screen and
		(min-device-pixel-ratio: 2) , only screen and (min-resolution: 192dpi)
		, only screen and (min-resolution: 2dppx) {
	.ig-b-v-24 {
		background-image: url(<? php 						echo theme_img ( 'icons/ig-badge-view-sprite-24@2x.png' );
						?>);
		background-size: 160px 178px;
	}
}
</style>


<a href="http://instagram.com/claireetnathalie?ref=badge"
	class="ig-b- ig-b-v-24"><img
	src="<?php echo theme_img('icons/ig-badge-view-sprite-24.png'); ?>"
	alt="Instagram" /></a></div>
<div class="span3" id="g-plusone-holder"><br class="mobile" />
<div class="g-plusone" data-size="medium" data-annotation="bubble"
	data-href="<?php echo current_url(); ?>"
	style="width: 90px; text-align: center; margin: 0 auto;"></div>
</div>
<!-- 
					<div class="span2">
						<div class="tumbler-share" id="<?php echo 'tumblr_clairetnathalie_homepage'; ?>" style="width: 100px; text-align: center; margin: 0 auto;">
							<script type="text/javascript">
								$script.ready(['social_js_0'], function() {
									$(document).ready(function(){
										var tumblr_button_<?php echo 'clairetnathalie_homepage'; ?> = document.createElement("a");
							            tumblr_button_<?php echo 'clairetnathalie_homepage'; ?>.setAttribute("href", "http://www.tumblr.com/share/photo?source=" + "<?php echo rawurlencode(theme_img('logo/cn_logo-header_212x45px.png')) ;?>" + "&caption=" + "<?php echo rawurlencode($this->lang->line("mgm_description")) ;?>" + "&click_thru=" + "<?php echo rawurlencode(current_url()) ;?>");
							            tumblr_button_<?php echo 'clairetnathalie_homepage'; ?>.setAttribute("title", "Share on Tumblr");
							            tumblr_button_<?php echo 'clairetnathalie_homepage'; ?>.setAttribute("style", "display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;");
							            tumblr_button_<?php echo 'clairetnathalie_homepage'; ?>.innerHTML = "tumblr";
							            document.getElementById("<?php echo 'tumblr_clairetnathalie_homepage'; ?>").appendChild(tumblr_button_<?php echo 'clairetnathalie_homepage'; ?>);
									});
								});
					        </script>
				        </div>
					</div>
					--></form>

<div class="span1">&nbsp;</div>
</div>
</div>