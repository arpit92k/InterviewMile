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
	 * default parent category is 0 means it is base category
	 * @param string $category
	 * @param integer $parentCategoryId
	 * @return integer id of insterted category
	 */
	public function addCategory($category,$owner,$parentCategoryId=0){

		$this->link->setQuery("SELECT * FROM  categories WHERE parentCategoryId=? and category=?");
		$this->link->bindParms(array($parentCategoryId,$category));
		$res=$this->link->executeSelectQuery();
		if($res->rowCount()>0){
			$responce['error']="category already exists under this parentCategory";
			return $responce;
		}
		
		$this->link->setQuery("INSERT INTO  categories(`parentCategoryId`,`category`,`owner`) VALUES(?,?,?)");
		$this->link->bindParms(array($parentCategoryId,$category,$owner));
		$id=$this->link->executeInsertQuery();
		$responce['categoryId']=intval($id);
		return $responce;
	}
	/**
	 * 
	 * @param number $start
	 * @return array of 10 base categories starting from $start
	 */
	public function getBaseCategories($start=0){
		$this->link->setQuery("SELECT * FROM categories WHERE parentCategoryId=0 LIMIT $start,10");
		$this->link->executeSelectQuery();
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['categoryId']=intval($res['categoryId']);
			$result['parentCategoryId']=intval($res['parentCategoryId']);
			$result['category']=$res['category'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	public function getCategoryByID($id){
		$this->link->setQuery("SELECT * FROM categories WHERE categoryId=?");
		$this->link->bindParms(array($id));
		$res=$this->link->executeSelectQuery();
		$responce=array();
		if($res->rowCount()>0){
			$res=$res->fetch();
			$result['categoryId']=intval($res['categoryId']);
			$result['category']=$res['category'];
			$result['parentCategoryId']=intval($res['parentCategoryId']);
			$result['owner']=intval($res['owner']);
			return $result;
		}
		return $responce;
	}
	/**
	 * 
	 * @param string $baseCategoryName
	 * @return id of goven base category if exists
	 */
	public function getBaseCategoryIdByName($baseCategoryName){
		$this->link->setQuery("SELECT * FROM categories WHERE parentCategoryId=0 and category=?");
		$this->link->bindParms(array($baseCategoryName));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['categoryId']=intval($res['categoryId']);
			$result['parentCategoryId']=intval($res['parentCategoryId']);
			$result['category']=$res['category'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	/**
	 * 
	 * @param integert $categoryId
	 * @param number $start
	 * @return array of 10 subcategories of gievn base category starting from $start
	 */
	public function getSubcategories($categoryId,$start=0){
		$this->link->setQuery("SELECT * FROM categories WHERE parentCategoryId=? LIMIT $start,10");
		$this->link->bindParms(array($categoryId));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['categoryId']=intval($res['categoryId']);
			//$result['parentCategoryId']=intval($res['parentCategoryId']);
			$result['category']=$res['category'];
			//$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	public function searchCategory($category,$start=0){
		$this->link->setQuery("SELECT * FROM categories WHERE category LIKE ? LIMIT $start,10");
		$this->link->bindParms(array("%".$category."%"));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['categoryId']=intval($res['categoryId']);
			$result['parentCategoryId']=intval($res['parentCategoryId']);
			$result['category']=$res['category'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
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