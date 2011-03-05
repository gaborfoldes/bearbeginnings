<?php


$user_id = (int) $user_id;
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$wikiuser = get_user_to_edit($user_id);
$first = $wikiuser->first_name;
$last = $wikiuser->last_name;
?>

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
		<div id="message" class="error" style="display:none;">
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

		
			<form name="addwiki" id="addwiki" method="post" action="<?php $this->friendly_page_link( 'wiki' ); echo ( $current !== FALSE ? '&action=edit&id=' . $current[ 'wiki_id' ] : '' ); ?>">
		
		

		

				<input type="hidden" id="_wpnonce" name="_wpnonce" value="674bd168b0" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/page-new.php" /><input type="hidden" id="user-id" name="user_ID" value="1" />

				<input type="hidden" id="hiddenaction" name="action" value='post' />
				<input type="hidden" id="originalaction" name="originalaction" value="post" />
				<input type="hidden" id="post_author" name="post_author" value="" />
				<input type='hidden' id='post_ID' name='temp_ID' value='-1228969046' /><input type="hidden" id="post_type" name="post_type" value="page" />
				<input type="hidden" id="original_post_status" name="original_post_status" value="draft" />
				<input name="referredby" type="hidden" id="referredby" value="http://www.ethosdigital.com/wp-admin/admin.php?page=wikipress" />

				<div id="poststuff" class="metabox-holder" style="position:absolute;right:15px;left:auto;width:330px;min-width:330px;">

				<div id="side-info-column" class="inner-sidebar">
<h2><img src="/wp-content/plugins/wikipress/assets/images/wikipress-logo.png" style="border:none;background:none;width:150px;display:inline;padding-right:5px;margin-bottom:-7px;" /></h2>
				<div id='side-sortables' class='meta-box-sortables'>
				<div id="pagesubmitdiv" class="postbox " >
				<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Manage This WikiBoard</span></h3>
				<div class="inside">
				<div class="submitbox" id="submitpage">


			
				<div id="misc-publishing-actions">
<!--
				-->	<div class="misc-pub-section curtime misc-pub-section-last">
	<label><input type="checkbox" name="no_archive"  /> <span style="color:#666;font-size:.8em;"><em>Minor edit, don't save a new version</em></span></label></div>
				</div>
				<div class="clear"></div>
				</div>

				<div id="major-publishing-actions">
				<div id="delete-action">
			
				</div>
					<input type="hidden" name="wiki_id" id="wiki_id" value="<?php echo $_POST[ 'wiki_id' ]; ?>" />
<input type="hidden" name="author_id" value="<?php echo $user_id;?>" />
				<div id="publishing-action">
							<input name="original_publish" type="hidden" id="original_publish" value="Publish" />
						<input name="submit_wiki" type="submit" class="button-primary" id="submit_wiki" tabindex="5" accesskey="p" value="Save Your Changes" /> or <a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=wikipress">cancel</a>
					</div>
				<div class="clear"></div>
				</div>

				</div>
				</div>
				</div>

			<!--	<div id="tagsdiv" class="postbox " >
				<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Tags</span></h3>
				<div class="inside">
				<p id="jaxtag"><label class="hidden" for="newtag">Tags</label><input type="text" name="tags_input" class="tags-input" id="tags-input" size="40" tabindex="3" style="width:250px;" value="" /></p>
				<div id="tagchecklist"></div>
				<p id="tagcloud-link" class="hide-if-no-js"><a href='#'>Choose from the most popular tags</a></p>
				</div>
				</div>

-->


				<div id="pageparentdiv" class="postbox "  style="margin-top:-160px;">
				
<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span>Formatting Guide</span></h3>
<div class="inside" >
	<p>WikiPress uses standard <a href="http://en.wikipedia.org/wiki/BBCode">bulletin board code</a> to format each wiki.  Some examples are listed below:</p>
<ul class="formatting-list" style="margin-left:20px;list-style-type:none;line-height:.8em;padding:8px; backgound:#eaf2fa; border:1px solid #f9f9f9;">
	
	<li>	[b]bold[/b] &rarr; <strong>bold</strong></li>
	<li>	[i]italic[/i] &rarr; <em>italics</em></li>
	<li>	[big]big text[/big]  $rarr; <big>big text</big></li>
		<li>	[bigger]bigger text[/bigger] &rarr; <big><big>bigger text</big></big></li>
		<li>[sm]small text[/sm]  &rarr; <small>small text</small></li>
	<li>	URL: http://www.ethosdigital.com/wikipress  &rarr; <a href="http://www.ethosdigital.com/wikipress">http://www.ethosdigital.com/wikipress</a></li>
	<li>	Email: info@ethosdigital.com &rarr; <a href="mailto:info@ethosdigital.com">info@ethosdigital.com</a>	</li>
	</ul>
<br />
	<p>We'll be adding and editing these frequently so make sure you check back at <a href="http://www.ethosdigital.com/wikipress/formatting">the Wiki-Press home page</a> frequently.</p>
</div>	<div style="clear:both;"></div>
				</div>
			</div>	</div>
	
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
		  <b class="wikipress">
		  <b class="wikipress1"><b></b></b>
		  <b class="wikipress2"><b></b></b>
		  <b class="wikipress3"></b>
		  <b class="wikipress4"></b>
		  <b class="wikipress5"></b></b>

		  <div class="wikipressfg">

					<div id="wikibody" style="width:97%;min-height:600px;background:#fff;margin:0 auto;">
						
						
<input type="text" class="wiki-input" name="wiki_name" value="<?php echo stripslashes($current[ 'wiki_name']); ?>" style="padding:3px 5px; width:100%;border:1px solid #efefef; background:#fff; height:34px;color:#333;font-size:1.6em;font-weight:bold;margin-top:10px;"/><br />
						<textarea name="wiki_body" id="wiki_body" class="wiki-textarea" style="width:100%;border:1px solid #efefef;background:#fff;padding:5px;color:#333;font-size:1.1em;min-height:600px;"><?php echo stripslashes($current[ 'wiki_body']); ?></textarea>
						</div>
					</div>

							  <b class="wikipress">
							  <b class="wikipress5"></b>

							  <b class="wikipress4"></b>
							  <b class="wikipress3"></b>
							  <b class="wikipress2"><b></b></b>
							  <b class="wikipress1"><b></b></b></b>
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