<?php 
/* 
Plugin Name: Annonces auto
Plugin URI: https://annonces-auto.plugins.com
Description: Publication et gestion d'annonces auto
Version: 1.0
Author: Mathieu Duchesne et Vincent LaPointe Lamy
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
        <input type="number" name="annee_mec" placeholder="Entrez l'annee de mise en circulation" required>
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
        `titre` varchar(150) NOT NULL,
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

/**
* Traitements à l'activation de l'extension
*
* @param none
* @return none
*/
function annonces_activate() {
    annonces_create_table();
    annonces_create_pages();
}

register_activation_hook( __FILE__, 'annonces_activate' );

/**
* Suppression de la table recipes
*
* @param none
* @return none
*/

function annonces_drop_table() {
    global $wpdb;
    $sql = "DROP TABLE $wpdb->prefix"."annonces";
    $wpdb->query($sql);
}
  
/**
* Traitements à la désinstallation de l'extension
*
* @param none
* @return none
*/
function annonces_uninstall() {
    annonces_drop_table();
}

register_uninstall_hook(__FILE__, 'annonces_uninstall');

/**
*Création des pages de l'extension
*
* @param none
* @return none
*/
function annonces_create_pages(){
    $annonces_page = array(
        'post_title' => "Saisie d'une annonce",
        'post_name' => "saisie-annonce",
        'post_content' => "[saisie_annonce]",
        'post_type' => 'page',
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'meta_input' => array('annonces' => 'form')
    );
    wp_insert_post($annonces_page);

    $annonces_page = array(
        'post_title' => "Afficher les annonces",
        'post_name' => "afficher-annonces",
        'post_content' => "[afficher_annonces]",
        'post_type' => 'page',
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'meta_input' => array('annonces' => 'liste')
    );
    wp_insert_post($annonces_page);


}

/**
* Suppression des pages de l'extension
*
* @param none
* @return none
*/
function annonces_delete_pages(){
    global $wpdb;
    $postmetas= $wpdb->get_results(
                "SELECT * FROM $wpdb->postmeta WHERE meta_key= 'annonces'");
    $force_delete= true;
    foreach($postmetas as $postmeta) {
        wp_delete_post( $postmeta->post_id, $force_delete);
    }
}
/**
* Traitements à la désactivation de l'extension
*
* @param none
* @return none
*/
function annonces_deactivate() {
    annonces_delete_pages();
}
register_deactivation_hook(__FILE__, 'annonces_deactivate');


