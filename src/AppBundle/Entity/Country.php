<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 * @Vich\Uploadable
 */
class Country
{
    use ORMBehaviors\Timestampable\Timestampable;

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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="country_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="country_flags_images", fileNameProperty="flagImage")
     *
     * @var File
     */
    private $flagImageFile;


    /**
     * @var string
     *
     * @ORM\Column(name="flagImage", type="string", length=255, nullable=true)
     */
    private $flagImage;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="country")
     */
    private $recipes;

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
     * @param File $image
     */

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
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
     * @param File $image
     */

    public function setFlagImageFile(File $flagImage = null)
    {
        $this->flagImageFile = $flagImage;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($flagImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFlagImageFile()
    {
        return $this->flagImageFile;
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

