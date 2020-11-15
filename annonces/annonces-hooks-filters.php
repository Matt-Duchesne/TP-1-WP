<?php

// Utilisation de crochets de filtres
// ==================================

/**
 * Ajoute le nom de l'annonce dans le titre via le crochet de filtres the_title
 * pour la page "Recette" uniquement, identifiée par la métadonnée annonces = single
 * @param string  $titre    The current titre
 * @param int     $post_id  The current post ID
 * @return string $titre 
 */
function annonces_hook_the_title($titre, $post_id) {
  $single = true;
  $annonces = get_post_meta($post_id, 'annonces', $single);
  if ($annonces === 'single' && isset($_GET['id'])) {
    global $wpdb;
    $sql = "SELECT titre FROM $wpdb->prefix"."annonces WHERE id =%d";
    $annonce = $wpdb->get_row($wpdb->prepare($sql, $_GET['id']));
    $titre .= ':<br>'.stripslashes($annonce->titre);
  }
  return $titre;
}

// Ajout de la fonction annonces_titre au crochet de filtres the_title 	
add_filter( 'the_title', 'annonces_hook_the_title', 10, 2 );