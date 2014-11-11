<?php
// _PS_MODULE_DIR_ Variable globale, on trouve la liste dans le fichier /config/defines.inc.php
require_once _PS_MODULE_DIR_ . 'prcustomeropinion/models/Opinion.php';

/**
 * 
 * @author Alexandre Segura <mex.zktk@gmail.com>
 */
// Tous les modules doivent être une extension de la classe Module
class PrCustomerOpinion extends Module {

// On renseigne les champs suivant
// name         Nom du module, sans accents, espaces ou caractères spéciaux
// tab          Catégory du module, sera utilisé pour l'affichage dans la backoffice
// version      Numéro de version du module
// author       Nom de l'auteur
// displayName  Nom du module, sera utilisé pour l'affichage dans le backoffice
// description  Description du module, sera utilisé dans le backoffice
// need_instance Indique si il faut charger la classe du module lors de l'affichage dans la page module du backoffice, Si votre module à besoin d'afficher un message d'avertissement dans la page module, vous devez définir cet attribut à 1
// ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); Indique les versions de PrestaShop compatible avec votre module
// bootstrap    Indique à PrestaShop que le module à été construit avec les outils de bootstrap, et que donc PrestaShop ne devrait pas essayer de modifier le code pour l'écran de configuration
// confirmUninstall = $this->l('Are you sure you want to uninstall?'); Permet de demander à l'administrateur si il veut vraiment désinstaller le module
 	public function __construct() {
		
		$this->name 		= 'prcustomeropinion';
		$this->tab 			= 'front_office_features';
		$this->version 		= 1.0;
		$this->author 		= 'Alexandre Segura';
// On appelle la méthode construct de la classe parent, l'appel au constructeur doit se faire aprés la création de la variable $this->name et
// avant d'utiliser les méthode de traduction $this->l();	
		parent :: __construct();
		
        $this->displayName  = $this->l('Customer Opinion');
        $this->description  = $this->l('Customer Opinion - Example module for PrestaShop 1.5');
	}
	
	public function install() {
		return parent :: install()
			&& $this->resetDb()
			&& $this->registerHook('leftColumn')
			;
	}
	
	private function resetDb() {
		
		$prefix = _DB_PREFIX_;
		$engine = _MYSQL_ENGINE_;
		
		$statements = array();
		
		$statements[] 	= "DROP TABLE IF EXISTS `${prefix}opinion`";
		$statements[] 	= "CREATE TABLE `${prefix}opinion` ("
						. '`id_opinion` int(10) unsigned NOT NULL AUTO_INCREMENT,'
						. '`id_customer` int(10) unsigned NOT NULL,'
						. '`opinion` enum("AVERAGE","GOOD","VERY_GOOD") NOT NULL,'
						. '`active` tinyint(1) unsigned DEFAULT "0",'
						. 'PRIMARY KEY (`id_opinion`)'
						. ") ENGINE=$engine"
						;

		foreach ($statements as $statement) {
			if (!Db :: getInstance()->Execute($statement)) {
				return false;
			}
		}
		
		return true;
						
	}
	
	public function hookDisplayLeftColumn($params) {
		return $this->display(__FILE__, 'left-column.tpl');
	}
	
}