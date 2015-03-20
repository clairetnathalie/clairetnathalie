<?php include('header.php'); ?>

<div class="row" style="margin-top: 50px;">
<div class="span6 offset3">
<div class="page-header">
<h1><?php echo lang('login');?></h1>
</div>
			<?php echo form_open('secure/login', 'class="form-horizontal"'); ?>
				<fieldset>

<div class="control-group"><label class="control-label" for="email"><?php echo lang('email');?></label>
<div class="controls"><input type="text" name="email" class="span3"
	autocomplete="off" /></div>
</div>

<div class="control-group"><label class="control-label" for="password"><?php echo lang('password');?></label>
<div class="controls"><input type="password" name="password"
	class="span3" autocomplete="off" /></div>
</div>

<div class="control-group"><label class="control-label"></label>
<div class="controls"><label class="checkbox"> <input name="remember"
	value="true" type="checkbox" />
								 <?php echo lang('keep_me_logged_in');?>
							</label></div>
</div>
<div class="control-group"><label class="control-label" for="password"></label>
<div class="controls"><input type="submit"
	value="<?php echo lang('form_login');?>" name="submit"
	class="btn btn-primary" /></div>
</div>
</fieldset>

<input type="hidden" value="<?php echo $redirect; ?>" name="redirect" />
<input type="hidden" value="submitted" name="submitted" />

</form>

<div style="text-align: center;"><a
	href="<?php echo site_url('secure/forgot_password'); ?>"><?php echo lang('forgot_password')?></a>
| <a href="<?php echo site_url('secure/register'); ?>"><?php echo lang('register');?></a>
</div>
</div>

<div class="span6 offset3"><br>
<br>
<legend>
<h4><?php echo lang('login_social');?></h4>
</legend></div>

<div class="span12">
<div class="btn-group">
<div class="btn-holder"><a class="btn btn-social btn-facebook"
	href="<?php echo base_url('/hauth/login/Facebook');?>" rel="nofollow"><strong><i
	class="icon-facebook" alt="Facebook Login" title="Facebook Login"></i>
<small>Facebook</small></strong></a></div>
<!--
			<div class="btn-holder">
				<a class="btn btn-social btn-twitter" href="<?php echo base_url('/hauth/login/Twitter');?>" rel="nofollow"><strong><i class="icon-twitter" alt="Twitter Login" title="Twitter Login"></i> <small>Twitter</small></strong></a>
			</div>
			-->
<div class="btn-holder"><a class="btn btn-social btn-google-plus"
	href="<?php echo base_url('/hauth/login/Google');?>" rel="nofollow"><strong><i
	class="icon-google-plus" alt="Google Login" title="Google Login"></i> <small>Google</small></strong></a>
</div>
<div class="btn-holder"><a class="btn btn-social btn-linkedin"
	href="<?php echo base_url('/hauth/login/LinkedIn');?>" rel="nofollow"><strong><i
	class="icon-linkedin" alt="Linkedin Login" title="Linkedin Login"></i>
<small>Linkedin</small></strong></a></div>
</div>
</div>

</div>
<?php include('footer.php'); ?>