<?php 
/* 
Plugin Name: Annonces auto
Plugin URI: https://annonces-auto.plugins.com
Description: Publication et gestion d'annonces auto
Version: 1.0
Author: Mathieu Duchesne
Author URI: https://annonces-auto.com
*/
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
}

function insert_annonce() {
    // si le bouton submit est cliqué
    if (isset( $_POST['submitted'] ) ) {
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
        $wpdb->insert($wpdb->prefix.'annonces',
                array('titre' => $titre, 'marque' => $marque,
                'modele' => $modele,'couleur' => $couleur,
                'annee_mec' => $annee_mec, 'kilometrage' => $kilometrage, 'prix' => $prix),
                array('%s','%s','%s','%s','%d','%s','%s')
        );

    ?> <p>Votre annonce a été ajoutée</p><?php
    } else {
    ?> <p>Votre annonce n'a PAS été enregistrée</p><?php
        }
    }
}

function shortcode_input_annonce() {
    ob_start(); // temporisation dans un buffer (mémoire tampon) de l'envoi du code HTML
    insert_annonce();
    html_form_annonce();
    return ob_get_clean(); // fin de la temporisation, retour du buffer au programme appelant
    }
    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'saisie_annonce', 'shortcode_input_annonce' );


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
        `marque` varchar(25) NOT NULL,
        `modele` varchar(25) NOT NULL,
        `couleur` varchar(25) NOT NULL,
        `annee_mec` smallint NOT NULL,
        `kilometrage` varchar(25) NOT NULL,
        `prix` varchar(25) NOT NULL,
        `auteur` varchar(50) NOT NULL,
        `date_creation` date NOT NULL,
        PRIMARY KEY (`id`)
      ) ".$wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    };


    