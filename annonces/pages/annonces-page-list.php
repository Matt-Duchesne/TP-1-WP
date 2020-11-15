<?php

// Traitement de la page de liste des annonces
// =========================================== 

/**
 * Création de la page de liste des annonces
 *
 * @param none
 * @return echo html list annonces code
 */
function annonces_html_list_code() {

  /* Affichage d'un lien vers le formulaire de saisie d'une annonce pour l'administrateur du site
     -------------------------------------------------------------------------------------------- */
?>
  <section style="margin: 0 auto; width: 80%; max-width: 100%; padding: 0">
<?php
  global $wpdb;
  if (current_user_can('administrator')) :
    $postmeta = $wpdb->get_row(
                   "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'form'");
?>
    <a href="<?php echo get_permalink($postmeta->post_id)?>">Saisie d'une annonce</a>
<?php					
  endif;

  $annonce_search = '';
  if (isset($_POST['annonce-search'])) :
    $annonce_search = trim($_POST['annonce-search']);
  endif;

  /* Affichage du formulaire de filtrage de annonces 
     ----------------------------------------------- */
?>
    <form style="margin-top: 30px" action="<?= esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
      <input type="text"
             style="display: inline-block; width: 500px; padding: 0 10px; line-height: 50px"
           name="annonce-search"
           placeholder="Filtrer les annonces contenant cette chaîne de caractères"
           value="<?= $annonce_search?>">
      <input type="submit"
             style="display: inline-block; margin-left: 20px; padding: 0 24px; line-height: 50px;"
           name="submitted"
           value="Envoyez">
    </form>
<?php

  /* Affichage de la liste des annonces 
     ---------------------------------- */

  $sql  = "SELECT * FROM $wpdb->prefix"."annonces
       WHERE titre LIKE '%s'
        ORDER BY titre ASC";

  $annonces = $wpdb->get_results($wpdb->prepare($sql, '%'.$annonce_search.'%'));

  if (count($annonces) > 0) :
    $postmeta = $wpdb->get_row(
                   "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'single'");
    $single_permalink = get_permalink($postmeta->post_id);

    $settings = get_option('annonces_settings');

    foreach ($annonces as $annonce) :
?>
    <hr>
    <article style="display: flex">
      <h4 style="margin: 0; width: 300px;">
        <a href="<?php echo $single_permalink.'?page='.stripslashes($annonce->titre).'&id='.$annonce->id?>"><?= stripslashes($annonce->titre) ?></a>
      </h4>
      <div>
<?php
      if (isset($settings['view_marque']) && $settings['view_marque'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">Marque:</p>
          <p style="padding: 5px"><?= stripslashes(nl2br($annonce->marque)) ?></p>
        </div>
<?php
      endif;
      if (isset($settings['view_modele']) && $settings['view_modele'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">modèle:</p>
          <p style="padding: 5px"><?= stripslashes(nl2br($annonce->modele)) ?></p>
        </div>
        <?php
      endif;
      if (isset($settings['view_couleur']) && $settings['view_couleur'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">couleur:</p>
          <p style="padding: 5px"><?= stripslashes(nl2br($annonce->couleur)) ?></p>
        </div>
<?php
      endif;
      if (isset($settings['view_annee_mec']) && $settings['view_annee_mec'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">année de mise en circulation:</p>
          <p style="padding: 5px"><?= $annonce->annee_mec ?></p>
        </div>
        <?php
      endif;
      if (isset($settings['view_kilometrage']) && $settings['view_kilometrage'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">kilométrage:</p>
          <p style="padding: 5px"><?= $annonce->kilometrage ?> km</p>
        </div>
        <?php
      endif;
      if (isset($settings['view_prix']) && $settings['view_prix'] === 'yes') :
?>
        <div style="display: flex">
          <p style="width:250px; padding: 5px; color: #777">Prix:</p>
          <p style="padding: 5px"><?= $annonce->prix ?> crédits imperiaux</p>
        </div>
<?php
      endif;
?>
      </div>
    </article>	
<?php
    endforeach;
?>
    </table>
<?php
  else :
?>
    <p>Aucune annonce n'est enregistrée.</p>
<?php
  endif;
?>
  </section>
<?php
}

/**
 * Exécution du code court (shortcode) d'affichage de la liste des annonces
 *
 * @param none
 * @return the content of the output buffer (end output buffering)
 */
function annonces_shortcode_list() {
  ob_start(); // temporisation de sortie
  annonces_html_list_code();
  return ob_get_clean(); // fin de la temporisation de sortie pour l'envoi au navigateur
}

// créer un shortcode pour afficher la liste des annonces
add_shortcode( 'annonces_list', 'annonces_shortcode_list' );