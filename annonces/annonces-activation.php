<?php

// Activation de l'extension
// =========================

register_activation_hook( ANNONCES_PLUGIN_FILE, 'annonces_activate' );

/**
* Traitements à l'activation de l'extension
*
* @param none
* @return none
*/
function annonces_activate() {
    annonces_check_version();
    annonces_create_table();
    annonces_default_settings();
    annonces_create_pages();
}
/**
 * Vérification de la version WP
 *
 * @param none
 * @return none
 */
function annonces_check_version() {
    global $wp_version;
    if ( version_compare( $wp_version, '5.1', '<' ) ) {
      wp_die( 'Cette extension requiert WordPress version 5.1 ou plus.' );
    }
  }

/**
* Création de la table annonces
*
* @param none
* @return none
*/
function annonces_create_table() {
    global $wpdb;
    $sql = "CREATE TABLE $wpdb->prefix"."annonces (
        `id` smallint NOT NULL AUTO_INCREMENT,
        `titre` varchar(150) NOT NULL,
        `marque` varchar(25) NOT NULL,
        `modele` varchar(25) NOT NULL,
        `couleur` varchar(25) NOT NULL,
        `annee_mec` smallint NOT NULL,
        `kilometrage` varchar(25) NOT NULL,
        `prix` varchar(25) NOT NULL,
        `auteur` varchar(50) NOT NULL,
        `date_creation` varchar(25) NOT NULL,
        PRIMARY KEY (`id`)
      ) ".$wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    };

/**
 * Initialisation de l'option annonces_settings,
 * qui regroupe un tableau de réglages pour l'affichage des rubriques sur la page de liste
 *
 * @param none
 * @return none
 */
function annonces_default_settings() {
  add_option(
    'annonces_settings',
    array(
      'view_marque'  => 'yes',
      'view_modele' => 'yes',
      'view_couleur'    => 'yes',
      'view_annee_mec'    => 'yes',
      'view_kilometrage'    => 'yes',
      'view_prix'    => 'yes',
      'view_date'    => 'yes'
    )	
  );
}
    
/**
*Création des pages de l'extension
*
* @param none
* @return none
*/
function annonces_create_pages(){
  $annonces_page = array(
      'post_title' => "Saisie d'une annonce",
      'post_name' => "saisie-annonce",
      'post_content' => "[saisie_annonce]",
      'post_type' => 'page',
      'post_status' => 'publish',
      'comment_status' => 'closed',
      'ping_status' => 'closed',
      'meta_input' => array('annonces' => 'form')
  );
  wp_insert_post($annonces_page);

  $annonces_page = array(
      'post_title' => "Afficher la liste des annonces",
      'post_name' => "afficher-annonces",
      'post_content' => "[annonces_list]",
      'post_type' => 'page',
      'post_status' => 'publish',
      'comment_status' => 'closed',
      'ping_status' => 'closed',
      'meta_input' => array('annonces' => 'liste')
  );
  wp_insert_post($annonces_page);

  $annonces_page = array(
    'post_title'     => "Annonce unique",
    'post_name'      => "annonce", 
    'post_content'   => "[annonces_single]",
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
    'meta_input'     => array('annonces' => 'single')
  );
  wp_insert_post($annonces_page);

  $annonces_page = array(
    'post_title' => "Modification d'une annonce",
    'post_name' => "modif-annonce",
    'post_content' => "[modif_annonce]",
    'post_type' => 'page',
    'post_status' => 'publish',
    'comment_status' => 'closed',
    'ping_status' => 'closed',
    'meta_input' => array('annonces' => 'modif')
);
wp_insert_post($annonces_page);

$annonces_page = array(
  'post_title' => "Suppression d'une annonce",
  'post_name' => "delete-annonce",
  'post_content' => "[delete_annonce]",
  'post_type' => 'page',
  'post_status' => 'publish',
  'comment_status' => 'closed',
  'ping_status' => 'closed',
  'meta_input' => array('annonces' => 'delete')
);
wp_insert_post($annonces_page);
}