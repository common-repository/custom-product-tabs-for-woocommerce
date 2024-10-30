<?php

if (!defined('ABSPATH'))
    exit;

function wpcc_extra_product_tab( $default_tabs ) {
    $default_tabs['wpcc_custom_tab'] = array(
        'label'   =>  __( 'WC Extra Tabs', 'woocommerce' ),
        'target'  =>  'wpcc_extra_tab_data',
        'priority' => 65,
        'class'   => array()
    );
    return $default_tabs;
}


 
function wpcc_extra_tab_data() {
$checked="";
  if(sanitize_text_field(get_post_meta(get_the_ID(), "enable_wpcc_extra_tab", true))=="on"){ 
    $checked="checked";
  }
?>

   <div id="wpcc_extra_tab_data" class="panel woocommerce_options_panel">
     <div class="intheboxContainer">
<p class="form-field _bubble_new_field ">
<label for="enable_wpcc_extra_tab">Enable/Disable Tab </label>
<input type="checkbox" id="enable_wpcc_extra_tab" name="enable_wpcc_extra_tab" value="on" <?php echo sanitize_text_field($checked);?>>
</p>
<div id="add_more_extra_table">
<?php
$total_tab=1;

$tab_description = filter_var_array(get_post_meta(get_the_ID(),'extra_wpcc_tab_desc_fields',true));

$tab_title= filter_var_array(get_post_meta(get_the_ID(),'extra_wpcc_tab_title_fields',true));

if(is_array($tab_title) && !empty($tab_title)){
   $total_tab=count($tab_title); 
}
for($count=0; $count<$total_tab;$count++){
    ?>
    
    <?php
    if($count==0){

?>

<div>
<p class="form-field wpcc_custom_tab_title_field ">
<label for="extra_wpcc_title_tab">Custom Tab Title <?php echo esc_html($count+1);?></label>
<input type="text" class="large" name="extra_wpcc_tab_title_fields[]" id="extra_wpcc_title_tab" value="<?php echo esc_html($tab_title[$count]);?>" placeholder=""> </p>
<p class="form-field wpcc_custom_tab_title_field">
<label for="extra_wpcc_desc_tab">Custom Tab Content <?php echo esc_html($count+1);?></label>
<textarea class="short" name="extra_wpcc_tab_desc_fields[]" id="extra_wpcc_desc_tab" rows="2" cols="20" style="width:100%;height:140px;"><?php echo esc_html($tab_description[$count]);?></textarea></p>
</div>
<?php }else{ ?>

       <div><p class="form-field wpcc_custom_tab_title_field ">
           <label for="extra_wpcc_title_tab">Custom Tab Title <?php echo esc_html($count+1);?></label>
           <input type="text" class="large" name="extra_wpcc_tab_title_fields[]" id="extra_wpcc_title_tab" value="<?php echo esc_html($tab_title[$count]);?>"> 
           </p>
           <p class="form-field wpcc_custom_tab_title_field">
               <label for="extra_wpcc_desc_tab">Custom Tab Content <?php echo esc_html($count+1);?></label>
              <textarea class="short" name="extra_wpcc_tab_desc_fields[]" id="extra_wpcc_desc_tab" placeholder="" rows="2" cols="20" style="width:100%;height:140px;"><?php echo esc_html($tab_description[$count]);?></textarea>
              </p>
              <br><a href="javascript:void(0);" class="btn btn-danger removewpcctab">Remove</a>
              </div>
       
 
<?php } ?>
<?php }?>
<input type="hidden" id="next_wpcc_tab" value="<?php echo esc_html($count);?>">
  </div>
    <div class="col-md-2">
        <div class="form-group change">
            <label for="">&nbsp;</label><br/>
            <a class="btn btn-success add-more">+ Add More</a>
        </div>
    </div>
     </div>
    </div>
  
   
   <?php
}



function woocommerce_product_extra_tab_fields_save($post_id)
{
  
   // Enable / Disable Check
   
    $woocommerce_enable_extra_tab = sanitize_text_field($_REQUEST['enable_wpcc_extra_tab']);
    
     if (!empty($woocommerce_enable_extra_tab) && $woocommerce_enable_extra_tab=='on'){
         
       $woocommerce_enable_extra_tab='on';
         }else{
       $woocommerce_enable_extra_tab='off';
    }
    
    if( metadata_exists( 'post', $post_id, 'enable_wpcc_extra_tab' )){
        
     update_post_meta($post_id, 'enable_wpcc_extra_tab', $woocommerce_enable_extra_tab);
        
    }else{
         add_post_meta($post_id, 'enable_wpcc_extra_tab', $woocommerce_enable_extra_tab);
    }
    
    // Tab Title information
    
    $woocommerce_extra_wpcc_title_tab = filter_var_array($_REQUEST['extra_wpcc_tab_title_fields']);
   
  
    if (!empty($woocommerce_extra_wpcc_title_tab)){
    
    if(metadata_exists( 'post', $post_id, 'extra_wpcc_tab_title_fields' )){
        
        update_post_meta($post_id, 'extra_wpcc_tab_title_fields', $woocommerce_extra_wpcc_title_tab);
    }else{
        add_post_meta($post_id, 'extra_wpcc_tab_title_fields', $woocommerce_extra_wpcc_title_tab);
    }
        
    }
        
        // Tab Content Information
        
    $extra_wpcc_tab_desc_fields = filter_var_array($_REQUEST['extra_wpcc_tab_desc_fields']);
 
    
    if (!empty($extra_wpcc_tab_desc_fields)){
        
        if(metadata_exists( 'post', $post_id, 'extra_wpcc_tab_desc_fields' )){
            
      update_post_meta($post_id, 'extra_wpcc_tab_desc_fields', $extra_wpcc_tab_desc_fields);
    }else{
        add_post_meta($post_id, 'extra_wpcc_tab_desc_fields', $extra_wpcc_tab_desc_fields);
    }
        
    }
}


add_filter( 'woocommerce_product_data_tabs', 'wpcc_extra_product_tab', 10, 1 );
add_action('woocommerce_process_product_meta', 'woocommerce_product_extra_tab_fields_save');
add_action( 'woocommerce_product_data_panels', 'wpcc_extra_tab_data' );
           

