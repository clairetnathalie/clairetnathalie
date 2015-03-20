
</div>

</div>

</div>

<?php if($this->router->fetch_class() == 'cart' && $this->router->fetch_method() != 'category'):?>
	<?php include('social.php'); ?>
<?php else:?>
	<?php if(count($products) > 0): ?>
		<?php include('social.php'); ?>
	<?php endif;?>
<?php endif;?>

<?php include('footer.php'); ?>