<?php

// l'exécution du hook 'admin_menu' sert à compléter le panneau d'administration,
// pour les extensions et les thèmes
add_action( 'admin_menu', 'annonces_add_menu_page' );

/**
 * Ajout de la page formulaire des réglages dans le panneau d'administration,
 * et ajout d'une action d'initialisation du traitement de cette page au crochet 'admin_init' 
 *
 * @param none
 * @return none
 */
function annonces_add_menu_page() {
  add_menu_page(
    'Réglages de l\'extension annonces',	// balise title de la page des réglages 
    'annonces',                          // texte de menu de la page des réglages
                                            // dans le menu latéral gauche
    'administrator',                        // capacité pour afficher cette page
     'annonces-settings-page',           // slug dans l'url de la page
    'annonces_settings_page');           // fonction d'affichage de la page
    
  // l'exécution du hook 'admin_init' sert à initialiser le traitement de la page des réglages,
  // avant l'affichage du panneau d'administration
  add_action( 'admin_init', 'annonces_register_setting' );
}

/**
 * Initialisation du traitement de la page formulaire des réglages 
 *
 * @param none
 * @return none
 */
function annonces_register_setting() {
  register_setting(
      'annonces_option_group',     // nom de la zone des réglages, associée
                                      // à la saisie des valeurs de l'option
      'annonces_settings',         // nom de l'option des réglages
      'annonces_sanitize_option'); // fonction pour assainir les valeurs de l'option des réglages
}

/**
 * Assainissement des valeurs de l'option renvoyées par le formulaire des réglages
 *
 * @param none
 * @return none
 */
function annonces_sanitize_option( $input ) {
  $input['view_marque']  = sanitize_text_field( $input['view_marque'] );
  $input['view_modele'] = sanitize_text_field( $input['view_modele'] );
  $input['view_couleur']    = sanitize_text_field( $input['view_couleur'] );
  $input['view_annee_mec']    = sanitize_text_field( $input['view_annee_mec'] );
  $input['view_kilometrage']    = sanitize_text_field( $input['view_kilometrage'] );
  $input['view_prix']    = sanitize_text_field( $input['view_prix'] );
  return $input;
}

/**
 * Affichage de la page du formulaire des réglages
 *
 * @param none
 * @return none
 */
function annonces_settings_page() {
?>
  <div class="wrap">
    <h2>Réglages de annonces</h2>
    <form method="post" action="options.php">
    <?php settings_fields( 'annonces_option_group' ); // génération de balises input cachés pour faire le lien
                                                         // avec la fonction register_setting par le paramètre option_group ?>
    <?php $annonces_settings = get_option( 'annonces_settings' ); ?>
    <h3>Visibilité des rubriques sur la page de liste</h3>
      <table class="form-table">
        <tr>
          <th scope="row">Marque</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_marque]" value="yes"
                <?php checked( !isset( $annonces_settings['view_marque']) || $annonces_settings['view_marque'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_marque]" value="no"
                <?php checked( isset( $annonces_settings['view_marque']) && $annonces_settings['view_marque'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr>
        <tr>
          <th scope="row">modèle</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_modele]" value="yes"
                <?php checked( !isset( $annonces_settings['view_modele']) || $annonces_settings['view_modele'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_modele]" value="no"
                <?php checked( isset( $annonces_settings['view_modele']) && $annonces_settings['view_modele'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr>
        <tr>
          <th scope="row">couleur</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_couleur]" value="yes"
                <?php checked( !isset( $annonces_settings['view_couleur']) || $annonces_settings['view_couleur'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_couleur]" value="no"
                <?php checked( isset( $annonces_settings['view_couleur']) && $annonces_settings['view_couleur'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr>
        <tr>
          <th scope="row">année de mise en circulation</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_annee_mec]" value="yes"
                <?php checked( !isset( $annonces_settings['view_annee_mec']) || $annonces_settings['view_annee_mec'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_annee_mec]" value="no"
                <?php checked( isset( $annonces_settings['view_annee_mec']) && $annonces_settings['view_annee_mec'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr><tr>
          <th scope="row">kilométrage</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_kilometrage]" value="yes"
                <?php checked( !isset( $annonces_settings['view_kilometrage']) || $annonces_settings['view_kilometrage'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_kilometrage]" value="no"
                <?php checked( isset( $annonces_settings['view_kilometrage']) && $annonces_settings['view_kilometrage'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr><tr>
          <th scope="row">Prix</th>
          <td>
            <p>
              <input type="radio" name="annonces_settings[view_prix]" value="yes"
                <?php checked( !isset( $annonces_settings['view_prix']) || $annonces_settings['view_prix'] === 'yes' ) ?>>
              oui
              <br>	   
              <input type="radio" name="annonces_settings[view_prix]" value="no"
                <?php checked( isset( $annonces_settings['view_prix']) && $annonces_settings['view_prix'] === 'no' ) ?>>
              non
            </p>
          </td>
        </tr>
      </table>
      <pre><?php // print_r($annonces_settings); ?></pre>
      <p class="submit">
        <input type="submit" class="button-primary" value="Enregistrer les modifications">
      </p>
    </form>
  </div>	
 <?php
 }