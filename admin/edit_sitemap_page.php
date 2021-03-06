<?php

$page_id = strlen($_GET["id"]) > 0 ? $_GET["id"] : uniqid();

if($_POST["admin_action"] == "save_sitemap")
{
	extract($_POST, EXTR_OVERWRITE);
	
	if($ADMIN->SITEMAP->setSiteMap($page_id, $page_image, $page_url, $page_title, $page_description, $changefreq, $priority))
	{
		postMessage($GT->BASARIYLA_KAYDEDILDI);
		header("Location:admin.php?page=sitemap");
		exit;
	}
	else
	{
		postMessage($GT->HATA_OLUSTU, true);
	}
}

if(!$smpage = $ADMIN->SITEMAP->selectSiteMap($page_id)){
	$smpage = new stdClass();
	$smpage->priority = "0.5";
}
$smpage->page_id = $page_id; // Eğer yeni bir sitemap sayfası eklenecekse page_id değerini yukarıda aldığımız uniqid değeri olarak kullanıyoruz.


addScript("js/pages/edit_sitemap_page.js");
echo $edit_sitemap_page->html();