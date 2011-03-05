<?php

$user_id = (int) $user_id;
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$wikiuser = get_user_to_edit($user_id);
$first = $wikiuser->first_name;
$last = $wikiuser->last_name;



if( isset( $_POST[ 'delete_wikis' ] ) ) {
	$this->delete_wikis( $_POST[ 'wiki_cb' ] );
}
/*if(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 'edit'){
		include_once(echo get_bloginfo('siteurl') . '/wp-content/plugins/wikipress/pages/edit_wiki.php');
	}
	
} else {
*/	
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
					<p>Your WikiBoard "<?php echo stripslashes( $_POST[ 'wiki_name' ] ); ?>" has been updated.</p>
				</div>	
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
					<p>Your WikiBoard "<?php echo stripslashes( $_POST[ 'wiki_name' ] ); ?>" has been added.</p>
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

?>
<div class="wrap">

<h2><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wikipress/assets/images/wikipress-logo.png" style="border:none;background:none;width:200px;display:inline;padding-right:5px;margin-bottom:0;" /></h2>

	<div id="dashboard-widgets-wrap">

		<div id='dashboard-widgets' class='metabox-holder'>

			<div  class="postbox-container" style="width:49%;">
	<div id='normal-sortables' class='meta-box-sortables ui-sortable'>
			


						<div id="dashboard_right_now" class="postbox " >
						<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Right Now</span></h3>
						<div class="inside">
						<p class="sub">At a Glance</p>

						<div class="table">
							<table>
								<tr class="first"><td class="first b b-posts">	
				<?php echo $this->wiki_count(); ?> </td><td class="t posts">WikiBoards</td><!--<td class="b b-comments"><a href='edit-comments.php'>2</a></td><td class="last t comments">Comments</td>--></tr>
							</table>
						</div>
						<p class="youare">This is WikiPress version <?php echo $this->version; ?></p><br /><div style="height:4px;border-bottom:1px solid #cacaca;width:100%;margin-bottom:5px;"></div>
		
					<p class="submit" style="width:100%;text-align:right;" >
						<a href="<?php echo get_bloginfo('wpurl');?>/wp-admin/admin.php?page=wikipress/uninstall" >	<input type="submit" name="uninstall_one" class="button-secondary" value="Uninstall WikiPress" /></a>
						</p>
			<br><br>
	
						</div>

						</div>
<div id="dashboard_recent_comments" class="postbox if-js-closed" >		
	<form name="wiki-manage" id="wiki-manage" method="post" action="<?php echo get_bloginfo('wpurl');?>/wp-admin/admin.php?page=wikipress">
		<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Active WikiBoards</span></h3>
		<div class="inside"><form name="wiki-manage" id="wiki-manage" method="post" action="<?php echo get_bloginfo('wpurl');?>/wp-admin/admin.php?page=wikipress/wikis">
			<br />	
			<table class="widefat"> <!-- Start Manage Table -->
				<thead>
					<tr>
						<th class="check-column" scope="col"><input id="selectall" name="selectall" type="checkbox" /></th>
						<th scope="col">Name</th>

						<th scope="col">Created </th>
						<th scope="col"> </th>
						<th scope="col"> </th>
					</tr>
				</thead>
			
				<tbody>
					<?php $this->wiki_rows(); ?>
				</tbody>
			</table> <!-- End Manage Table -->

		<div class="tablenav" style="width:50%;height:50;">
			<div class="alignleft">
				<input name="delete_wikis" id="delete_wikis" class="button-secondary delete" type="submit" value="Delete Checked" />
			</div>
			<br class="clear" />
		</div>
		<br class="clear" />		

	</div>
</div>

	</form>


</div>
</div>

	<div class='postbox-container' style="width:49%;">


	<!-- QUICKIE PRESS DASHBOARD WIDGET -->
	<div id='side-sortables' class='meta-box-sortables'>
		
		
	<div id="dashboard_quick_press" class="postbox " style="background:#eaf3fa;">
	<div class="handlediv" title="Click to toggle" ><br /></div>
		<form name="wiki-manage" id="wiki-manage" method="post" action="<?php echo get_bloginfo('wpurl');?>/wp-admin/admin.php?page=wikipress">
			<h3 class='hndle' style="background:#eaf3fa;color:#333;"><span>QuickiePress</span></h3>
			<div class="inside" style="background:#eaf3fa;">
				<input type="hidden" name="wiki_body" value="" id="wiki_body" />
				<input type="text" name="wiki_name" id="wiki_name" tabindex="1" autocomplete="off" style="height:34px; color:#999; border:1px solid #cacaca;font-size:1.4em; font-weight:bold;width:100%;" value="Wiki Name" />
				<p class="submit" style="text-align:right;">
					<input name="submit_wiki" type="submit" class="button-primary" id="submit_wiki" tabindex="5" accesskey="p" value="Publish New Wiki" style="float:right;" />
					<br class="clear" />
				</p>
		</form>

	</div>
	</div>


	<!-- MAIN WIKIPRESS DASHBOARD WIDGET-->
	<div id="dashboard_primary" class="postbox if-js-closed" >
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Release Updates & Feature Development</span></h3>	
	<div class="inside">
			<p>This is currently the fifth release of WikiPress.  Included in the most recent update:</p>
			<strong>0.9.5 Version Updates</strong>
			<ul>
				<li>Absolute URL's added to support Wikiboard's located in sub-directories.</li>
				<li>Fixed image display.</li>
				<li>Fixed Delete Wiki funtion on dashboard</li>
				<li>Removed Inactive Link</li>
		</ul><br><br>
		<strong>Features in Development</strong><br />

			<ul>
				<li>User Permissions per WikiBoard</li>
				<li>WikiBoard Commenting</li>
				<li>Post/Page Insertion via shortcode</li>
				<li>Dashboard Widget</li>
			</ul>
			<br>
			<strong>Get Involved</strong><p>If you are interested in adding to WikiPress (or if you already have), please be sure to <a href="mailto:erik@rapprich.com">contact me</a> so you can get involved & receive the appropriate credit. All existing documentation is available at <a href="http://www.rapprich.com/">rapprich.com</a></p></div>
	</div>
	<div id="dashboard_primary" class="postbox if-js-closed" >
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>About Wiki-Press<span class="postbox-title-action"></span></span></h3>
	<div class="inside">
			<p>WikiPress is an open-source, WordPress-based Wiki solution developed by <a href="http://www.rapprich.com">Erik Rapprich</a> over at <a href="http://www.ethosdigital.com">EthosDigital, LLC</a>.   </p>
			<p>It was developed by <a href="http://www.ethosdigital.com">EthosDigital</a> as a plugin to offer on client web-pages, to facilitate easy client/consultant collaboration without the need to leave the client's domain.  A great deal of work and effort was involved in the process and any donations would be greatly appreciated & put solely towards feature development & bug fixing.</p>

				<p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="2837828">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>

				</p>
	</div>
	</div>
	<div id="dashboard_secondary" class="postbox if-js-closed" style="visibility:hidden;" >
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>What is A Wiki? <span class="postbox-title-action"><a href="<?php echo get_bloginfo('wpurl');?>/wp-admin/index.php?edit=dashboard_secondary#dashboard_secondary" class="edit-box open-box">Configure</a></span></span></h3>

	<div class="inside">

	</div>
	</div>
	</div>
	<form style='display: none' method='get' action=''><p><input type="hidden" id="closedpostboxesnonce" name="closedpostboxesnonce" value="fcf6e94eae" /><input type="hidden" id="meta-box-order-nonce" name="meta-box-order-nonce" value="ac71392b4d" /></p></form></div>
</div></div>
