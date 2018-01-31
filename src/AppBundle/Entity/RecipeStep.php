<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeStep
 *
 * @ORM\Table(name="recipe_step")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeStepRepository")
 */
class RecipeStep
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
     * @ORM\Column(name="instruction", type="text")
     */
    private $instruction;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="orderField", type="integer", nullable=true)
     */
    private $orderField;


    /**
     * @var Recipe $recipe
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipeSteps", cascade={"persist", "merge"})
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * })
     */
    private $recipe;



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
     * Set instruction
     *
     * @param string $instruction
     *
     * @return RecipeStep
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;

        return $this;
    }

    /**
     * Get instruction
     *
     * @return string
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return RecipeStep
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
     * Set orderField
     *
     * @param integer $orderField
     *
     * @return RecipeStep
     */
    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;

        return $this;
    }

    /**
     * Get orderField
     *
     * @return int
     */
    public function getOrderField()
    {
        return $this->orderField;
    }

    /**
     * @param \AppBundle\Entity\Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        if ($this->recipe !== null) {
            $this->recipe->removeRecipeStep($this);
        }

        if ($recipe !== null) {
            $recipe->addRecipeStep($this);
        }

        $this->recipe = $recipe;
        return $this;
    }

    public function addRecipe(Recipe $recipe)
    {
        $this->setRecipe($recipe);
    }

    /**
     * @return Recipe $recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }



}

