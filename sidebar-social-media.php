<div class="pix-sidebar_links social_media">
  <?php
    $sidebar_id = 'sidebar-7';
    $sidebars_widgets = wp_get_sidebars_widgets();
    $widget_ids = $sidebars_widgets[$sidebar_id]; 
    foreach( $widget_ids as $id ) {
        $wdgtvar = 'widget_'._get_widget_id_base( $id );
        $idvar = _get_widget_id_base( $id );
        $instance = get_option( $wdgtvar );
        $idbs = str_replace( $idvar.'-', '', $id );
        echo '<li><a target="_blank" rel="noopener" href="'.$instance[$idbs]['text'].'">'.$instance[$idbs]['title'].'</a></li>';
    }
  ?>
</div>