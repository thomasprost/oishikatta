<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
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




}
