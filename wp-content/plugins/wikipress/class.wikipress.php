<?php

class Wiki_Press {
		
		var $version = "0.9.6";
		var $options;
		var $is_installed = false;		
		var $page_slugs;
		var $wiki_table;
		var $archive_table;
		var $update_table;
		
		function Wiki_Press() {
			global $wpdb;
			
			$this->wiki_table = $wpdb->prefix . 'wiki_wikis';
			$this->archive_table = $wpdb->prefix . 'wiki_archives';
			$this->update_table = $wpdb->prefix . 'wiki_updates';
			 
			if( isset( $_POST[ 'uninstall_wikipress_complete' ] ) ) 
				$this->uninstall();
				
			if( get_option( 'wikipress Options' ) !== FALSE ) {
				$this->options = unserialize( get_option( 'wikipress Options' ) ); 
			} else {
				$this->options = array();
			}
			
			if( get_option( 'wikipress Version' ) !== FALSE ) {
				$this->is_installed = true;
			}
			$this->page_slugs = array();

		}

		function on_activate() {
			$current_version = get_option( 'wikipress Version' );
			if( FALSE === $current_version ) {
				$this->install();				
			} else if( $this->version == $current_version ) {				
			} else {
				$this->upgrade( $current_version );
			}			
		}
		

		function on_deactivate() {
			
		}
		

		function on_admin_menu() {
			$this->page_slugs[ 'top_level' ] = add_menu_page( 'wikipress', 'WikiPress', 0, 'wikipress', array( &$this, 'top_level_page' ) );
			
			if( $this->is_installed ) {
				wp_enqueue_script( 'wikipress', ABSPATH . 'wp-content/plugins/wikipress/assets/scripts/wikipress.js', array( 'jquery' ) );
				$this->page_slugs[ 'add_wiki_page' ]  = add_submenu_page( 'admin.php', 'Add A Wiki', 'Add A Wiki', 0, 'wikipress/add_wiki_page', array( &$this, 'add_wiki_page' ) );
				$this->page_slugs[ 'edit_wiki_page' ]  = add_submenu_page( 'admin.php', '', '', 0, 'wikipress/edit_wiki', array( &$this, 'edit_wiki_page' ) );
				$this->page_slugs[ 'wiki' ]  = add_submenu_page( 'admin.php', '', '', 0, 'wikipress/wiki', array( &$this, 'view_wiki_page' ) );
				$this->page_slugs[ 'archive' ]  = add_submenu_page( 'admin.php', '', '', 0, 'wikipress/archive', array( &$this, 'archive_page' ) );
				$this->page_slugs[ 'uninstall' ] = add_submenu_page( 'admin.php', 'Uninstall', 'Uninstall', 0, 'wikipress/uninstall', array( &$this, 'uninstall_page' ) );
			}
		}
		/**
		 * Selectively prints information to the head section of the administrative HTML section.
		 */
		function on_admin_head() {
			if( strpos( $_SERVER['REQUEST_URI'], 'wikipress' ) ) {
				?>
				<link rel="stylesheet" href="<?php bloginfo( 'siteurl' ); ?>/wp-admin/css/dashboard.css?version=2.5.1" type="text/css" />
				<link rel="stylesheet" href="<?php bloginfo( 'siteurl' ); ?>/wp-content/plugins/wikipress/assets/styles/wikipress.css" type="text/css" />
				<?php
			}
		}

		function on_init() {}
		

		function install() {			
			global $wpdb;			
		
			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

			if( $wpdb->get_var( "SHOW TABLES LIKE '$this->wiki_table'" ) != $this->wiki_table ) {

				$wiki_query = "CREATE TABLE $this->wiki_table (
								wiki_id INT NOT NULL AUTO_INCREMENT,
								wiki_name VARCHAR(200) NOT NULL,
								wiki_author INT NOT NULL,
								wiki_created DATETIME NOT NULL,
								wiki_body TEXT NOT NULL,
								PRIMARY KEY (wiki_id))";
								
				dbDelta($wiki_query);
			}
			
