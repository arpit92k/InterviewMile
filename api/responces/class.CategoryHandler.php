<?php
class CategoryHandler{
	public function addCategory($postData){
		if(isset($postData['category'])){
			$categories=new Categories();
			$category=UtilityFunctions::fix($postData['category']);
			$parentCategoryId=null;
			$owner=$_SESSION['user'];
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
	public function getCategories($postData){
		$categories=new Categories();
		if(isset($postData['baseCategoryId'])){
			$baseCategoryId=intval(UtilityFunctions::fix($postData['baseCategoryId']));
			$responce=$categories->getSubcategories($baseCategoryId);
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
}