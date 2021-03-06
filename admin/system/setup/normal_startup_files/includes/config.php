<?php require_once dirname(__FILE__) . "/../admin/includes.php";

if(multilanguage_mode)
{
	$language = getLanguage();
	setLanguage($language);
	$i18n = listI18nByScope("global");
	define("site_title", getI18n("admin_site_titleI18N"));
	define("description", getI18n("admin_descriptionI18N"));
	define("keywords", getI18n("admin_keywordsI18N"));
}
else
{
	// Site multilanguge_mode'da değilken tarih isimlerini default olarak türkçe ayarlaması için kullanıyoruz.
	$DB->execute("SET LC_TIME_NAMES=tr_TR");
	
	define("site_title", get_option("admin_site_title"));
	define("description", get_option("admin_description"));
	define("keywords", get_option("admin_keywords"));
}

setGlobal("multilanguage_mode", multilanguage_mode);
setGlobal("maintanance_mode", maintanance_mode);
setGlobal("site_address", site_address);
setGlobal("debug_mode", debug_mode);