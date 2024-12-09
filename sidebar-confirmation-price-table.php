<div class="pix-price_table_wrapper">
    <header class="pix-price_table_header">
        <div class="pix-price_table_cell left"><?php echo 'Program'; ?></div>
        <div class="pix-price_table_cell right"><?php echo 'Program Cost'; ?></div>
    </header>
    <div class="pix-price_table">
        <?php
            $sidebar_id = 'sidebar-12';
            $sidebars_widgets = wp_get_sidebars_widgets();
            $widget_ids = $sidebars_widgets[$sidebar_id]; 
            foreach( $widget_ids as $id ):
                $wdgtvar = 'widget_'._get_widget_id_base( $id );
                $idvar = _get_widget_id_base( $id );
                $instance = get_option( $wdgtvar );
                $idbs = str_replace( $idvar.'-', '', $id );
         ?>
        	<div class="pix-price_table_row">
                <div class="pix-price_table_cell left"><?php echo $instance[$idbs]['title']; ?></div>
                <div class="pix-price_table_cell right"><?php echo $instance[$idbs]['text']; ?></div>
            </div>
        <?php
            endforeach;
        ?>
    </div>
</div>