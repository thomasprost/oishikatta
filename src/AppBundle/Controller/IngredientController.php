<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Form\IngredientType;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IngredientController extends Controller
{
    /**
     * @Route("/ingredient/{name}", name="ingredient_home")
     */
    public function indexAction($name = "")
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Ingredient');
        $parentId = 0;
        // no name means it is parent page
        // If there is a name, search for children ingredients
        if ($name != ""){
            $parent = $repository->findOneBy(array("name" => $name));
            $parentId = $parent !== null ? $parent->getId() : 0;
        }

        $ingredients = $repository->findOrderedIngredients($parentId);

        return $this->render('ingredient/index.html.twig', array(
            'ingredients' => $ingredients
        ));
    }

    /**
     * @Route("/ingredient/add/", name="ingredient_add")
     */
    public function addIngredientAction(Request $request)
    {
        $ingredient = new Ingredient();

        $er = $this->getDoctrine()->getRepository('AppBundle:Ingredient');
        // get parent ingredients to pick
        $ingredients = $er->getParentIngredients();

        $formOptions = array('ingredients' => $ingredients);

        // pass it to the form
        $form = $this->createForm(IngredientType::class, $ingredient, $formOptions);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $recipe = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();
            return $this->redirectToRoute('ingredient_home');
        }

        return $this->render('ingredient/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/ingredient/edit/{id}", name="ingredient_edit")
     */
    public function editIngredientAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Ingredient::class);

        $ingredient = $repository->find($id);
        if (!$ingredient)
            throw $this->createNotFoundException('No ingredient found for id '.$id);

        $ingredients = $repository->getParentIngredients();

        $formOptions = array('ingredients' => $ingredients);

        $form = $this->createForm(IngredientType::class, $ingredient, $formOptions);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('ingredient_home'));
            }
        }

        return $this->render('ingredient/edit.html.twig', array(
            'ingredient' => $ingredient,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/ingredient/delete/{id}", name="ingredient_delete")
     */
    public function deleteRecipeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Ingredient::class);

        $ingredient = $repository->find($id);

        $em->remove($ingredient);

        return $this->redirect($this->generateUrl('ingredient_home'));
    }

}
