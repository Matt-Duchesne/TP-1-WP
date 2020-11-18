<?php 
/* 
Plugin Name: Annonces auto
Plugin URI: https://annonces-auto.plugins.com
Description: Publication et gestion d'annonces auto
Version: 0.1
Author: Mathieu Duchesne et Vincent LaPointe Lamy
Author URI: https://cmaisonneuve.omnivox.ca
*/

define('ANNONCES_PLUGIN_FILE', __FILE__);

require_once ("annonces-settings.php");          // gestion des réglages dans l'administration

require_once ("annonces-activation.php");        // activation du plugin
require_once ("annonces-deactivation.php");      // désactivation du plugin
require_once ("annonces-uninstall.php");         // désinstallation du plugin 

require_once ("annonces-widgets.php");           // prise en compte des widgets 

require_once ("annonces-hooks-filters.php");     // prise en compte des crochets de filtres

require_once ("pages/annonces-page-form.php");   // gestion formulaire de création d'une annonce 
require_once ("pages/annonces-page-modif.php");  // gestion formulaire de modification d'une annonce 
require_once ("pages/annonces-page-list.php");   // gestion page de liste des annonces
require_once ("pages/annonces-page-single.php"); // gestion page détail d'une annonce



function html_afficher_annonces() {
    global $wpdb;
    $postmeta = $wpdb->get_row(
        "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'form'");
        $form_permalink = get_permalink($postmeta->post_id);    
        ?>
        <a href="<?= $form_permalink?>">Ajout d'une annonce</a>
    <?php
    $sql  = "SELECT * FROM $wpdb->prefix"."annonces";
    $annonces = $wpdb->get_results($sql);
    foreach ($annonces as $annonce){  
    ?>
        <p><?=$annonce->titre?></p>
        <p>Marque: <?=$annonce->marque?></p>
        <p><?=$annonce->modele?></p>
        <p><?=$annonce->couleur?></p>
        <p><?=$annonce->annee_mec?></p>
        <p><?=$annonce->kilometrage?></p>
        <p><?=$annonce->prix?></p>

    <hr>
    <?php
    }    
         
}

function shortcode_afficher_annonces() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    html_afficher_annonces();
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'afficher_annonces', 'shortcode_afficher_annonces' );






