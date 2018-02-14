<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_ingredients")
 */
class RecipeIngredient
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $recipe;

//    /**
//     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipeIngredients")
//     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id", nullable=FALSE)
//     */
//    protected $ingredient;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="string", length=255)
     */
    protected $quantity;

    /**
     * @var string
     * For now, just using a simple text to add ingredients. Easier to manage for now than a many to many link. Will fix it
     * TODO : put back the ingredients
     * @ORM\Column(name="ingredient_name", type="string", length=255)
     */
    protected $ingredientName;


    public function getId()
    {
        return $this->id;
    }


    public function getRecipe()
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe = null)
    {
        if ($this->recipe !== null) {
            $this->recipe->removeRecipeIngredient($this);
        }

        if ($recipe !== null) {
            $recipe->addRecipeIngredient($this);
        }

        $this->recipe = $recipe;
        return $this;
    }

    public function addRecipe(Recipe $recipe)
    {
        $this->setRecipe($recipe);
    }

//    public function getIngredient()
//    {
//        return $this->ingredient;
//    }
//
//    public function setIngredient(Ingredient $ingredient = null)
//    {
//        if ($this->ingredient !== null) {
//            $this->ingredient->removeRecipeIngredient($this);
//        }
//
//        if ($ingredient !== null) {
//            $ingredient->addRecipeIngredient($this);
//        }
//
//        $this->ingredient = $ingredient;
//        return $this;
//    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getIngredientName()
    {
        return $this->ingredientName;
    }

    public function setIngredientName($ingredientName)
    {
        $this->ingredientName = $ingredientName;
        return $this;
    }
}