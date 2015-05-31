<?php
/**
 * 
 * @author arpit
 *
 */
class Categories{
	private $link;
	/**
	 * conctructor
	 */
	public function __construct(){
		$this->link=new Database();
	}
	/**
	 * 
	 * @param string $category
	 * @param integer $parentCategoryId
	 * @return integer id of insterted category
	 */
	public function addCategory($category,$owner,$parentCategoryId=NULL){
		$this->link->setQuery("INSERT INTO catrgories(`parentId`,`category`,`owner`) VALUES(?,?,?)");
		$this->link->bindParms(array($category,$parentCategoryId,$owner));
		return $this->link->executeInsertQuery();
	}
	/**
	 * 
	 * @param number $start
	 * @return allay of 10 base categories starting from $start
	 */
	public function getBaseCategories($start=0){
		$this->link->setQuery("SELECT * FROM categories WHERE parentId=NULL LIMIT $start,10");
		$this->link->executeSelectQuery();
		$qresult=$this->link->executeSelectQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	/**
	 * 
	 * @param string $baseCategoryName
	 * @return id of goven base category if exists
	 */
	public function getBaseCategoryIdByName($baseCategoryName){
		$this->link->setQuery("SELECT * FROM categories WHERE parentId=NULL and category=?");
		$this->link->bindParms(array($baseCategoryName));
		$qresult=$this->link->executeSelectQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	/**
	 * 
	 * @param integert $categoryId
	 * @param number $start
	 * @return array of 10 subcategories of gievn base category starting from $start
	 */
	public function getSubcategories($categoryId,$start=0){
		$this->link->setQuery("SELECT * FROM categories WHERE parentId=? LIMIT $start,10");
		$this->link->bindParms(array($categoryId));
		$qresult=$this->link->executeSelectQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	public function isValidCategoryId($categoryId){
		$this->link->setQuery("SELECT * FROM categories WHERE categoryId=?");
		$this->link->bindParms(array($categoryId));
		$qresult=$this->link->executeSelectQuery();
		if($qresult->rowCount())
			return true;
		return false;
	}
}
?>