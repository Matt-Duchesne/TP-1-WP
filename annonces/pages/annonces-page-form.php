<?php
/**
 * Pour retourner le role de l'utilisateur 
 * si
 * il y a une connexion 
 */
function annonces_get_current_user_roles() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        return $roles[0];
    } 
    else 
    {
    return array();
    }
}

function annonces_get_current_username() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $names = ( array ) $user->display_name;
        return $names[0];
    } 
    else 
    {
    return array();
    }
}

/**
* Création du formulaire de saisie d'une annonce
*
* @param none
* @return echo html form annonce code
*/

function html_form_annonce() {
?>
    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
        <label>Titre de l'annonce</label>
        <input type="text" name="titre" required>
        <label>Marque</label>
        <input type="text" name="marque" placeholder="Entrez la marque" required>
        <label>Modele</label>
        <input type="text" name="modele" placeholder="Entrez le modèle" required>
        <label>Couleur</label>
        <input type="text" name="couleur" placeholder="Entrez la couleur" required>
        <label>Annee de mise en circulation</label>
        <input type="text" name="annee_mec" placeholder="Entrez l'annee de mise en circulation" required>
        <label>Kilometrage</label>
        <input type="text" name="kilometrage" placeholder="Entrez le kilometrage" required>
        <label>Prix</label>
        <input type="text" name="prix" placeholder="Entrez le prix" required>

        <input type="submit" name="submitted" value="Envoyez">
        <?php wp_nonce_field( 'ajouter_annonce', 'nonce_annonce' ); ?>
    </form>
<?php

$date = get_the_date();

echo "<pre>".print_r($date, true)."</pre>";
}

/**
 * Insertion d'une annonce dans la table
 *
 * @param none
 * @return none
 */

function insert_annonce() {
    // si le bouton submit est cliqué
    if (isset( $_POST['submitted'] ) ) {
        if ( wp_verify_nonce($_POST['nonce_annonce'], 'ajouter_annonce') ) {
         // assainir les valeurs du formulaire
        $titre = sanitize_text_field( $_POST["titre"] );
        $marque = sanitize_text_field( $_POST["marque"] );
        $modele = sanitize_text_field( $_POST["modele"] );
        $couleur = sanitize_text_field( $_POST["couleur"] );
        $annee_mec = filter_var($_POST['annee_mec'], FILTER_SANITIZE_NUMBER_INT);
        $kilometrage = filter_var($_POST['kilometrage'], FILTER_SANITIZE_NUMBER_INT);
        $prix = filter_var($_POST['prix'], FILTER_SANITIZE_NUMBER_INT);

        // insertion dans la table
        global $wpdb;
        $oCurrentUser = annonces_get_current_user_roles();
        $oCurrentUserName = annonces_get_current_username();
        $date = get_the_date();

        // filter_var($_POST['annee_mec'], FILTER_SANITIZE_NUMBER_INT);
        $wpdb->insert($wpdb->prefix.'annonces',
                array(  'titre' => $titre, 
                        'marque' => $marque,
                        'modele' => $modele,
                        'couleur' => $couleur,
                        'annee_mec' => $annee_mec, 
                        'kilometrage' => $kilometrage,
                        'prix' => $prix,
                        'auteur' => $oCurrentUserName,
                        'date_creation' => $date),
                array('%s','%s','%s','%s','%d','%d','%d','%s','%s')
        );

    ?> <p>Votre annonce a été ajoutée</p><?php
    } else {
    ?> <p>Votre annonce n'a PAS été enregistrée</p><?php
        }
    }
}

/**
 * Exécution du code court (shortcode) de saisie d'une annonce 
 *
 * @param none
 * @return the content of the output buffer (end output buffering)
 */

function shortcode_input_annonce() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    insert_annonce();
    html_form_annonce();
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'saisie_annonce', 'shortcode_input_annonce' );

