<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\ApiRestful;
use App\Form\IMCType;
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

class IMCController extends Controller
{

    /**
     * @Route("/", name="api_viewhp")
     */
    public function success()
    {
    	return $this->render('api_view/success_form.html.twig', [
    		'controller_name' => 'ApiViewController',
    	]);
    }

    public function form_IMC(Request $request, \Swift_Mailer $mailer)
    {

        // 1) build the form
        $api = new ApiRestful();

        $form = $this->createForm(IMCType::class, $api);

                // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData(); // Récuperer les infos du users issu du formulaire

            // 4) save the api & users informations!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($api);
            $entityManager->flush();

            $message = (new \Swift_Message('You got mail !'))
            ->setSubject('Voici votre IMC! :)')
            ->setFrom('salmier.leanaelle@gmail.com')
            ->setTo($formData->getEmail())
            ->setBody(
                $this->renderView(
                    // 'emails/registration.html.twig',
                    'emails/registration.html.twig',
                    array('name' => $formData->getName(),
                        'surname' => $formData->getSurname(),
                        'height' => $formData->getHeight(),
                        'weight' => $formData->getWeight())
                ),
                'text/html'
            );

        $imc = $formData->getWeight() / ($formData->getHeight() * $formData->getHeight()); // début du calcul
        $imc = round($imc * 10000, 2); // fin du calcul avec un arrondi
        echo 'IMC = '. $imc .''; // résultat


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




}
