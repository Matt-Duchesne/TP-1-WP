<?php

/**
* Création du formulaire de suppression d'une annonce
*
* @param none
* @return echo html form annonce code
*/

function annonces_html_delete_code() {

global $wpdb;
    $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'single'");
 
    $annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
     $sql = "SELECT * FROM $wpdb->prefix"."annonces WHERE id =%d";
     
     $annonce = $wpdb->get_row($wpdb->prepare($sql, $annonce_id));
     if ($annonce !== null) :

?>
    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <label>Titre de l'annonce</label>
            <input type="text" name="titre" value=<?=$annonce->titre?> readonly>
            <label>Marque</label>
            <input type="text" name="marque" value=<?=$annonce->marque?> readonly>
            <label>Modele</label>
            <input type="text" name="modele" value=<?=$annonce->modele?> readonly>
            <label>Couleur</label>
            <input type="text" name="couleur" value=<?=$annonce->couleur ?> readonly>
            <label>Annee de mise en circulation</label>
            <input type="number" name="annee_mec" value=<?=$annonce->annee_mec?> readonly>
            <label>Kilometrage</label>
            <input type="text" name="kilometrage" value=<?=$annonce->kilometrage?> readonly>
            <label>Prix</label>
            <input type="text" name="prix" value=<?=$annonce->prix?> readonly>

            <label>Voulez-vous supprimer cette annonce?</label>
            <input type="submit" name="delete" value="Supprimer?">
            <?php wp_nonce_field( 'delete_annonce', 'nonce_annonce' ); ?>
    </form>


<?php
     else :
?>
       <p>Il n'y a aucune annonce à supprimer</p>
<?php
     endif;
?>
     </section>
<?php
}

/**
 * Suppression d'une annonce dans la table
 *
 * @param none
 * @return none
 */

// si le bouton supprimer est cliqué

    function delete_annonce() {
        if (isset( $_POST['delete'])){
            if ( wp_verify_nonce($_POST['nonce_annonce'], 'delete_annonce')) {
            // Suppression de l'entrée
                global $wpdb;
                $annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
                $sql = "DELETE * FROM $wpdb->prefix"."annonces WHERE id =%d";   
                $wpdb->delete('wp_annonces', array('id' => $annonce_id ))

            ?> <p>Votre annonce a été supprimée</p><?php
            } else {
            ?> <p>Votre annonce n'a pas été supprimée</p><?php
                }
            }
}

/**
 * Exécution du code court (shortcode) de suppression d'une annonce 
 *
 * @param none
 * @return the content of the output buffer (end output buffering)
 */

function shortcode_delete_annonce() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    delete_annonce();
    annonces_html_delete_code();
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'delete_annonce', 'shortcode_delete_annonce' );

