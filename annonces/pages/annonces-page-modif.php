<?php


/**
* Création du formulaire de modification d'une annonce
*
* @param none
* @return echo html form annonce code
*/


function annonces_html_modif_code() {

global $wpdb;
    $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'single'");
 
    $annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
     $sql = "SELECT * FROM $wpdb->prefix"."annonces WHERE id =%d";
     
     $annonce = $wpdb->get_row($wpdb->prepare($sql, $annonce_id));
     if ($annonce !== null) :

?>
    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <label>Titre de l'annonce</label>
            <input type="text" name="titre" value=<?=$annonce->titre?> required>
            <label>Marque</label>
            <input type="text" name="marque" value=<?=$annonce->marque?> required>
            <label>Modele</label>
            <input type="text" name="modele" value=<?=$annonce->modele?> required>
            <label>Couleur</label>
            <input type="text" name="couleur" value=<?=$annonce->couleur ?> required>
            <label>Annee de mise en circulation</label>
            <input type="number" name="annee_mec" value=<?=$annonce->annee_mec?> required>
            <label>Kilometrage</label>
            <input type="text" name="kilometrage" value=<?=$annonce->kilometrage?> required>
            <label>Prix</label>
            <input type="text" name="prix" value=<?=$annonce->prix?> required>
    
            <input type="submit" name="update" value="Mettre à jour">
            <?php wp_nonce_field( 'modifier_annonce', 'nonce_annonce' ); ?>
        </form>


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
 * Modification d'une annonce dans la table
 *
 * @param none
 * @return none
 */

function update_annonce() {
    // si le bouton submit est cliqué
    if (isset( $_POST['update'] ) ) {
        if ( wp_verify_nonce($_POST['nonce_annonce'], 'modifier_annonce') ) {

         // assainir les valeurs du formulaire
        $titre = sanitize_text_field( $_POST["titre"] );
        $marque = sanitize_text_field( $_POST["marque"] );
        $modele = sanitize_text_field( $_POST["modele"] );
        $couleur = sanitize_text_field( $_POST["couleur"] );
        $annee_mec = sanitize_text_field( $_POST["annee_mec"] );
        $kilometrage = sanitize_text_field( $_POST["kilometrage"] );
        $prix = sanitize_text_field( $_POST["prix"] );

        // Modification dans la table
        global $wpdb;
        $oCurrentUser = annonces_get_current_user_roles();
        $annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
        $sql = "SELECT * FROM $wpdb->prefix"."annonces WHERE id =%d";

        $wpdb->update($wpdb->prefix.'annonces',
                array(  'titre' => $titre, 
                        'marque' => $marque,
                        'modele' => $modele,
                        'couleur' => $couleur,
                        'annee_mec' => $annee_mec, 
                        'kilometrage' => $kilometrage, 
                        'prix' => $prix,
                        'auteur' => $oCurrentUser),
                array('id' => $annonce_id), 
                array('%s','%s','%s','%s','%d','%s','%s','%s'),
                array('%d')
        );

    ?> <p>Votre annonce a été modifiée</p><?php
    } else {
    ?> <p>Votre annonce n'a PAS été enregistrée</p><?php
        }
    }
}

/**
 * Exécution du code court (shortcode) de modification d'une annonce 
 *
 * @param none
 * @return the content of the output buffer (end output buffering)
 */

function shortcode_modif_annonce() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    update_annonce();
    annonces_html_modif_code();
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'modif_annonce', 'shortcode_modif_annonce' );

