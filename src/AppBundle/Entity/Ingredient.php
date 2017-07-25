<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientRepository")
 */
class Ingredient
{
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
     * @ORM\Column(name="name", type="string", length=191, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * Recipes with this ingredient.
     *
     * @var Recipe[]
     * @ORM\ManyToMany(targetEntity="Recipe", mappedBy="ingredients")
     **/
    protected $recipes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    /** {@inheritdoc} */
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
     * @return Ingredient
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
     * Set image
     *
     * @param string $image
     *
     * @return Ingredient
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    //endregion

    //region Recipe Methods
    /**
     * Set all recipes in the country.
     *
     * @param Recipe[] $recipes
     */
    public function setRecipes($recipes)
    {
        $this->recipes->clear();
        $this->recipes = new ArrayCollection($recipes);
    }

    /**
     * Add recipe for this ingredient
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Ingredient
     */
    public function addRecipe($recipe)
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
        }

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \AppBundle\Entity\recipe $recipe
     */
    public function removeRecipe(Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get Recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
    //endregion
}

