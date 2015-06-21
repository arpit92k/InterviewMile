<?php
/**
 * 
 * @author arpit
 *
 */
class CategoryHandler{
	/**
	 * add a new category
	 * @param object $data
	 * 				 $data->category
	 * 				 $data->parentCategoryId		optional
	 */
	public function addCategory($data){
		$categories=new Categories();
		$category=UtilityFunctions::fix($data->category);
		$parentCategoryId=0;
		$owner=UtilityFunctions::getLoggedinUser();
		if(property_exists($data,'parentCategoryId')){
			$parentCategoryId=intval(UtilityFunctions::fix($data->parentCategoryId));
			if(!$categories->isValidCategoryId($parentCategoryId)){
				$responce['error']="Invalid Parent Category Id";
				return $responce;
			}
		}
		$responce=$categories->addCategory($category, $owner,$parentCategoryId);
		return $responce;
	}
	/**
	 * Get details of a category by ID
	 * @param integer $id
	 * @param integer $start
	 */
	public function getCategoryByID($id,$start){
		$categoriers=new Categories();
		$result=array();
		$result=$categoriers->getCategoryByID($id);
		if(isset($result['categoryId'])){
			//get parent category details
			$parent=array();
			$parentCategoryId=$result['parentCategoryId'];
			unset($result['parentCategoryId']);
			$parentDetails=$categoriers->getCategoryByID($parentCategoryId);
			$parent['categoryId']=$parentDetails['categoryId'];
			$parent['category']=$parentDetails['category'];
			$result['parentCategory']=$parent;
			
			//get Child category details
			$start=UtilityFunctions::fix($start);
			$childDetails=$categoriers->getSubcategories($id,$start);
			$result['childCategories']=$childDetails;
			
			return $result;
		}
		$result['error']="Invalid category ID $id";
		return $result;
	}
	/**
	 * 
	 * @param $_POST $postData
	 */
	public function getCategories($postData){
		$categories=new Categories();
		if(property_exists($postData,'parentCategoryId')){
			$parentCategoryId=intval(UtilityFunctions::fix($postData->parentCategoryId));
			$responce=$categories->getSubcategories($parentCategoryId);
			return $responce;
		}
		else{
			$start=0;
			if(property_exists($postData,'start')){
				$start=intval(UtilityFunctions::fix($postData->start));
			}
			$responce=$categories->getBaseCategories($start);
			return $responce;
		}
	}
	public function findCategories($name,$start){
		$categories=new Categories();
		$category=UtilityFunctions::fix($name);
		$start=UtilityFunctions::fix($start);
		$responce=$categories->searchCategory($category,$start);
		return $responce;
	}
}