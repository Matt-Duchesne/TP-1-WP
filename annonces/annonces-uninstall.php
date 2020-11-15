<?php

// Désinstallation de l'extension
// ==============================
 
register_uninstall_hook(ANNONCES_PLUGIN_FILE, 'annonces_uninstall');


/**
 * Traitements à la désinstallation de l'extension
 *
 * @param none
 * @return none
 */
function annonces_uninstall() {
    annonces_drop_table();
    annonces_delete_settings();
  }
/**
* Suppression de la table recipes
*
* @param none
* @return none
*/

function annonces_drop_table() {
    global $wpdb;
    $sql = "DROP TABLE $wpdb->prefix"."annonces";
    $wpdb->query($sql);
}
 
/**
 * Suppression de l'option annonces_settings
 *
 * @param none
 * @return none
 */
function annonces_delete_settings() {
    delete_option('annonces_settings');
  }