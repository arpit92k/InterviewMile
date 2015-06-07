<?php
/**
 * 
 * @author arpit
 *
 */
class CategoryHandler{
	/**
	 * 
	 * @param $_POST $postData
	 */
	public function addCategory($postData){
		if(isset($postData['category'])){
			$categories=new Categories();
			$category=UtilityFunctions::fix($postData['category']);
			$parentCategoryId=0;
			$owner=UtilityFunctions::getLoggedinUser();
			if(isset($postData['parentCategoryId'])){
				$parentCategoryId=intval(UtilityFunctions::fix($postData['parentCategoryId']));
				if(!$categories->isValidCategoryId($parentCategoryId)){
					$responce['error']="Invalid Parent Category Id";
					UtilityFunctions::sendResponce($responce);
					return;
				}
			}
			$responce=$categories->addCategory($category, $owner,$parentCategoryId);
			UtilityFunctions::sendResponce($responce);
		}
		else
			UtilityFunctions::responceBadRequest();
	}
	/**
	 * 
	 * @param $_POST $postData
	 */
	public function getCategories($postData){
		$categories=new Categories();
		if(isset($postData['parentCategoryId'])){
			$parentCategoryId=intval(UtilityFunctions::fix($postData['parentCategoryId']));
			$responce=$categories->getSubcategories($parentCategoryId);
			UtilityFunctions::sendResponce($responce);
		}
		else{
			$start=0;
			if(isset($postData['start'])){
				$start=intval(UtilityFunctions::fix($postData['start']));
			}
			$responce=$categories->getBaseCategories($start);
			UtilityFunctions::sendResponce($responce);
		}
	}
	public function findCategories($postData){
		$categories=new Categories();
		if(isset($postData['category'])){
			$category=UtilityFunctions::fix($postData['category']);
			$responce=$categories->searchCategory($category);
			UtilityFunctions::sendResponce($responce);
		}
		else
			UtilityFunctions::responceBadRequest();
	}
}