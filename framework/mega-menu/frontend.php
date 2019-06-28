<?php
class dsk_Megamenu_Front extends Walker_Nav_Menu { 
    var $columns = 0;
    var $enablemega = 0;
    var $usepostwcode = '';
    var $postwcode = '';
    var $bgmegacol = '';
    var $customcolumnstyle = '';
    var $thepostwcode = '';

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $uq = rand(1, 1000);
        if($depth === 0 && $this->enablemega){
            $l_content = $style_inline = $class = '';

            if ( $this->postwcode !='' && $this->usepostwcode != '' ) {
                $m_wcode = new WP_Query(array( 'name' => $this->postwcode, 'post_type' => 'post-wcode' ));
                if ($m_wcode->have_posts()) {
                    $class .= ' has-'.esc_attr($this->usepostwcode).'-content';
                    if ( $this->usepostwcode == 'left' ) {
                        $l_content = '<div class="mega-left-content">'. do_shortcode('[dsk_postwcode name="'.esc_attr($this->postwcode).'"]') .'</div>';
                    }
                }
                wp_reset_postdata();
            }
            
            // Background image for Columns tyle
            if( $this->bgmegacol != ''){
                $style_inline .= 'background-image: url('.esc_url($this->bgmegacol).');';
                $class .= ' sub-content-background';
            }
            if ( trim($this->customcolumnstyle) != '' ) {
                $style_inline .= trim($this->customcolumnstyle);
            }
            if ( $style_inline != '' ){
                $style_inline = 'style="'.esc_attr($style_inline).'"';
            }
            $output .= "\n$indent<div id=\"sub_content_$uq\" class=\"sub-content dropdownmenu columns $class\" $style_inline>$l_content <ul class=\"columns {replace_class}\">\n";
        }else{
            $output .= "\n$indent<ul class=\"sub-menu {replace_class}\">\n";
        }
    }
    function end_lvl(&$output, $depth = 0, $args = array()) { 
        $indent = str_repeat("\t", $depth);
        // add menu sidebar
        if($depth === 0 && $this->enablemega){
            $r_b_content = '';
            if ( $this->postwcode !='' && $this->usepostwcode != '' ) {
                $m_wcode = new WP_Query(array( 'name' => $this->postwcode, 'post_type' => 'post-wcode' ));
                if ($m_wcode->have_posts()) {
                    if ( $this->usepostwcode == 'right' ) {
                        $r_b_content = '<div class="mega-right-content">'.do_shortcode('[dsk_postwcode name="'.esc_attr($this->postwcode).'"]').'</div>';
                    }elseif ( $this->usepostwcode == 'bottom' ) {
                        $r_b_content = '<div class="mega-bottom-content">'.do_shortcode('[dsk_postwcode name="'.esc_attr($this->postwcode).'"]').'</div>';
                    }
                }
                wp_reset_postdata();
            }
            $output .= "$indent</ul>$r_b_content</div>\n";
        } else{
            $output .= "$indent</ul>\n";
        }
        if ($depth === 0) {
            if($this->enablemega && $this->columns > 0){
                $output = str_replace("{replace_class}", "enable-megamenu row-fluid col-".$this->columns."", $output);
                $this->columns = 0;
            }
            else{
                $output = str_replace("{replace_class}", "", $output);
            }
        }
    }    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $item_output = $li_text_block_class = $column_class = "";
        if($depth === 0){   
            $this->enablemega = get_post_meta( $item->ID, '_sns_megamenu_item_enable', true);
            $this->usepostwcode = get_post_meta( $item->ID, '_sns_megamenu_item_usepostwcode', true);
            $this->postwcode = get_post_meta( $item->ID, '_sns_megamenu_item_postwcode', true);
            $this->bgmegacol = get_post_meta( $item->ID, '_sns_megamenu_item_background', true);
            $this->customcolumnstyle = get_post_meta( $item->ID, '_sns_megamenu_item_customcolumnstyle', true);
        }
        if($depth === 1 && $this->enablemega) {
            $this->columns ++;
            if( $item->hidetitlemega != true){
                 $title = apply_filters( 'the_title', $item->title, $item->ID );
                if($title != "-" && $title != '"-"'){
                   
                   $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                   $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                   $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';    
            
                   $item_output .= $args->before;
                   $item_output .= '<h4 class="megamenu-title">';
                   if ( get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '' && get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) != '' ) {
                        if ( get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) == 'font' ) {
                            $item_output .='<i class="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'"></i>';
                       }elseif( get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) == 'image' ){
                            $item_output .= '<img class="sns-megamenu-icon-img" src="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'" alt="'.esc_attr($item->title).'"/>';
                       }
                   }
                   $item_output .= '<a'. $attributes .'>';
                   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                   $item_output .= '</a></h4>';
                   $item_output .= $args->after;
               }
            }
        }else{
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';            
        
            $item_output .= $args->before;
            $item_output .= '<a'. $attributes .'><span>';
            if ( get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '' && get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) != '' ) {
                if ( get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) == 'font' ) {
                    $item_output .='<i class="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'"></i>';
               }elseif( get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) == 'image' ){
                    $item_output .= '<img class="sns-megamenu-icon-img" src="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'" alt="'.esc_attr($item->title).'"/>';
               }
            }
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</span></a>';
            $item_output .= $args->after;
        }
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        if( $depth == 0 && $this->enablemega) {
            $class_names .= ' enable-mega';
            if ( !$this->has_children ) {
                $class_names .= ' menu-item-has-children just-postwcode';
                $item_output .= $this->start_lvl($item_output, $depth, $args);
                $item_output .= $this->end_lvl($item_output, $depth, $args);
            }
        }
        if ( get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '' && get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true) != '' ) {
            $class_names .= ' have-icon';
        }
        $class_names = ' class="'.esc_attr($li_text_block_class) . esc_attr( $class_names ) . esc_attr($column_class).'"';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li '.$id . $value . $class_names .'>'; 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
?>