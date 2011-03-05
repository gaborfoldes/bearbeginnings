<?php
if( isset( $_POST[ 'delete_wikis' ] ) ) {
	$this->delete_wikis( $_POST[ 'wiki_cb' ] );
}

if( isset( $_POST[ 'submit_wiki' ] ) ) {
	
	$errors = $this->validate_wiki( $_POST );
	
	if( empty( $errors ) ) {
	
		if( isset( $_POST[ 'wiki_id' ] ) ) {
			// Edit existing
			$results = $this->edit_wiki( $_POST[ 'wiki_id' ], $_POST[ 'wiki_name' ],  $_POST[ 'wiki_body' ] );
			
			if( $results === FALSE ) {
				?>
				<div id="message" class="error">
					<p>There were unexpected errors during the update.  Your changes may not have been saved.</p>
				</div>	
				<?php				
			} else { 
				?>
				<div id="message" class="updated fade">
					<p>Your wiki "<?php echo stripslashes( $_POST[ 'wiki_name' ] ); ?>" has been updated.</p>
				</div>	
				<?php
			}
			
		} else {
			// Add new
			$results = $this->add_wiki( $_POST[ 'wiki_name' ],  $_POST[ 'wiki_body' ] );
			
			if( $results === FALSE ) {
				?>
				<div id="message" class="error">
					<p>There were unexpected errors during the add.  Your changes may not have been saved.</p>
				</div>	
				<?php	
			} else { 
				?>
				<div id="message" class="updated fade">
					<p>Your wiki "<?php echo stripslashes( $_POST[ 'wiki_name' ] ); ?>" has been added.</p>
				</div>	
				<?php
			}
			
		}
	} else {
		// The project is invalid, so let's print the error messages
		?>
		<div id="message" class="error">
			<ul>
		<?php foreach( $errors as $error ) { ?>	
		 		<li><?php echo $error; ?></li>
		<?php } ?>
			</ul>
		</div>
		<?php
		
		$current[ 'wiki_id' ] = $_POST[ 'wiki_id' ];
		$current[ 'wiki_name' ] = $_POST[ 'wiki_name' ];
		$current[ 'wiki_body' ] = $_POST[ 'wiki_body' ];
			
	
	}
}

$current = $this->is_editing_wiki();
if( $current !== FALSE ) {
	?>
<div class="wrap">
	<h2>Edit Your WikiBoard</h2>

	<?php
} else {
?>
<div style="display:none;">
<div class="wrap">
	<form name="wiki-manage" id="wiki-manage" method="post" action="<?php $this->friendly_page_link( 'wikis' ); ?>">
		<h2>WikiBoards (<a href="#addwiki">add new</a>)</h2>
		<div class="tablenav">
			<div class="alignleft">
				<input name="delete_wikis" id="delete_wikis" class="button-secondary delete" type="submit" value="Delete" />
			</div>
			<br class="clear" />
		</div>
		<br class="clear" />
		
		<table class="widefat"> <!-- Start Manage Table -->
			<thead>
				<tr>
					<th class="check-column" scope="col"><input id="selectall" name="selectall" type="checkbox" /></th>
					<th scope="col">Name</th>
				
					<th scope="col">Content</th>
						<th scope="col">Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php $this->wiki_rows(); ?>
			</tbody>
		</table> <!-- End Manage Table -->
		
	</form> <!-- End the manage form -->
	<div class="tablenav">
		<br class="clear" />
	</div>
	<br class="clear" />
	</div>
</div>

<div class="wrap" style="width:85%;background:#fff;padding: 5px 20px;">

<?php
}
?>
<?php if(!isset($_REQUEST['no_body'])){?>
	<form name="addwiki" id="addwiki" method="post" action="<?php $this->friendly_page_link( 'add_wiki_page' ); echo ( $current !== FALSE ? '&action=edit&id=' . $current[ 'wiki_id' ] : '' ); ?>">
<br /><br />	
<strong>Give Your WikiBoard a Name</strong><br /><br />
<input id="wiki_name" name="wiki_name" type="text" size="30" style="width:97%;" value="<?php echo $current[ 'wiki_name']; ?>" /><br />
<div style="height:1px;width:97%;border-bottom:1px solid #cacaca;margin-top:3px;margin-bottom:10px;"></div>	<input type="hidden" id="wiki_body" value="" /><input type="hidden" id="no_body" name="no_body" value="true" />
<?php } 

else if($_REQUEST['no_body'] == 'true'){ ?>
<br />	<form name="addwiki" id="addwiki" method="post" action="<?php echo echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=wikipress">
<h1><?php echo $_REQUEST[ 'wiki_name']; ?></h1>
	<textarea name="wiki_body" id="wiki_body" style="width:97%;height:800px" cols="50" rows="7"><?php echo $current[ 'wiki_body']; ?></textarea><br />
					<input type="hidden" id="wiki_name" name="wiki_name" value="<?php echo $_REQUEST['wiki_name']; ?>" />
			
		<?php
		
	} 
		
	
		if( $current !== FALSE ) {
			?>
			<input type="hidden" name="wiki_id" id="wiki_id"  value="<?php echo $current[ 'wiki_id' ]; ?>" />
			<p class="submit">
				<input name="submit_wiki" id="submit_wiki" class="button" type="submit" value="Edit Wiki" />
			</p>
			<?php
		} else {
		?>
	<?php if(!isset($_REQUEST['no_body'])){?>
		<p class="submit">
			<input name="submit_wiki" id="submit_wiki" class="button" type="submit" value="Create a New Wikiboard" /> or <a href="<?php echo echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=wikipress" class="cancel">cancel</a>
		</p>
		
		<?php } 
		
		elseif ($_REQUEST['no_body'] == 'true'){ ?>
			
				<p class="submit">
					<input name="submit_wiki" id="submit_wiki" class="button" type="submit" value="Save This Wikiboard" /> 
				</p>
			
		
		<?php }
		} ?>
	</form>

</div>