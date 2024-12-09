<?php
    $sidebar_id = 'sidebar-11';
    $sidebars_widgets = wp_get_sidebars_widgets();
    $widget_ids = $sidebars_widgets[$sidebar_id]; 
    foreach( $widget_ids as $id ):
        $wdgtvar = 'widget_'._get_widget_id_base( $id );
        $idvar = _get_widget_id_base( $id );
        $instance = get_option( $wdgtvar );
        $idbs = str_replace( $idvar.'-', '', $id );
 ?>

<article class="pix-terms_of_conditions_wrapper">
	<h4 class="pix_jed_form_header"><?php echo $instance[$idbs]['title']; ?></h4>
	<div class="pix-jed_form_copy"><?php echo $instance[$idbs]['text']; ?></div>
</article>

<?php
    endforeach;
?>