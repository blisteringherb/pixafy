<div class="pix-price_copy_wrapper">
    <?php
        $sidebar_id = 'sidebar-13';
        $sidebars_widgets = wp_get_sidebars_widgets();
        $widget_ids = $sidebars_widgets[$sidebar_id]; 
        foreach( $widget_ids as $id ):
            $wdgtvar = 'widget_'._get_widget_id_base( $id );
            $idvar = _get_widget_id_base( $id );
            $instance = get_option( $wdgtvar );
            $idbs = str_replace( $idvar.'-', '', $id );
     ?>
    	<article class="pix-price_copy_article">
            <div class="pix-price_copy_title"><?php echo $instance[$idbs]['title']; ?></div>
            <div class="pix-price_copy"><?php echo $instance[$idbs]['text']; ?></div>
        </article>

    <?php
        endforeach;
    ?>
</div>