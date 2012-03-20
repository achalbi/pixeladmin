<?php
/*
 * Last Update: 18.06.2011
 * */
class PA_I18N
{
	public $language;
	public $table;
	
	function PA_I18N($language = "tr_TR")
	{
		global $DB;
		$this->language = $language;
		$this->table = $DB->tables->i18n;		
	}
	
	function listI18nByScope($scope="global")
	{
		global $DB;
		
		$dataArray = null;
		$query = "SELECT i18nCode,{$this->language} FROM {$this->table}";
		
		if($scope != "all")
		{
			$query .= " WHERE scope=?";
			$dataArray = array($scope);
		}
		
		return (object)$DB->get_rows($query,$dataArray,FETCH_KEY_PAIR);
	}
	
	function getI18n($i18nCode)
	{
		global $DB;
		
		return $DB->get_value("SELECT {$this->language} FROM {$this->table} WHERE i18nCode=?",array($i18nCode));
	}
	
	function setI18n($i18nCode,$text,$scope="")
	{
		global $DB;
		
		if($this->checkIfI18nExists($i18nCode))
			return $this->updateI18n($i18nCode, $text, $scope);
		else 
			return $this->createI18n($i18nCode,$text, $scope);
	}
	
	function deleteI18n($i18nCode)
	{
		global $DB;
		
		return $DB->execute("DELETE FROM {$this->table} WHERE i18nCode=?",array($i18nCode));
	}
	
	/* PRIVATE FUNCTIONS */
	
	private function checkIfI18nExists($i18nCode)
	{
		global $DB;
		
		if($DB->get_value("SELECT COUNT(i18nCode) FROM {$this->table} WHERE i18nCode=?",array($i18nCode)) > 0)
			return true;
		else
			return false;
	}
	
	/**
	 * 
	 * Yeni bir I18n değişkeni
	 * @param unknown_type $i18nCode
	 * @param unknown_type $text
	 */
	private function createI18n($i18nCode,$text,$scope="")
	{
		global $DB;
		
		return $DB->insert($this->table,array("i18nCode"=>$i18nCode,"scope"=>$scope,$this->language=>$text));
	}
	
	private function updateI18n($i18nCode,$text,$scope="")
	{
		global $DB;
		
		return $DB->execute("UPDATE {$this->table} SET {$this->language}=?,scope=? WHERE i18nCode=?",array($text,$scope,$i18nCode));
	}
}