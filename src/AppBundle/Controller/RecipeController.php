<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;
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
        $repository = $this->getDoctrine()->getRepository('AppBundle:Recipe');

        $recipes = $repository->findAll();

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
            $recipe = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return $this->redirectToRoute('homepage');
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
     * @Route("/recipe/edit/{id}", name="recipe_edit")
     */
    public function editRecipeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe = $repository->find($id);
        if (!$recipe)
            throw $this->createNotFoundException('No recipe found for id '.$id);

        $form = $this->createForm(RecipeType::class, $recipe);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('recipe_home'));
            }
        }

        return $this->render('recipe/edit.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/recipe/delete/{id}", name="recipe_delete")
     */
    public function deleteRecipeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe = $repository->find($id);

        $em->remove($recipe);

        return $this->redirect($this->generateUrl('recipe_home'));
    }



}
