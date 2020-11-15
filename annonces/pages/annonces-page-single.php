<?php

// Traitement de la page de single des annonces
// =========================================== 

/**
 * Création de la page de single des annonces
 *
 * @param none
 * @return echo html single annonces code
 */
function annonces_html_single_code() {


    global $wpdb;
    $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'list'");
  ?>
   <?php	

  /* Affichage de une annonces 
     ---------------------------------- */

     $annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
     $sql = "SELECT * FROM $wpdb->prefix"."annonces WHERE id =%d";
     
     $annonce = $wpdb->get_row($wpdb->prepare($sql, $annonce_id));
     if ($annonce !== null) :
   ?>
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">titre:</p>
         <p style="padding: 5px"><?= stripslashes(nl2br($annonce->titre)) ?></p>
       </div><div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">marque:</p>
         <p style="padding: 5px"><?= stripslashes(nl2br($annonce->marque)) ?></p>
       </div>
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">modele:</p>
         <p style="padding: 5px"><?= stripslashes(nl2br($annonce->modele)) ?></p>
       </div>       
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">couleur:</p>
         <p style="padding: 5px"><?= stripslashes(nl2br($annonce->couleur)) ?></p>
       </div>
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">année de mise en circulation:</p>
         <p style="padding: 5px"><?= $annonce->annee_mec ?> </p>
       </div>
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">kilometrage:</p>
         <p style="padding: 5px"><?= $annonce->kilometrage ?> km</p>
       </div>       
       <div style="display: flex">
         <p style="width:250px; padding: 5px; color: #777">prix:</p>
         <p style="padding: 5px"><?= $annonce->prix ?> $</p>
       </div>
   <?php
     else :
   ?>
       <p>Cette annonce n'est pas enregistrée.</p>
   <?php
     endif;
     ?>
     </section>
   <?php
   }

/**
 * Exécution du code court (shortcode) d'affichage d'une annonce
 *
 * @param none
 * @return the content of the output buffer (end output buffering)
 */
function annonces_shortcode_single() {
  ob_start(); // temporisation de sortie
  annonces_html_single_code();
  return ob_get_clean(); // fin de la temporisation de sortie pour l'envoi au navigateur
}

// créer un shortcode pour afficher une annonce
add_shortcode( 'annonces_single', 'annonces_shortcode_single' );