<div id="contact_form">
	<?=form_open('email/send');?>
	<br/>
	Your Email:<br/>
	<?=form_input('email')?><br/>
	Subject:<br/>
	<?=form_input('subject')?><br/>
	Message:<br/>
	<?=form_textarea('message')?><br/>
	
</div>
<div id="contact_submit"><?=form_submit('submit', 'Submit')?></div><br/>
	<?=form_close()?>