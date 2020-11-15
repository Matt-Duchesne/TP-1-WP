<?php

// Gestion du widget qui affiche la dernière annonce enregistrée
// =============================================================

// chargement de la classe du widget
require_once ("widgets/annonces-widget-news.php");

// Initialisation de tous les widgets de l'extension (ici un seul, annonces_Widget_News)  
function annonces_register_widgets() {
	register_widget('annonces_Widget_News');
}

// déclenchement de la fonction d'initialisation des widgets de l'extension
// dans les actions du crochet widgets_init
add_action('widgets_init', 'annonces_register_widgets'); 

