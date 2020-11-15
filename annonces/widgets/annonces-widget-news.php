<?php
/**
 * Widget API: classe annonces_Widget_News
 *
 * @package annonces
 */

/**
 * Classe qui implémente le widget annonces_Widget_News
 * ce widget affiche un lien vers la dernière annonce enregistrée dans la table annonces 
 *
 * @see WP_Widget
 */
class annonces_Widget_News extends WP_Widget {

  /**
   * Constructeur d'une nouvelle instance de cette classe 
   *
   */
  public function __construct() {
    $widget_ops = array(
      // classe CSS ajoutée au conteneur du widget
      'classname'   => 'annonces_widget_news', 
      'description' => 'Affiche le nom de la dernière annonce enregistrée.'
    );
    parent::__construct( 'annonces_widget_news',
                         'annonces - Dernière annonce',
                         $widget_ops );
  }

  /**
   * Affiche le contenu de l'instance courante du widget
   *
   * @param array $args     Display arguments including 'before_titre', 'after_titre',
   *                        'before_widget', and 'after_widget'
   * @param array $instance Settings for the current widget instance
   */
  public function widget( $args, $instance ) {
    $titre = ! empty( $instance['titre'] ) ? $instance['titre'] : __('Last annonce');

    // Ce crochet de filtres est documenté dans wp-includes/widgets/class-wp-widget-pages.php
    // applique les filtres wptexturize, convert_chars et esc_html (wp-include/default-filters.php)
    $titre = apply_filters( 'widget_titre', $titre, $instance, $this->id_base );

    // le tableau args contient les codes html de mise en forme
    // enregistrés par la fonction WP register_sidebar dans le thème courant 
    echo $args['before_widget'];
    if ( $titre ) {
      echo $args['before_titre'] . $titre . $args['after_titre'];
    }

    // Affichage du lien vers la page de la dernière annonce
    $this->get_last_annonce();

    echo $args['after_widget'];
  }

  /**
   * Affichage du lien vers la page de la dernière annonce
   *
   * @param none
   */
  public function get_last_annonce() {
    global $wpdb;
    // récupération de la dernière annonce dans la table annonces
    $sql = "SELECT * FROM $wpdb->prefix"."annonces ORDER BY id DESC LIMIT 1";

    $annonce = $wpdb->get_row($sql);
    if ($annonce  !== null) :
      // récupération du lien vers la page générique d'affichage d'une annonce
      $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'annonces' AND meta_value = 'single'");
      $single_permalink = get_permalink($postmeta->post_id);

      add_action("wp_print_footer_scripts",
                 array(__CLASS__, "annonces_widget_news_style"));
  ?>

      <ul id="annonces_widget_news">
        <li>
          <a href="<?php echo $single_permalink.'?id='.$annonce->id?>">
          <?php echo stripslashes($annonce->titre) ?>
        </a>
        </li>
      </ul>
  <?php
    else :
  ?>
      <p>Aucune annonce enregistrée.</p>
  <?php
    endif;
  }
  
  /**
   * Affichage du formulaire de configuration du widget
   *
   * @param array $instance Current settings
   */
  public function form( $instance ) {
    // ici un seul paramètre de configuration: le titre du widget
    // qui est affiché dans la zone du widget sur les pages du site
    $titre = isset( $instance['titre'] ) ? esc_attr( $instance['titre'] ) : '';
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('titre'); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat"
             id="<?php echo $this->get_field_id('titre'); ?>"
             name="<?php echo $this->get_field_name('titre'); ?>"
             type="text"
             value="<?php echo $titre; ?>">
    </p>
    <?php
  }

  /**
   * Modification de la configuration en retour du formulaire
   *
   * @param array $new_instance New settings for this instance as input by the user via
   *                            WP_Widget::form()
   * @param array $old_instance Old settings for this instance
   * @return array Updated settings to save or bool false to cancel saving
   */
  public function update( $new_instance, $old_instance ) {
    
    error_log(__METHOD__." : old_instance ".print_r($old_instance, true));
    error_log(__METHOD__." : new_instance ".print_r($new_instance, true));

    $instance = $old_instance;
    $instance['titre'] = sanitize_text_field( $new_instance['titre'] );
    return $instance;
  }

  /**
   * Insertion d'une feuille de style CSS
   *
   * @param none
   * @return none
   */
  public static function annonces_widget_news_style() { 
    // feuille de style CSS
    ?>
    <link rel='stylesheet'    
          href='<?= plugins_url('css/annonces-widget-news.css', ANNONCES_PLUGIN_FILE)?>'>
    <?php
  }
}