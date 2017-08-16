<?php
namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Ingredient;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadIngredientData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Ingredients fixtures
         */

        // Ingredients List
        $ingredientsList = array(
            'Cereals' => ['シリアル', 'cereals.jpg', 0],
            'Dairy' => ['乳製品', 'dairy.jpg', 0],
            'Fruits' => ['果物', 'fruits.jpg', 0],
            'Meat' => ['肉', 'meat.jpg', 0],
            'Nuts, seeds & oils' => ['ナツ、油', 'nuts-seeds-oils.jpg', 0],
            'Other ingredients' => ['その他', 'other-ingredients.jpg', 0],
            'Seafood' => ['シーフード', 'seafood.jpg', 0],
            'Spices & herbs' => ['スパイス＆ハーブ', 'spices-and-herbs.jpg', 0],
            'Sugar products' => ['砂糖', 'sugar-products.jpg', 0],
            'Vegetables' => ['野菜', 'vegetables.jpg', 0]
        );

        foreach ($ingredientsList as $key => $ingredient) {
            $ingredientDb = new Ingredient();
            $ingredientDb->setName($key);
            $ingredientDb->setNameJa($ingredient[0]);
            $ingredientDb->setImage($ingredient[1]);
            $ingredientDb->setParent($ingredient[2]);

            $manager->persist($ingredientDb);
            $manager->flush();
        }

    }
}