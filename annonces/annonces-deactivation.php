<?php 

// Désactivation de l'extension
// ============================

register_deactivation_hook( ANNONCES_PLUGIN_FILE, 'annonces_deactivate' );
 

/**
* Traitements à la désactivation de l'extension
*
* @param none
* @return none
*/
function annonces_deactivate() {
    annonces_delete_pages();
}

/**
* Suppression des pages de l'extension
*
* @param none
* @return none
*/
function annonces_delete_pages(){
    global $wpdb;
    $postmetas= $wpdb->get_results(
                "SELECT * FROM $wpdb->postmeta WHERE meta_key= 'annonces'");
    $force_delete= true;
    foreach($postmetas as $postmeta) {
        wp_delete_post( $postmeta->post_id, $force_delete);
    }
}