			if( $wpdb->get_var( "SHOW TABLES LIKE '$this->archive_table'" ) != $this->archive_table ) {

				$archive_query = "CREATE TABLE $this->archive_table (
								archive_id INT NOT NULL AUTO_INCREMENT,
								wiki_id INT NOT NULL,
								archive_author INT NOT NULL,
								archive_created DATETIME NOT NULL,
								archive_name VARCHAR(200) NOT NULL,
								archive_body TEXT NOT NULL,
								PRIMARY KEY (archive_id))";

				dbDelta($archive_query);
			} 
	
			
			// If the version option doesn't exist, then add it.  Otherwise update it.
			if( FALSE === get_option( 'Wikipress Version' ) ) {
				add_option( 'Wikipress Version', $this->version );
			} else {
				update_option( 'Wikipress Version', $this->version );
			}
		}
		
		function uninstall() {
			global $wpdb;
			
			$wpdb->show_errors();
			
			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

				if( $wpdb->get_var( "SHOW TABLES LIKE '$this->wiki_table'" ) == $this->wiki_table ) {
					$wpdb->query( "DROP TABLE {$this->wiki_table}" );
				}
				
				if( $wpdb->get_var( "SHOW TABLES LIKE '$this->archive_table'" ) == $this->archive_table ) {
					$wpdb->query( "DROP TABLE {$this->archive_table}" );
				}
	
				if( FALSE !== get_option( 'wikipress Version' ) ) {
					delete_option( 'wikipress Version' );
				}
			}
		
	
		function upgrade( $old_version ) {
			switch( $old_version ) {
				case "0.9.0":
					$this->uninstall();
					$this->install();
					break;
				default:
					break;
			}
			
			update_option( 'Wikipress Version', $this->version );
		}
		
	
		function backup_data( $backup_type = 'cvs' ) {
			switch( $backup_type ) {
				case 'sql':					
				break;
				case 'csv':
				default:		
				break;
			}
		}
		

		/* WIKI DB INTERACTION FUNCTIONS */
		function wiki_count() {
			return count( $this->get_wikis() );
		}

		function get_wikis( $page = null ) {
			global $wpdb;
			$query = "SELECT * FROM $this->wiki_table WHERE wiki_id >= 0";
			return $wpdb->get_results( $query, OBJECT );
		}

		function get_wiki( $id ) {
			global $wpdb;
			$query = "SELECT * FROM $this->wiki_table WHERE wiki_id = " . $wpdb->escape( $id );
			return $wpdb->get_row( $query, ARRAY_A );
		}

		function validate_wiki( $wiki_values ) {
			$errors = array();
			if( strlen( $wiki_values[ 'wiki_name' ] ) <= 0 ) {
				$errors[] = 'The WikiBoard\'s name name must be provided.  Please enter a name.';
			}

			if( strlen( $wiki_values[ 'wiki_name' ] ) > 200 ) {
				$errors[] = 'The WikiBoard\'s name is too long.  Please limit names to 200 characters.';
			}
						
			return $errors;
		}

		// ADD WIKI	
		function add_wiki( $name, $body, $author ) {
			global $wpdb;
			$name = $wpdb->escape( $name );
			$body = $wpdb->escape( $body );
			$author = $wpdb->escape( $author);
			$query = "INSERT INTO $this->wiki_table (wiki_name,  wiki_created, wiki_body, wiki_author) VALUES( '$name', NOW(), '$body', '$author' )";
			return $wpdb->query( $query );
		}

		//EDIT WIKI
		function edit_wiki( $id, $name,  $body ) {
			global $wpdb;
			$id = $wpdb->escape( $id );
			$name = $wpdb->escape( $name );
			$body = $wpdb->escape( $body );
			$query = "UPDATE $this->wiki_table SET wiki_name = '$name',  wiki_body = '$body' WHERE wiki_id = $id";
			$wpdb->query( $query );
		}

		function is_editing_wiki( ) {
			if( $_GET[ 'action' ] == 'edit' && ( $wiki = $this->get_wiki( $_GET[ 'id' ] ) ) !== FALSE ) {
				return $wiki;
			} else {
				return FALSE;
			}
		}
	
		function delete_wiki( $id ) {
			global $wpdb;
			$wpdb->query( "DELETE FROM $this->wiki_table WHERE wiki_id = " . $wpdb->escape ( $id ) );
		}
		
		function delete_wikis( $wiki_ids ) {
			if( is_array( $wiki_ids ) ) {
				foreach( $wiki_ids as $id ) {
					$this->delete_wiki( $id );;
				}
			}
		}
		
		/* ARCHIVE DB INTERACTION FUNCTIONS */
		function archive_count() {
			return count( $this->get_archives() );
		}

		function get_archives( $page = null ) {
			global $wpdb;
			$query = "SELECT archive_id, A.wiki_id, archive_name, archive_created, archive_body, archive_author 
					FROM $this->archive_table 
					AS A, $this->wiki_table 
					AS W WHERE A.wiki_id = W.wiki_id 
					AND archive_id >= 0";
			return $wpdb->get_results( $query, OBJECT );
		}


		function get_archive( $id ) {
			global $wpdb;
			$query = "SELECT archive_id, A.wiki_id, archive_name, archive_created, archive_body, archive_author 
					FROM $this->archive_table 
					AS A, $this->wiki_table 
					AS W WHERE A.wiki_id = W.wiki_id 
					AND archive_id = " . $wpdb->escape( $id );
			
			return $wpdb->get_row( $query, ARRAY_A );
		}

		function validate_archive( $archive_values ) {
			$errors = array();
			return $errors;
		}


		// ADD ARCHIVE	
		function add_archive( $wiki_id, $name, $body, $author ) {
			global $wpdb;
			$wiki_id = $wpdb->escape( $wiki_id );
			$body = $wpdb->escape( $body );
			$name = $wpdb->escape( $name );
			$author = $wpdb->escape( $author );
			$query = "INSERT INTO $this->archive_table (wiki_id,  archive_name, archive_created, archive_body, archive_author) VALUES( '$wiki_id', '$name', NOW(), '$body', '$author' )";
		return $wpdb->query( $query );
				}

		//EDIT WIKI 
		function edit_archive( $id, $wiki_id,  $name, $body ) {
			global $wpdb;
			$id = $wpdb->escape( $id );
			$wiki_id = $wpdb->escape( $wiki_id );
			$body = $wpdb->escape( $body );
			$query = "UPDATE $this->archive_table SET archive_wiki_id = '$wiki_id',  archive_body = '$body' WHERE archive_id = $id";
			$wpdb->query( $query );
			}


		function is_editing_archive( ) {
			if( $_GET[ 'action' ] == 'edit' && ( $archive = $this->get_archive( $_GET[ 'id' ] ) ) !== FALSE ) {
				return $archive;
				} else {
					return FALSE;
				}
			}

		function delete_archive( $id ) {
			global $wpdb;
			$wpdb->query( "DELETE FROM $this->archive_table WHERE archive_id = " . $wpdb->escape ( $id ) );
		}


		function delete_archives( $archive_ids ) {
			if( is_array( $archive_ids ) ) {
				foreach( $archive_ids as $id ) {
					$this->delete_archive( $id );;
				}
			}
		}
	
		function top_level_page() { 
			if( $this->is_installed ) {
				include( dirname( __FILE__ ) . '/assets/pages/dashboard.php' );
			} else {
				echo '<div class="wrap"><p>WikiPress is uninstalled.  Please deactivate the plugin.</p></div>';
			}
		}
	
		function edit_wiki_page() { 
			include( dirname( __FILE__ ) . '/assets/pages/edit_wiki.php' );
		}
			
		function add_wiki_page() { 
			include( dirname( __FILE__ ) . '/assets/pages/add_wiki.php' );
		}
				
		function view_wiki_page() { 
			include( dirname( __FILE__ ) . '/assets/pages/wiki.php' );
		}
			
		function archive_page() { 
			include( dirname( __FILE__ ) . '/assets/pages/archive.php' );
		}
			
		function uninstall_page() {
			include( dirname( __FILE__ ) . '/assets/pages/uninstall.php' );
		}

		function truncate( $string, $length = 125 ) {
			return ( strlen( $string ) > $length ? substr( $string, 0, $length ) . '...' : $string );
		}

		function wiki_rows( $page = null ) {
			$wikis = $this->get_wikis( $page );
			foreach( $wikis as $wiki ) {
				$class = ( $class == 'alternate' ? '' : 'alternate' );
				?>
			
				<tr class="<?php echo $class; ?>" id="wiki_ro-<?php echo $wiki->wiki_id; ?>">
					<th class="check-column" scope="row"><input id="wiki_cb-<?php echo $wiki->wiki_id; ?>" name="wiki_cb[<?php echo $wiki->wiki_id; ?>]" type="checkbox" value="<?php echo $wiki->wiki_id; ?>" /></th>
					<td><a href="<?php $this->friendly_page_link( 'wiki' ); ?>&amp;action=edit&amp;id=<?php echo $wiki->wiki_id; ?>" style="font-weight:bold;font-size:1.2em;"><?php echo stripslashes($wiki->wiki_name); ?></a></td>	
					<td><?php echo date("l, M jS Y", strtotime($wiki->wiki_created)); ?></td>
					<td style="width:60px;"><a href="<?php $this->friendly_page_link( 'edit_wiki_page' ); ?>&amp;action=edit&amp;id=<?php echo $wiki->wiki_id; ?>">edit</a></td>
					<td style="width:60px;"><a href="<?php $this->friendly_page_link( 'wiki' ); ?>&amp;action=edit&amp;id=<?php echo $wiki->wiki_id; ?>">go</a></td>
				</tr> 
				<?php	
			}
		}

		
		function archive_rows( $wiki_id ) {
			$archives = $this->get_archives( $wiki_id );
			$count = '1';
			foreach( $archives as $archive ) {
				$class = ( $class == 'alternate' ? '' : 'alternate' );
				if($wiki_id == $archive->wiki_id){?>
					<tr class="<?php echo $class; ?>" id="archive_ro-<?php echo $archive->archive_id; ?>">
					<?php	$wikiuser = get_user_to_edit($archive->archive_author);
						$first = $wikiuser->first_name;
						$last = $wikiuser->last_name;
						?>	
						<th class="check-column" scope="row">
						<span style="color:#666;"><small><?php echo $count++; ?>.</small></span>
						</th>
						<td style="padding-left:5px;">
							<span style="color:#666;"><small><strong><em>
								<?php echo date("m/d/y", strtotime($archive->archive_created)); ?>
							</em></strong></small> <small>by</small> <small><strong><em><?php echo $first." ".$last; ?></em></strong></small></span></td><td style="width:10px;">
						</td>
						<td>
							<form action="<?php get_bloginfo('wpurl');?>/wp-admin/admin.php?page=wikipress/archive&amp;action=edit&amp;id=<?php echo $archive->archive_id; ?>" method="POST">
								<input type="submit" class="button-secondary" value="View Archive" />
								<input type="hidden" name="wiki_id" value="<?php echo $archive->$wiki_id; ?>" />
								<input type="hidden" name="archive_body" value="<?php echo $archive->archive_body; ?>" />
								<input type="hidden" name="archive_name" value="<?php echo $archive->archive_name; ?>" />
							</form>
						</td>
					</tr> 

					<?php	
					} 
				}
			}

		function friendly_page_slug( $slug_id, $display = true ) {
			if( isset( $this->page_slugs[ $slug_id ] ) ) {
				$array = explode( '_page_', $this->page_slugs[ $slug_id ] );
				if( $display ) {
					echo $array[ 1 ];
				} else {
					return $array[ 1 ];
				}
			} else if( $slug_id == 'top_level' ) {
				if( $display ) {
					echo 'wikipress';
				} else {
					return 'wikipress';
				}
			}
		}
		
	
		function friendly_page_link( $slug_id, $display = true ) {
			$page_slug = $this->friendly_page_slug( $slug_id, false );		
			$value = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=' . $page_slug;
			if( $display ) {
				echo $value;
			} else {
				return $value;
			}
		}			
	}

?>
