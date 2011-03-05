<?php 

	require_once('class.bbcode.php'); 

	if(isset($_REQUEST['no_archive'])){
		echo "";
	} else {	
		$this->add_archive($_POST['wiki_id'], $_POST['wiki_name'], $_POST['wiki_body'], $_POST['author_id']);
	}
	
	
	$user_id = (int) $user_id;
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$wikiuser = get_user_to_edit($user_id);
	$first = $wikiuser->first_name;
	$last = $wikiuser->last_name;

	function current_author(){
		$user_id = (int) $user_id;
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
	}

	function author_meta($author_id){
		$wikiauthor = get_user_to_edit($author_id);
		$first = $wikiauthor->first_name;
		$last = $wikiauthor->last_name;
		echo $first." ".$last;
	}


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
					<div id="message" class="error"><p>There were unexpected errors during the update.  Your changes may not have been saved.</p></div>	
			<?php
			} else { 
				?>
				<div id="message" class="updated fade"><p>Your wiki "<?php echo stripslashes( $_POST[ 'wiki_name' ] ); ?>" has been updated.</p></div>	
				<?php
				}
			} else {
			// Add new
			$results = $this->add_wiki( $_POST[ 'wiki_name' ],  $_POST[ 'wiki_body' ], $user_id );
		
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



	<?php
} else {
?>

<?php
}
?>


<br>
<div class="wrap">
	<form name="addwiki" id="addwiki" method="post" action="<?php $this->friendly_page_link( 'edit_wiki_page' ); echo ( $current !== FALSE ? '&action=edit&id=' . $current[ 'wiki_id' ] : '' ); ?>">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="674bd168b0" />
		<input type="hidden" name="_wp_http_referer" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/page-new.php" /><input type="hidden" id="user-id" name="user_ID" value="1" />
		<input type="hidden" id="hiddenaction" name="action" value='post' />
		<input type="hidden" id="originalaction" name="originalaction" value="post" />
		<input type="hidden" id="post_author" name="post_author" value="" />
		<input type='hidden' id='post_ID' name='temp_ID' value='-1228969046' /><input type="hidden" id="post_type" name="post_type" value="page" />
		<input type="hidden" id="original_post_status" name="original_post_status" value="draft" />
		<input name="referredby" type="hidden" id="referredby" value="http://www.ethosdigital.com/wp-admin/admin.php?page=wikipress" />

		<div id="poststuff" class="metabox-holder">
			<div id="side-info-column" class="inner-sidebar">
				<h2><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wikipress/assets/images/wikipress-logo.png" style="border:none;background:none;width:150px;display:inline;padding-right:5px;margin-bottom:-7px;" /></h2>
				<div id='side-sortables' class='meta-box-sortables'>
					<div id="pagesubmitdiv" class="postbox " >
						<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class='hndle'><span>About This WikiBoard</span></h3>
						<div class="inside">
							<div class="submitbox" id="submitpage">
								<div id="misc-publishing-actions">
									<div class="misc-pub-section curtime misc-pub-section-last">

	<?php

	foreach( $this->get_wikis() as $wiki ) {
		if( $current['wiki_id'] == $wiki->wiki_id ){
	 		$wiki_birthday = $wiki->wiki_created;
	 		$wiki_king = $wiki->wiki_author;
		}
	}
	
?>					<p style="padding:0 10px;">This WikiBoard was created <strong><em><?php echo date("F jS, Y", strtotime($wiki_birthday));?></em></strong> by <strong><em><?php author_meta($wiki_king); ?>.</em></strong></p><br><a href="/wp-admin/admin.php?page=wikipress">&larr; Back to Dashboard</a>
				</div>
			</div>
			<div class="clear"></div>
			</div>

			<div id="major-publishing-actions">
				<div id="delete-action"></div>
			
				<div id="publishing-action" style="width:100%;text-align:center;">
					<input name="original_publish" type="hidden" id="original_publish" value="Publish" />
					<input name="submit_wiki" type="submit" class="button-primary" id="submit_wiki" tabindex="5" accesskey="p" value="Edit Wiki" />
					<input type="hidden" name="wiki_id" id="wiki_id" value="<?php echo $current[ 'wiki_id' ]; ?>" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>
			

<!-- Archive Box -->
	<div id="pageparentdiv" class="postbox "  style="margin-top:-100px;">
		<div class="handlediv" title="Click to toggle"></div>
			<h3 class='hndle'><span>Recent Archives</span></h3>
			<div class="inside" >
			<table>
				<?php 
				if (isset($current['wiki_id'])){
				$archive_row_wiki_id = $current['wiki_id'];
			} else {
				$archive_row_wiki_id = $_REQUEST['wiki_id'];
			}
				$archives = $this->archive_rows($archive_row_wiki_id); 
			
				$archives;
		
				?>
				</table>
			</div>	
			<div style="clear:both;"></div>
		</div>
	</div>	
</div>
	
<br />

<style type="text/css">
.wikipress{display:block}
.wikipress *{
  display:block;
  height:1px;
  overflow:hidden;
  font-size:.01em;
  background:#FFFFFF}
.wikipress1{
  margin-left:3px;
  margin-right:3px;
  padding-left:1px;
  padding-right:1px;
  border-left:1px solid #f7f7f7;
  border-right:1px solid #f7f7f7;
  background:#fbfbfb}
.wikipress2{
  margin-left:1px;
  margin-right:1px;
  padding-right:1px;
  padding-left:1px;
  border-left:1px solid #f2f2f2;
  border-right:1px solid #f2f2f2;
  background:#fcfcfc}
.wikipress3{
  margin-left:1px;
  margin-right:1px;
  border-left:1px solid #fcfcfc;
  border-right:1px solid #fcfcfc;}
.wikipress4{
  border-left:1px solid #f7f7f7;
  border-right:1px solid #f7f7f7}
.wikipress5{
  border-left:1px solid #fbfbfb;
  border-right:1px solid #fbfbfb}
.wikipressfg{
  background:#FFFFFF}

</style>


<div style="background:#f1f1f1;padding:10px;position:relative;margin-left:0;margin-right:300px;">
	<div>
		<div>
				<b class="wikipress"><b class="wikipress1"><b></b></b><b class="wikipress2"><b></b></b><b class="wikipress3"></b><b class="wikipress4"></b><b class="wikipress5"></b></b>

				<div class="wikipressfg">
					<div id="wikibody" style="width:96%;background:#fff;padding:15px;min-height:850px;margin:0 auto;">
							<h1 style="width:100%; border-bottom:1px solid #cacaca;margin-bottom:20px;margin-top:-5px;padding-bottom:10px;"><?php echo stripslashes($current[ 'wiki_name']); ?></h1>
				
				
				<?php
				$parsed = "";
				$data = stripslashes($current['wiki_body']);
				$parsed .= $data;
				parsing($parsed);
				print($parsed);
				?>
				
				
							</div>				
						</div>
		  				<b class="wikipress"><b class="wikipress5"></b><b class="wikipress4"></b><b class="wikipress3"></b><b class="wikipress2"><b></b></b><b class="wikipress1"><b></b></b></b>
					</div>
				</div>
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
						<div id="postdivrich" class="postarea"></div>
					</div>	
					<div style="clear: both;">&nbsp;</div>
				</div>
			</form>
		</div>
	</div>
</div>