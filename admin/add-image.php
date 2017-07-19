<?php 

//must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    global $wpdb;   
    $table_name = $wpdb->prefix."nt_fwms_slides";    


   // process form data

    if( isset($_POST[ 'submit' ])) {
	    if ( 
			    ! isset( $_POST['_wpnonce'] ) 
			    || ! wp_verify_nonce( $_POST['_wpnonce'], 'add_image' ) 
			) {

			   print 'Sorry, your nonce did not verify.';
			   exit;

			} else {
	 /*Sanitize Image Title*/
	 $_POST[ 'post_title' ] = sanitize_text_field($_POST[ 'post_title' ]);
	 /*Check that the image is an image*/
	 $image_type = wp_check_filetype($_POST[ 'ad_image' ]);
	 if($image_type['ext'] != 'jpg' && $image_type['ext'] != 'jpeg' && $image_type['ext'] != 'png' && $image_type['ext'] != 'gif'){
	  $_POST[ 'ad_image' ] = '';
	 }
	 /*Check that post Id is a int*/
	 $_POST[ 'id' ] = intval($_POST[ 'id' ]);
	 if ( ! $_POST[ 'id' ] ) {
	    $_POST[ 'id' ] = '';
	}
    	 if(isset($_POST['coord'])) {
    			foreach ($_POST['coord'] as $key=>$value) {
    				//Strip slashes of content to keep shortcodes 
    				$_POST['coord'][$key]['content'] = stripslashes($value['content']);
    				//Allow HTML in content
					$_POST['coord'][$key]['content'] = wp_kses_post($_POST['coord'][$key]['content']);
					//Dont allow HTML in title
					$_POST['coord'][$key]['title'] = sanitize_text_field($_POST['coord'][$key]['title']);					
					//Check if pin pint coords are numbers
					if(!is_numeric($_POST['coord'][$key]['l'])){
					  $_POST['coord'][$key]['l'] = '';
					}
					if(!is_numeric($_POST['coord'][$key]['t'])){
					  $_POST['coord'][$key]['l'] = '';
					}					
				}
				$_POST['coord'] = serialize($_POST['coord']);
		}else{
			$_POST['coord'] = '';
		}
	$query = $wpdb->prepare("SELECT id FROM $table_name WHERE id = '%s'", $_POST[ 'id' ]);
	//Just for debuggin
//     echo $wpdb->last_error;     
    if( $elements = $wpdb->get_results($query)){
		foreach ( $elements as $elements_result ) {
        		$id = $elements_result->id;
			}	    

		
		$wpdb->query( $wpdb->prepare( 
	"
		UPDATE ".$table_name." SET
		name = '%s',
		image = '%s',
		coords = '%s'
		WHERE id = '%s'
	", 
        array(
		$_POST[ 'post_title' ],
		$_POST[ 'ad_image' ],
		$_POST[ 'coord' ],
		$id
		)
	) );
	$_GET['id'] = $_POST['id'];
	echo '<p class="success">' . __( 'Element edited', 'full-window-interactive-slider' ) . '</p>';
	}else{
	$wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO ".$table_name."
		( name, image, coords )
		VALUES ( %s, %s, %s )
	", 
        array(
		$_POST[ 'post_title' ],
		$_POST[ 'ad_image' ],
		$_POST[ 'coord' ]
	 )
	) );
	$_GET['id'] = $wpdb->insert_id;
	echo '<p class="success">' . __( 'Element created', 'full-window-interactive-slider' ) . '</p>';
	}
	//Just for debuggin
