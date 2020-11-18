<?php 

/**
* Page de modification d'une annonce
*
*@param none
*@return echo modification de l'annonce
*/


$annonce_id = isset($_GET['id']) ? $_GET['id'] : null;
$sql = "SELECT * FROM $wpdb->prefix"."annonces WHERE id =%d";
$annonce = $wpdb->get_row($wpdb->prepare($sql, $annonce_id));

function html_form_annonce_modif() {
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
            <?php wp_nonce_field( 'ajouter_annonce', 'nonce_annonce' ); ?>
        </form>
    <?php
}



function modif_annonce() {
    // si le bouton submit est cliqué
    if (isset( $_POST['update'] ) ) {
        if ( wp_verify_nonce($_POST['nonce_annonce'], 'ajouter_annonce') ) {
         // assainir les valeurs du formulaire
        $titre = sanitize_text_field( $_POST["titre"] );
        $marque = sanitize_text_field( $_POST["marque"] );
        $modele = sanitize_text_field( $_POST["modele"] );
        $couleur = sanitize_text_field( $_POST["couleur"] );
        $annee_mec = sanitize_text_field( $_POST["annee_mec"] );
        $kilometrage = sanitize_text_field( $_POST["kilometrage"] );
        $prix = sanitize_text_field( $_POST["prix"] );
        // insertion dans la table
        global $wpdb;
        $wpdb->update($wpdb->prefix.'annonces',
                array('titre' => $titre, 'marque' => $marque,
                'modele' => $modele,'couleur' => $couleur,
                'annee_mec' => $annee_mec, 'kilometrage' => $kilometrage, 'prix' => $prix),
                array('%s','%s','%s','%s','%d','%s','%s')
        );

    ?> <p>Votre annonce a été modifiée</p><?php
    } else {
    ?> <p>Votre annonce n'a pas été modifiée</p><?php
        }
    }
}


function shortcode_modif_annonce() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'modif_annonce', 'shortcode_modif_annonce' );

?>