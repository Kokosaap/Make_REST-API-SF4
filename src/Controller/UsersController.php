<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\User;
use App\Form\UserType;
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

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
// use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation as Doc;


class UsersController extends Controller
{

    public function index()
    {
    	return $this->render('users/index.html.twig', [
    		'controller_name' => 'UsersController',
    	]);
    }

    public function success()
    {
    	return $this->render('api_view/success_form.html.twig', [
    		'controller_name' => 'ApiViewController',
    	]);
    }

    public function form_IMC(Request $request, \Swift_Mailer $mailer)
    {

        // 1) build the form
    	$api = new User();

    	$form = $this->createForm(UserType::class, $api);

                // 2) handle the submit (will only happen on POST)
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData(); // Récuperer les infos du users issu du formulaire

            // 4) save the api & users informations!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($api);
            $entityManager->flush();

            $message = (new \Swift_Message('You got mail !'))
            ->setSubject('Happy new you :)')
            ->setFrom('salmier.leanaelle@gmail.com')
            ->setTo($formData->getEmail())
            ->setBody(
            	$this->renderView(
                    // 'emails/registration.html.twig',
            		'emails/registration.html.twig',
            		array('name' => $formData->getName(),
            			'surname' => $formData->getSurname())

            	),
            	'text/html'
            );


            $mailer->send($message);

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('success');
        }

        return $this->render(
        	'api_view/imc_form.html.twig',
        	array('form' => $form->createView())
        );
    }

    public function getUserAction()
    {
    	$repository = $this->getDoctrine()->getRepository(User::class);

        // query for a single Product by its primary key (usually "id")
    	$user_info = $repository->findall();

    	return View::create($user_info, Response::HTTP_OK , []);
    }


    /**
     * Create User-Info.
     * @FOSRest\Post("user_info")
     *
     * @return array
     */
    public function postUserInfoAction(Request $request)
    {
    	$user_info = new User();
    	$user_info->setGender($request->get('gender'));
    	$user_info->setName($request->get('name'));
    	$user_info->setSurname($request->get('surname'));
    	$user_info->setAge($request->get('age'));
    	$user_info->setEmail($request->get('email'));
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($user_info);
    	$em->flush();
    	return View::create($user_info, Response::HTTP_CREATED , []);

    }

}