// 	echo $wpdb->last_error;
	}
}
	wp_enqueue_media();
    if(isset($_GET['id'])){
    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = '%s'", $_GET[ 'id' ]);
    $elements = $wpdb->get_results($query);
	//Just for debuggin
//   echo $wpdb->last_error;     
    if(isset($elements)){
		foreach ( $elements as $elements_result ) {
        		$id = $elements_result->id;
        		$title =  $elements_result->name;
        		$image =  $elements_result->image;
        		$coord =  $elements_result->coords;
			}	    

		}
  }
   ?>
   <div class="wrap">
    <h2><?php echo __( 'Add image', 'full-window-interactive-slider' ); ?></h2>
    <?php echo __( "You can add a new image from here. Once uploaded, you'll be able to add points with content.<br>
    To show them, just use the shortcode [nt_fwmb id='1,2,3'], where ids are the pics you want in the slideshow.", 'full-window-interactive-slider' ); ?>
    

<form name="form2" id="form2" method="POST" action="" accept-charset="utf-8"  enctype="multipart/form-data">
	<?php wp_nonce_field('add_image'); ?>
	<input type="hidden" name="<?php echo esc_html($hidden_field_name); ?>" value="Y">
	<input type="hidden" name="id" value="<?php if(isset($id)){ echo esc_html($id); }?>">

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content" style="position: relative;">
				<div id="titlediv">
					<div id="titlewrap">

						<input id="title" type="text" autocomplete="off" spellcheck="true" size="30" name="post_title" placeholder="<?php echo __( 'Image name', 'full-window-interactive-slider' ); ?>" value="<?php if(isset($title)){ echo esc_html($title); }?>">
						<input type="submit" name="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'full-window-interactive-slider' ); ?>" />
					</div>
				</div>
			</div>
		</div>	
	</div>
<label for="upload_image">
    <input id="upload_image" class="upload_image" type="text" size="36" name="ad_image" value="<?php if(isset($image)){ echo esc_url($image); }else{ echo 'http://'; } ?>"  /> 
    <input id="upload_image_button" class="button upload_image_button main_image_upload" type="button" value="<?php echo __( 'Upload image', 'full-window-interactive-slider' ); ?>" />
    <br /><?php echo __( 'Enter a URL or upload an image', 'full-window-interactive-slider' ); ?>
</label>
<div class="fwms_work_area">
	<?php if(isset($image)){ 
		echo '<img src="'.esc_url($image).'" width="100%" class="canvas">';
	 }?>
      <?php 
        if(isset($coord) && $coord != ''){ 
          $coord_pins = unserialize($coord);
          foreach($coord_pins as $clave => $valor){
          
          
            echo '<div class="dummy" style="left:calc('.esc_html($valor['l']).'% - 25px); top:calc('.esc_html($valor['t']).'% - 50px);" data-pin="'.esc_html($clave).'">';
            if(isset($valor['pin']) && $valor['pin'] != ''){
            $img_src = $valor['pin'];
            }else{
            $img_src = FWMS_GST_HANDL_PLUGIN_URL.'images/pin.png';
            }
            echo '<img width="50" src="'.esc_url($img_src).'">';
            echo '</div>';
          }
        }     
	?>	 
</div>
<div class="fwms_slots">



	<?php if(isset($coord) && $coord != ''){ 
		$coord = unserialize($coord);
		foreach($coord as $clave => $valor){
		        if(isset($valor['pin']) && $valor['pin'] != ''){
			  $img_src = $valor['pin'];
			}else{
			  $img_src = FWMS_GST_HANDL_PLUGIN_URL.'images/pin.png';
			}
			echo '<div id="message" class="updated notice is-dismissible below-h2" data-index="'.esc_attr($clave).'">';
			echo '<p><input type="hidden" name="coord['.esc_html($clave).'][l]" value="'.esc_attr($valor['l']).'">';
			echo '<input type="hidden" name="coord['.esc_html($clave).'][t]" value="'.esc_attr($valor['t']).'">';
			echo __( 'Title (optional)', 'full-window-interactive-slider' ).'<input type="text" name="coord['.esc_html($clave).'][title]" value="'.esc_textarea($valor['title']).'">';
			echo __( 'Content (insert a full url with http if you want a direct link)', 'full-window-interactive-slider' ).'<input type="text" name="coord['.esc_html($clave).'][content]" value="'.esc_textarea($valor['content']).'">';
			echo '<label for="upload_image"><input class="upload_image" type="hidden" size="36" name="coord['.esc_html($clave).'][pin]" value="'.esc_attr($valor['pin']).'"  /><input id="upload_pin_button_'.$clave.'" class="button upload_image_button pin_image_upload" type="button" value="'.__( 'Change pin', 'full-window-interactive-slider' ).'" /><img class="pin_element" width="50" src="'.esc_url($img_src).'"></label>';

			echo '</p><span class="screen-reader-text">'.__( 'Discard', 'full-window-interactive-slider' ).'</span></div>';
		}
	}?>
</div>
<p class="submit">
<input type="submit" name="submit" class="button-primary" value="<?php 
echo __( 'Save changes', 'full-window-interactive-slider' ); ?>" />
</p>
</form>
</div>