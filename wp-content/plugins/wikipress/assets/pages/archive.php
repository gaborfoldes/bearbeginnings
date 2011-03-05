<?php require_once('class.bbcode.php'); ?>

<?php

function author_meta($author_id){

	$author = get_user_to_edit($author_id);

	echo $author->first_name." ".$author->last_name;
}


?>
<?php
if( isset( $_POST[ 'delete_archives' ] ) ) {
	$this->delete_archives( $_POST[ 'archive_cb' ] );
}

if( isset( $_POST[ 'submit_archive' ] ) ) {

	$errors = $this->validate_archive( $_POST );
	
	if( empty( $errors ) ) {
	
		if( isset( $_POST[ 'archive_id' ] ) ) {
			// Edit existing
			$results = $this->edit_archive( $_POST[ 'archive_id' ], $_POST[ 'archive_name' ],  $_POST[ 'archive_body' ] );
			
			if( $results === FALSE ) {
				?>
				<div id="message" class="error">
					<p>There were unexpected errors during the update.  Your changes may not have been saved.</p>
				</div>	
				<?php				
			} else { 
				?>
				<div id="message" class="updated fade">
					<p>Your archive "<?php echo stripslashes( $_POST[ 'archive_name' ] ); ?>" has been updated.</p>
				</div>	
				<?php
			}
			
		} 
		else {
			// Add new
			$results = $this->add_archive( $_POST[ 'archive_name' ],  $_POST[ 'archive_body' ] );
		
			if( $results === FALSE ) {
				?>
				<div id="message" class="error">
					<p>There were unexpected errors during the add.  Your changes may not have been saved.</p>
				</div>	
				<?php	
			} else { 
				?>
				<div id="message" class="updated fade">
					<p>Your archive "<?php echo stripslashes( $_POST[ 'archive_name' ] ); ?>" has been added.</p>
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
		
		$current[ 'archive_id' ] = $_POST[ 'archive_id' ];
		$current[ 'archive_name' ] = $_POST[ 'archive_name' ];
		$current[ 'archive_body' ] = $_POST[ 'archive_body' ];
			
	
	}
}

$current = $this->is_editing_archive();
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



<input type="hidden" id="_wpnonce" name="_wpnonce" value="674bd168b0" /><input type="hidden" name="_wp_http_referer" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/page-new.php" /><input type="hidden" id="user-id" name="user_ID" value="1" />

<input type="hidden" id="hiddenaction" name="action" value='post' />
<input type="hidden" id="originalaction" name="originalaction" value="post" />
<input type="hidden" id="post_author" name="post_author" value="" />
<input type='hidden' id='post_ID' name='temp_ID' value='-1228969046' /><input type="hidden" id="post_type" name="post_type" value="page" />
<input type="hidden" id="original_post_status" name="original_post_status" value="draft" />
<input name="referredby" type="hidden" id="referredby" value="http://www.ethosdigital.com/wp-admin/admin.php?page=archivepress" />

<div id="poststuff" class="metabox-holder has-right-sidebar">

<div id="side-info-column" class="inner-sidebar">

<div id='side-sortables' class='meta-box-sortables'>
	
	<style type="text/css">
	
	a.archive-dashboard-btn{
		line-height:.5em;
		text-decoration:none;
	}
	
	a.archive-dashboard-btn h2:hover{
		
		text-decoration:none;
		background:url('<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/archivepress/images/db-hover.png') top right no-repeat;
	}
	</style>
		<?php

		foreach( $this->get_archives() as $archive ) {
	if($current['archive_id'] == $archive->archive_id){


		 $archive_king = $archive->archive_author;
		$archive_king = (int) $archive_king;
		$archiveauthor = get_userdata($archive_king);
	
		$last = $archiveauthor->last_name;
	
	}
	}

	?>
	<h2 style="width:100%;">	<a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=wikipress" class="archive-dashboard-btn"><img src="/wp-content/plugins/wikipress/assets/images/wikipress-logo.png" style="border:none;background:none;width:150px;display:inline;padding-right:5px;margin-bottom:-7px;" /></a></h2>
<br />
<div id="pagesubmitdiv" class="postbox " >


	<div id="message" class="error">
		<ul><li><br /><br />
			
			<?php echo $archiveauthor->first_name; ?>
			You cannot edit this page.  You are currently viewing an archived wikiboard.  This WikiBoard was archived on <em><strong><?php echo date("m/d/Y", strtotime($current[ 'archive_created' ])); ?></strong></em> by <em><strong><?php echo author_meta($archive_king); ?></strong></em>   and is an archive of an active WikiBoard titled:<br /><center><blockquote><strong><big> <em>"
<?php						foreach( $this->get_wikis() as $wiki ) {
						?>
						<?php if( $current[ 'wiki_id' ] == $wiki->wiki_id ) { 
							echo  stripslashes($wiki->wiki_name); 
							echo "\"</em></big></strong></blockquote></center><br />";
							echo "<a href='" . get_bloginfo('wpurl') . "/wp-admin/admin.php?page=wikipress/wiki&action=edit&id=".$wiki->wiki_id."'>&larr; Go back to Active Wiki</a>";
								}
							}
								?></li>
								</ul>
								</div>

</div>


	<a href="/wp-admin/admin.php?page=wikipress" class="archive-dashboard-btn">&larr; back to dashboard	</a>

</div></div>	
<br /><br />

<style type="text/css">
.archivepress{display:block}
.archivepress *{
  display:block;
  height:1px;
  overflow:hidden;
  font-size:.01em;
  background:#FFFFFF}
.archivepress1{
  margin-left:3px;
  margin-right:3px;
  padding-left:1px;
  padding-right:1px;
  border-left:1px solid #f7f7f7;
  border-right:1px solid #f7f7f7;
  background:#fbfbfb}
.archivepress2{
  margin-left:1px;
  margin-right:1px;
  padding-right:1px;
  padding-left:1px;
  border-left:1px solid #f2f2f2;
  border-right:1px solid #f2f2f2;
  background:#fcfcfc}
.archivepress3{
  margin-left:1px;
  margin-right:1px;
  border-left:1px solid #fcfcfc;
  border-right:1px solid #fcfcfc;}
.archivepress4{
  border-left:1px solid #f7f7f7;
  border-right:1px solid #f7f7f7}
.archivepress5{
  border-left:1px solid #fbfbfb;
  border-right:1px solid #fbfbfb}
.archivepressfg{
  background:#FFFFFF}
</style>

	<div style="background:#f1f1f1;padding:10px;position:relative;margin-left:0;margin-right:300px;">
		<div>
		  <b class="archivepress">
		  <b class="archivepress1"><b></b></b>
		  <b class="archivepress2"><b></b></b>
		  <b class="archivepress3"></b>
		  <b class="archivepress4"></b>
		  <b class="archivepress5"></b></b>

		  <div class="archivepressfg">
			<div id="archivebody" style="width:96%;background:#fff;padding:15px;min-height:850px;">
	<h1 style="width:100%; border-bottom:1px solid #cacaca;margin-bottom:20px;margin-top:-5px;padding-bottom:10px;">	<?php echo stripslashes($current[ 'archive_name']); ?></h1>
			<?php
				$parsed = "";
				$data = stripslashes($current['archive_body']);
				$parsed .= $data;
	parsing($parsed);
print($parsed);
	?>
	</div>	</div>

		  <b class="archivepress">
		  <b class="archivepress5"></b>
		  <b class="archivepress4"></b>
		  <b class="archivepress3"></b>
		  <b class="archivepress2"><b></b></b>
		  <b class="archivepress1"><b></b></b></b>
		</div>
	
</div>
<div id="post-body" class="has-sidebar">
<div id="post-body-content" class="has-sidebar-content">



<div id="postdivrich" class="postarea">

	
</div>



</div>	
		

			
	<div style="clear: both;">&nbsp;</div>


</div>

</form>
</div>

	</div>



</div>