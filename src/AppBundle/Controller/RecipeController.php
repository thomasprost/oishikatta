<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends Controller
{
    /**
     * @Route("/recipe", name="recipe_home")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipes = $repository->getLatestRecipes();

        return $this->render('recipe/index.html.twig', array(
            'recipes' => $recipes
        ));
    }

    /**
     * @Route("/recipe/add", name="recipe_add")
     */
    public function addRecipeAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $recipe = $form->getData();
            $recInc = $recipe->getRecipeIngredients();
            foreach ($recInc as $rec){
                $rec->setRecipe($recipe);
            }

            $recSteps = $recipe->getRecipeSteps();
            foreach ($recSteps as $step){
                $step->setRecipe($recipe);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            $this->addFlash(
                'notice',
                'Recipe '. $recipe.getName() .' created !!'
            );
            return $this->redirectToRoute('recipe_home');
        }

        return $this->render('recipe/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/recipe/{slug}", name="recipe_show")
     */
    public function showRecipeAction($slug, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe = $repository->findOneBy(array(
            'slug' => $slug
        ));

        return $this->render('recipe/show.html.twig', array(
            'recipe' => $recipe
        ));
    }

    /**
     * @Route("/recipe/edit/{slug}", name="recipe_edit")
     */
    public function editRecipeAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe = $repository->findOneBy(array(
            'slug' => $slug
        ));
        if (!$recipe)
            throw $this->createNotFoundException('No recipe found for slug '.$slug);


        $form = $this->createForm(RecipeType::class, $recipe);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $recInc = $recipe->getRecipeIngredients();
                foreach ($recInc as $rec){
                    if($rec->getRecipe() === null){
                        $rec->setRecipe($recipe);
                    }

                }
//
                $recSteps = $recipe->getRecipeSteps();
                foreach ($recSteps as $step){
                    if($step->getRecipe() === null) {
                        $step->setRecipe($recipe);
                    }
                }

                $em->persist($recipe);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Recipe '. $recipe->getName() .' updated '
                );

                return $this->redirect($this->generateUrl('recipe_home'));
            }
        }

        return $this->render('recipe/edit.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/recipe/delete/{slug}", name="recipe_delete")
     */
    public function deleteRecipeAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe = $repository->findOneBy(array(
            'slug' => $slug
        ));

        $em->remove($recipe);
        $em->flush();
        $this->addFlash(
            'notice',
            'Recipe deleted '
        );

        return $this->redirect($this->generateUrl('recipe_home'));
    }



}
