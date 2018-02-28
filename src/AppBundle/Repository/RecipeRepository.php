<?php

namespace AppBundle\Repository;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends \Doctrine\ORM\EntityRepository
{

    public function getLatestRecipes(){
        return $this->createQueryBuilder('r')
            ->select('r, c')
            ->leftJoin('r.country', 'c')
            ->orderBy('r.updatedAt', 'DESC')
            ->getQuery()->getArrayResult();
    }

    public function searchRecipe($searchText){
        $query = $this->createQueryBuilder('r')
            ->select('r, c')
            ->leftJoin('r.country', 'c')
            ->where("r.name LIKE '%".$searchText."%'")
            ->orderBy('r.updatedAt', 'DESC')
            ->getQuery();

        return $query->getArrayResult();
    }

    // Prevents a recipe to be parsed multiple times in a short time span (30 minutes)
    public function recipeJustCreated($link){

        // Time minus 30 minutes
        $timeMinus30 = time() - (30 * 60);
        $time = date('Y-m-d H:i:s', $timeMinus30);
        $query = $this->createQueryBuilder('r')
            ->select('r')
            ->where("r.link = '".$link."'")
            ->andWhere("r.createdAt >= '".$time."'")
            ->getQuery()->getArrayResult();

        return $query;
    }
}
