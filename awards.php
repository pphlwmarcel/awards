<?php
/******************************************************************************
 * Awards
 *
 * Version 0.0.1
 *
 * Datum        : 29.09.2014  
 *
 * Diese Plugin ordnet Mitgliedern Ehrungen/Auszeichnungen/Lehrgänge zu
 * 
 *                  
 *****************************************************************************/

// Pfad des Plugins ermitteln
$plugin_folder_pos = strpos(__FILE__, 'adm_plugins') + 11;
$plugin_file_pos   = strpos(__FILE__, basename(__FILE__));
$plugin_path       = substr(__FILE__, 0, $plugin_folder_pos);
$plugin_folder     = substr(__FILE__, $plugin_folder_pos+1, $plugin_file_pos-$plugin_folder_pos-2);

if($gCurrentUser->editUsers() == true){

// DB auf Admidio setzen, da evtl. noch andere DBs beim User laufen
$gDb->setCurrentDB();

// Einbinden der Sprachdatei
$gL10n->addLanguagePath($plugin_path.'/'.$plugin_folder.'/languages');
$awardmenu = new Menu('awardmenu', $gL10n->get('AWA_HEADLINE'));
//Falls Datenbank nicht vorhanden Install-Skript starten
$tablename=$g_tbl_praefix.'_user_awards';
$sql_select="SHOW TABLES LIKE '".$tablename."'"; 
$query = mysql_query($sql_select); 
if(mysql_num_rows($query)===0){
//Datenbank vorhanden
	$awardmenu->addItem('categories', '/adm_plugins/'.$plugin_folder.'/awards_install.php',
			$gL10n->get('AWA_INSTALL'), '/icons/options.png');
}else{
//echo 'Lösche Tabelle';
//$sql='DROP TABLE '.$tablename;
//$result=$gDb->query($sql);
	$awardmenu->addItem('awards_show', '/adm_plugins/'.$plugin_folder.'/awards_show.php',
			$gL10n->get('AWA_LIST_AWARDS'), '/icons/lists.png');
	$awardmenu->addItem('awards_new', '/adm_plugins/'.$plugin_folder.'/awards_change.php',
			$gL10n->get('AWA_HONOR'), '/icons/profile.png');
	$awardmenu->addItem('categories', '/adm_program/administration/categories/categories.php?type=AWA',
			$gL10n->get('AWA_CAT_EDIT'), '/icons/options.png');
}

$awardmenu->show();  
}  
?>
