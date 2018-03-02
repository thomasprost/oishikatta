<?php
/**
 * Created by PhpStorm.
 * User: warpd
 * Date: 22/02/2018
 * Time: 11:11
 */

namespace AppBundle\Helper;

use AppBundle\Entity\RecipeIngredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeStep;
use Symfony\Component\DomCrawler\Crawler;
use Vich\UploaderBundle\Util\Transliterator;

class CrawlHelper
{

    // Validates domains to be sure we can crawl the content properly
    private $domains = [
        'cookpad.com'
    ];

    private $url;
    private $webFolder;

    public function __construct(string $url, string $webFolder)
    {
        $this->url = $url;
        $this->webFolder = $webFolder;
    }


    private function strposa($haystack, $needle, $offset=0) {
        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $query) {
            if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
        }
        return false;
    }


    /**
     * Get the html data from the url passed
     *
     * @return mixed
     * Returns the html as a string
     */
    public function getHtml() {

        // Check if the url passed is part of the domains allowed
        if($this->strposa($this->url, $this->domains)){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_REFERER, $this->url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36");
            $str = curl_exec($curl);
            curl_close($curl);
            return $str;
        }
        else{
            return false;
        }

    }

    /**
     * @param $htmlToCrawl
     * Html we got from the curl call
     * @return Recipe
     */
    public function crawlHtml($htmlToCrawl){
        $crawler = new Crawler($htmlToCrawl);
//        $crawler = $crawler->filter('#ingredients_list > li');

        $recipe = $this->crawlCookpad($crawler);

        return $recipe;
    }

    private function crawlCookpad(Crawler $crawler){
        $title = $crawler->filter('.recipe-title') ? $crawler->filter('.recipe-title')->text() : null;
        $description = $crawler->filter('.description_text')? $crawler->filter('.description_text')->text() : null;
        $image = $crawler->filter('#main-photo > img')->extract(['src']);

        $recipe = new Recipe();
        $recipe->setName($title);
        $recipe->setIntro($description);

        // After crawling the image, we need to download it and save it to our image folder
        if(!empty($image)){
            $upload = $this->downloadRecipeImage($image[0], $title);

            if($upload){
                $recipe->setMainImage($upload);
            }
        }


        /*
         * Ingredients
         */
        $ingredientsElements = $crawler->filter('#ingredients_list > .ingredient')->each(function (Crawler $node, $i) {
            $ingredientName = $node->filter('.ingredient_name');
            $ingredientQuantity = $node->filter('.ingredient_quantity');
            $ingredient = new RecipeIngredient();
            if($ingredientName->count()> 0 && $ingredientQuantity->count() > 0){
                $ingredient->setIngredientName($ingredientName->text());
                $ingredient->setQuantity($ingredientQuantity->text());
                return $ingredient;
            }
            else{
                return null;
            }
        });

        // Update the ingredients if found ans link the recipe entity
        /* @var $ingr RecipeIngredient */
        foreach ($ingredientsElements as $ingr){
            if($ingr !== null){
                $ingr->setRecipe($recipe);
            }
        }

        /*
         * Steps
         */
        $stepsElements = $crawler->filter('#steps > .step, #steps > .step_last')->each(function (Crawler $node, $i) {
            $stepTextNode = $node->filter('.step_text');

            $step = new RecipeStep();
            if($stepTextNode->count()> 0){
                $step->setInstruction($stepTextNode->text());
//                $ingredient->setQuantity($ingredientQuantity->text());
                return $step;
            }
            else{
                return null;
            }
        });

        // Update the steps if found ans link the recipe entity
        /* @var $step RecipeIngredient */
        foreach ($stepsElements as $step){
            if($step !== null){
                $step->setRecipe($recipe);
            }
        }

        $recipe->setLink($this->url);

//        $this->downloadRecipeImage($)


        return $recipe;
    }

    private function downloadRecipeImage($url, $recipeName){
        // Download the image
        $content = file_get_contents($url);
        // Vich uploader Transliterator helps a lot to generate a new name (See the doc)
        $transName = Transliterator::transliterate($recipeName);

        // Create a unique name for the image
        $name = uniqid().'_'.$transName;

        // Try to get the file extension
        $split = explode("?", $url);
        $extension = substr($split[0], -4);
        // We guess the image extension

        $fullname = $name.$extension;

        // Save the image
        $succeedUpload = file_put_contents($this->webFolder.'/uploads/images/recipes/'.$fullname, $content);

        return $succeedUpload !== false ? $fullname : $succeedUpload;
    }




}