<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

  <?php  
  global $wpdb;
  $table_name = $wpdb->prefix."nt_fwms_slides";
    if(isset($atts['id'])){
    
    
    $nt_fwms_slides = explode(",", $atts['id']);
      if(count($nt_fwms_slides) > 1){
	       echo '<a href="#" class="fwmbup">></a><a href="#" class="fwmbdown"><</a>';
      }
      echo '<div class="fwis-wrap">';
    $i = 1;
    foreach($nt_fwms_slides as $nt_fwms_slide){
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = '%s'", $nt_fwms_slide);
            $elements = $wpdb->get_results($query);
            //Debug
            //echo $wpdb->last_error;     
            if(isset($elements)){
                    foreach ( $elements as $elements_result ) {
                            $id = $elements_result->id;
                            $title =  $elements_result->name;
                            $image =  $elements_result->image;
                            $coord =  $elements_result->coords;
                            ?>
                                <div id="<?php echo esc_html($nt_fwms_slide); ?>" class="other<?php if($i == 1){ echo ' active'; } ?>"  data-bg="<?php echo esc_attr($image);?>">
                                  <div><h1><?php echo esc_html($title);?></h1>
                                      <?php 
                                                if(isset($coord)){ 
                                                  $coord = unserialize($coord);
                                                  foreach($coord as $clave => $valor){
                                      						    if(isset($valor['pin']) && $valor['pin'] != ''){
                                      						      $img_src = $valor['pin'];
                                      						    }else{
                                      						      $img_src = FWMS_GST_HANDL_PLUGIN_URL.'images/pin.png';
                                      						    }
                                      						    $slide_title = esc_html($valor['title']);
                                      						    $slide_content = do_shortcode(wp_specialchars_decode($valor['content']));
                                      						    $check_link = substr($slide_content,0,4);
                                      						    if($check_link != 'http'){
                                      						      echo '<div class="dummy" data-left="'.esc_html($valor['l']).'" data-top="'.esc_html($valor['t']).'">';
                                      						      echo '<img width="50" src="'.esc_url($img_src).'" class="fwms_pin">';
                                      						      echo '<div class="fwmb_tooltip">
                                      						      <h3>'.$slide_title.'</h3>
                                      						      <div class="fwmb_content">'.$slide_content.'</div>
                                      						      </div></div>';
                                      						    }else{
                                      						      echo '<div class="dummy" data-left="'.esc_attr($valor['l']).'" data-top="'.esc_attr($valor['t']).'">';
                                      						      echo '<img width="50" src="'.esc_url($img_src).'" class="fwms_pin">';
                                      						      echo '<div class="fwmb_tooltip">
                                      						      <h3><a href="'.$slide_content.'" target="_blank">'.$slide_title.'</a></h3>
                                      						      </div></div>';						    
                                      						    }
                                                  }
                                                }     

                                      ?>
                                 </div>
                                </div>
                    <?php    } 

            }
        $i++;    
       }
       echo '</div>';
  }?>