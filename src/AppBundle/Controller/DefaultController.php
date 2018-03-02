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
     * @Route("/parse-recipe", name="parse_recipe")
     */
    public function parseRecipeUrl(Request $request, ValidatorInterface $validator){

        $errorsString = null;

        // TODO : better error handling and message return
        // TODO : move code in the Crawl Helper to keep Controller as small as possible

        if ('POST' === $request->getMethod()) {
            $urlField = $request->request->get('url');
            if($urlField !== ''){
                $repository = $this->getDoctrine()->getRepository(Recipe::class);
                $hasRecipe = $repository->recipeJustCreated($urlField);

                if(empty($hasRecipe)){
                    // Create new instance of the helper
                    $crawlHelper = new CrawlHelper($urlField, $this->get('kernel')->getRootDir().'/../web');

                    // Get the Html from the cUrl request
                    $html = $crawlHelper->getHtml();
//                $html = null;

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

                    }else{
                        $errorsString = "Sorry, no recipe could be found for this url";
                    }
                }else{
                    $errorsString = "You have just created a recipe from this link";
                }

            }
            else{
                $errorsString = "Please enter an url before clicking the GENERATE button.";
            }

        }


        return $this->render('default/parseRecipe.html.twig', array(
            'errorMessage' => $errorsString
        ));
    }
}
