<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
use AppBundle\Entity\Recipe;
use AppBundle\Form\CountryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CountryController extends Controller
{
    /**
     * @Route("/country", name="country_home")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Country');

        $countries = $repository->findAll();

        return $this->render('country/index.html.twig', array(
            'countries' => $countries
        ));
    }

    /**
     * @Route("/country/add", name="country_add")
     */
    public function addCountryAction(Request $request)
    {
        $country = new Country('');
        $form = $this->createForm(CountryType::class, $country);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            return $this->redirectToRoute('country_home');
        }

        return $this->render('country/add.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/country/edit/{name}", name="country_edit")
     */
    public function editCountryAction($name, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Country::class);

        $country = $repository->findOneBy(array(
                'name' => $name
            ));
        if (!$country)
            throw $this->createNotFoundException('No country found with the name '.$name);

        $form = $this->createForm(CountryType::class, $country);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('country_home'));
            }
        }

        return $this->render('country/edit.html.twig', array(
            'country' => $country,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/country/{name}", name="country_show")
     * @param $name
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCountryAction($name, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);

        $country = $repository->findOneBy(array(
            'name' => $name
        ));

        if (!$country)
            throw $this->createNotFoundException('No country found with the name '.$name);

        return $this->render('country/show.html.twig', array(
            'country' => $country
        ));
    }

}
