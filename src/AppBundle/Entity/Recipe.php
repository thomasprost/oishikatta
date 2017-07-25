<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;


/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="intro", type="text", nullable=true)
     */
    private $intro;

    /**
     * @var string
     *
     * @ORM\Column(name="mainImage", type="string", length=255, nullable=true)
     */
    private $mainImage;

    /**
     * @var int
     *
     * @ORM\Column(name="numberPeople", type="integer", nullable=true)
     */
    private $numberPeople;

    /**
     * @var int
     *
     * @ORM\Column(name="minutes", type="integer", nullable=true)
     */
    private $minutes;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * List of categories the recipe has
     * (Owning side).
     *
     * @var Category[]
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="recipes")
     * @ORM\JoinTable(name="recipe_category")
     */
    private $categories;


    /**
     * List of ingredients for the recipe
     * (Owning side).
     *
     * @var Ingredient[]
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="recipes")
     * @ORM\JoinTable(name="recipe_ingredients")
     */
    private $ingredients;


    /**
     * List of countries for the recipe
     * (Owning side).
     *
     * @var Country[]
     * @ORM\ManyToMany(targetEntity="Country", inversedBy="recipes")
     * @ORM\JoinTable(name="recipe_countries")
     */
    private $countries;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->countries = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }


    //region Accessors
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set intro
     *
     * @param string $intro
     *
     * @return Recipe
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return Recipe
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * Get mainImage
     *
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * Set numberPeople
     *
     * @param integer $numberPeople
     *
     * @return Recipe
     */
    public function setNumberPeople($numberPeople)
    {
        $this->numberPeople = $numberPeople;

        return $this;
    }

    /**
     * Get numberPeople
     *
     * @return int
     */
    public function getNumberPeople()
    {
        return $this->numberPeople;
    }

    /**
     * Set minutes
     *
     * @param integer $minutes
     *
     * @return Recipe
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutes
     *
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Recipe
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
    //endregion

    //region Category Methods
    /**
     * Get all associated categories.
     *
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set all categories of the recipe.
     *
     * @param Category[] $categories
     */
    public function setCategories($categories)
    {
        // This is the owning side, we have to call remove and add to have change in the category side too.
        foreach ($this->getCategories() as $category) {
            $this->removeCategory($category);
        }
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * Add category
     *
     * @param Category $category
     *
     * @return Recipe
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }
    //endregion

    //region Ingredient Methods
    /**
     * Get all associated ingredients.
     *
     * @return Ingredient[]
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set all ingredients of the recipe.
     *
     * @param ingredient[] $ingredients
     */
    public function setIngredients($ingredients)
    {
        // This is the owning side, we have to call remove and add to have change in the ingredient side too.
        foreach ($this->getIngredients() as $ingredient) {
            $this->removeIngredient($ingredient);
        }
        foreach ($ingredients as $ingredient) {
            $this->addIngredient($ingredient);
        }
    }

    /**
     * Add ingredient
     *
     * @param Ingredient $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param ingredient $ingredient
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }
    //endregion

    //region Country Methods
    /**
     * Get all associated countries.
     *
     * @return Country[]
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Set all countries of the recipe.
     *
     * @param Country[] $countries
     */
    public function setCountries($countries)
    {
        // This is the owning side, we have to call remove and add to have change in the country side too.
        foreach ($this->getCountries() as $country) {
            $this->removeCountry($country);
        }
        foreach ($countries as $country) {
            $this->addCountry($country);
        }
    }

    /**
     * Add Country
     *
     * @param Country $country
     *
     * @return Recipe
     */
    public function addCountry(Country $country)
    {
        $this->countries[] = $country;

        return $this;
    }

    /**
     * Remove Country
     *
     * @param Country $country
     */
    public function removeCountry(Country $country)
    {
        $this->countries->removeElement($country);
    }
    //endregion

    //region KNP Sluggable Override
    public function getSluggableFields()
    {
        return ['id','name'];
    }
    //endregion

}

