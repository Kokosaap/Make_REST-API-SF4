<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\ApiRestful;
use App\Form\ApiViewType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ApiViewController extends Controller
{
    /**
     * @Route("/", name="api_viewhp")
     */
    public function index()
    {
    	return $this->render('api_view/index.html.twig', [
    		'controller_name' => 'ApiViewController',
    	]);
    }
    public function test()
    {
        return $this->render('test.html.twig', [
            'controller_name' => 'ApiViewController',
        ]);
    }

    public function check_your_IMC(Request $request)
    {
        // 1) build the form
    	$api = new ApiRestful();
    	$form = $this->createForm(ApiViewType::class, $api);

        // 2) handle the submit (will only happen on POST)
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {


            // 4) save the api & users informations!
    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->persist($api);
    		$entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

    		return $this->redirectToRoute('form');
    	}

    	return $this->render(
    		'api_view/imc_form.html.twig',
    		array('form' => $form->createView())
    	);
    }



}
