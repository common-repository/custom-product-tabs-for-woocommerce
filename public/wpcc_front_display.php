<?php

if (!defined('ABSPATH'))
    exit;

add_filter( 'woocommerce_product_tabs', 'extra_wpcc_product_tab' );

function extra_wpcc_product_tab( $tabs ) {
    
if(get_post_meta(get_the_ID(), "enable_wpcc_extra_tab", true)=="on"){ 
   
$tab_title= filter_var_array(get_post_meta(get_the_ID(),'extra_wpcc_tab_title_fields',true));
$tab_description = filter_var_array(get_post_meta(get_the_ID(),'extra_wpcc_tab_desc_fields',true));
if(is_array($tab_title) && !empty($tab_title)){
    $countTabs=sizeof($tab_title);
    $tabPriority=26;
    for($i=0;$i<$countTabs;$i++){
    $tabs['extra_wpcc_tab_'.$i] = array(
        'title'    => __( $tab_title[$i], 'woocommerce' ),
        'callback' => 'extra_wpcc_tab_content',
        'priority' => $tabPriority,
        'description' =>$tab_description[$i]
        
    );
    $tabPriority++;
    }
}
}
    return $tabs;

}



/**
 * Function that displays output for the tab.
 */
function extra_wpcc_tab_content( $slug, $tab ) {

 printf('<h2>%s</h2>',wp_kses_post( $tab['title'] ));
  echo '<div class="extra_wpcc_tab_content">'.html_entity_decode(wp_kses_post( $tab['description'])).'</div>';

}
