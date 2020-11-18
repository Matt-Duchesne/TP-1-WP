<?php 
/* 
Plugin Name: Annonces auto
Plugin URI: https://annonces-auto.plugins.com
Description: Publication et gestion d'annonces auto
Version: 0.1
Author: Mathieu Duchesne et Vincent LaPointe Lamy
Author URI: https://cmaisonneuve.omnivox.ca
*/

define('ANNONCES_PLUGIN_FILE', __FILE__);

require_once ("annonces-settings.php");          // gestion des réglages dans l'administration

require_once ("annonces-activation.php");        // activation du plugin
require_once ("annonces-deactivation.php");      // désactivation du plugin
require_once ("annonces-uninstall.php");         // désinstallation du plugin 

require_once ("annonces-widgets.php");           // prise en compte des widgets 

require_once ("annonces-hooks-filters.php");     // prise en compte des crochets de filtres

require_once ("pages/annonces-page-form.php");   // gestion formulaire de création d'une annonce 
require_once ("pages/annonces-page-modif.php");  // gestion formulaire de modification d'une annonce 
require_once ("pages/annonces-page-list.php");   // gestion page de liste des annonces
require_once ("pages/annonces-page-single.php"); // gestion page détail d'une annonce



