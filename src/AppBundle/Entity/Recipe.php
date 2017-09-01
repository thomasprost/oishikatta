<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="recipe_images", fileNameProperty="mainImage")
     *
     * @var File
     */
    private $mainImageFile;

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
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="recipe", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $recipeIngredients;


    /**
     * Country for the recipe
     *
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="recipes")
     */
    private $country;

    /**
     * @var ArrayCollection $recipeSteps
     *
     * @ORM\OneToMany(targetEntity="RecipeStep", mappedBy="recipe", cascade={"persist", "remove", "merge"})
     */
    private $recipeSteps;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
        $this->recipeSteps = new ArrayCollection();
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
     * @param File $mainImage
     */

    public function setMainImageFile(File $mainImage = null)
    {
        $this->mainImageFile = $mainImage;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($mainImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getMainImageFile()
    {
        return $this->mainImageFile;
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

    //region Methods
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

    //region Ingredients Methods
    public function getRecipeIngredients()
    {
        return $this->recipeIngredients->toArray();
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient)
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient)
    {
        if ($this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->removeElement($recipeIngredient);
        }

        return $this;
    }

    public function getIngredients()
    {
        return array_map(
            function ($recipeIngredient) {
                return $recipeIngredient->getIngredient();
            },
            $this->recipeIngredients->toArray()
        );
    }
    //endregion

    //region Steps Methods
    public function getRecipeSteps()
    {
        return $this->recipeSteps->toArray();
    }

    public function addRecipeStep(RecipeStep $recipeStep)
    {
        if (!$this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps->add($recipeStep);
        }

        return $this;
    }

    public function removeRecipeStep(RecipeIngredient $recipeStep)
    {
        if ($this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps->removeElement($recipeStep);
        }

        return $this;
    }
    //endregion

    //region Country Methods
    /**
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     *
     * @return Recipe
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
    //endregion
    //endregion

    //region KNP Sluggable Override
    public function getSluggableFields()
    {
        return ['id','name'];
    }
    //endregion

}

