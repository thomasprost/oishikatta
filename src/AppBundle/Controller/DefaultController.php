<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\CrawlHelper;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class DefaultController extends Controller
{


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipes = $repository->getLatestRecipes();


        return $this->render('default/index.html.twig', array(
            'recipes' => $recipes
        ));
    }
    /**
     * @Route("/parse-recipe", name="parseRecipe")
     */
    public function parseRecipeUrl(Request $request, ValidatorInterface $validator){

        $crawlHelper = new CrawlHelper('https://cookpad.com/recipe/1203423');

        $html = $crawlHelper->getHtml();
        $errorsString = null;

//        // Get the Html from a cUrl request
//        $html = $this->dlPage('https://cookpad.com/recipe/1203423');
        // Crawl the html to create a new recipe
        if($html){
            $recipe = $crawlHelper->crawlHtml($html);

            $errors = $validator->validate($recipe);
            if (count($errors) > 0) {
                $errorsString = "Sorry an error occurred, we couldn't process this link";
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($recipe);
                $em->flush();

                return $this->redirectToRoute('recipe_edit', ['slug'=>$recipe->getSlug()]);
            }

        }



        return $this->render('default/parseRecipe.html.twig', array(
            'errorMessage' => $errorsString
        ));
    }
}
