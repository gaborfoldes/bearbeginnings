<?php

?>
<div class="wrap">
	<h2>WikiPress Uninstaller</h2>
	<div class="narrow">
		<?php
		if( isset( $_POST[ 'uninstall_one' ] ) ) {
			?>
			<p>Are you <strong>absolutely sure</strong> that you want to uninstall the WikiPress plugin?  All
			of your WikiBoards (active & archived) will be erased  <strong>and non-retrievable!</strong> Further, you won't be able to use WikiPress until you deactivate and then reactivate the plugin.</p>
			<form method="post" action="<?php $this->friendly_page_link( 'top_level' ); ?>">
				<p class="submit">
					<input type="submit" name="uninstall_wikipress_complete" value="Just Uninstall It Already!" />
				</p>
			</form>
			<?php			
		} else {
		?>
		<p>To completely uninstall the WikiPress plugin.  Please click the following button.  All data will be erased.</p>
		<form method="post" action="<?php $this->friendly_page_link( 'uninstall' ); ?>">
				<p class="submit">
					<input type="submit" name="uninstall_one" value="Uninstall" />
				</p>
			</form>
		<?php
		}
		?>
	</div>
</div>