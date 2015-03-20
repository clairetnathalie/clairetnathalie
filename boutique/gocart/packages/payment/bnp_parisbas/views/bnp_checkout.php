<table width="100%" border="0" cellpadding="5">
	<tr>
  	<?php if($this->session->userdata('lang_scope') == 'fr'): ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_fr.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | PAIEMENT SÉCURISÉ | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
  	<?php elseif($this->session->userdata('lang_scope') == 'en'): ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_en.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | SECURE PAYMENT | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
  	<?php elseif($this->session->userdata('lang_scope') == 'de'): ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_ge.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | SICHERE ZAHLUNG | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
  	<?php elseif($this->session->userdata('lang_scope') == 'es'): ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_sp.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | PAGO SEGURO | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
  	<?php elseif($this->session->userdata('lang_scope') == 'it'): ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_it.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | PAGAMENTO SICURO | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
	<?php else: ?>
  	<td><img
			src="http://clairetnathalie.com/content/default/assets/img/mercanet/logo/mercanet716x452_boxed_en.png"
			style="width: 180px; height: 113px;" border="0"
			alt="Acceptance Mark MERCANET ATOS | SECURE PAYMENT | BNP PARISBAS | VISA | CB | MASTERCARD | PAYLIB | AMEX"></td>
	<?php endif;?>
  </tr>
	<tr>
		<td><?php echo lang('bnp_parisbas_desc') ?></td>
	</tr>
</table>
