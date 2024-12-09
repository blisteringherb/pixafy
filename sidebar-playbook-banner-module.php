<?php
    $sidebar_id = 'sidebar-8';
    $sidebars_widgets = wp_get_sidebars_widgets();
    $widget_ids = $sidebars_widgets[$sidebar_id]; 
    foreach( $widget_ids as $id ):
        $wdgtvar = 'widget_'._get_widget_id_base( $id );
        $idvar = _get_widget_id_base( $id );
        $instance = get_option( $wdgtvar );
        $idbs = str_replace( $idvar.'-', '', $id );

 ?>

 <section id="pix-banner_module_section" class="pix-banner_module_section hero-section parallax-section-1" style="background-image:url(<?php echo $instance[$idbs]['text']; ?>);">
    <div class="featured-text pix-banner_module_wrapper">
        <!--<img class="pix-banner_module_image" src="<?php //echo get_field('banner_image'); ?>" title="<?php ?>" alt="<?php  ?>" />-->
        <h1 class="pix-banner_module_header pix-copy_left_aligned">
            <?php echo $instance[$idbs]['title']; ?>
        </h1>
    </div>
</section>

<?php
    endforeach;
?>