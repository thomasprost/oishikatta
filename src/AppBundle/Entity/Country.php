<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="nameJa", type="string", length=191, unique=true)
     */
    private $nameJa;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="flagImage", type="string", length=255, nullable=true)
     */
    private $flagImage;

    /**
     * Recipes in the country.
     *
     * @var Recipe[]
     * @ORM\ManyToMany(targetEntity="Recipe", mappedBy="countries")
     **/
    protected $recipes;

    /**
     * Constructor
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->recipes = new ArrayCollection();
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName();
    }


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
     * @return Country
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
     * Set nameJa
     *
     * @param string $nameJa
     *
     * @return Country
     */
    public function setNameJa($nameJa)
    {
        $this->nameJa = $nameJa;

        return $this;
    }

    /**
     * Get nameJa
     *
     * @return string
     */
    public function getNameJa()
    {
        return $this->nameJa;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Country
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

    /**
     * Set flagImage
     *
     * @param string $flagImage
     *
     * @return Country
     */
    public function setFlagImage($flagImage)
    {
        $this->flagImage = $flagImage;

        return $this;
    }

    /**
     * Get flagImage
     *
     * @return string
     */
    public function getFlagImage()
    {
        return $this->flagImage;
    }

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
     * Add recipe in the country
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Country
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

