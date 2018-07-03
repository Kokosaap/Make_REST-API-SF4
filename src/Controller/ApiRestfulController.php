<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
// use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation as Doc;
use App\Entity\ApiRestful;

class ApiRestfulController extends Controller
{

    /**
     * @Route("/home", name="api_restful")
     */
    public function index()
    {
    	return $this->render('api_restful/index.html.twig', [
    		'controller_name' => 'ApiRestfulController',
    	]);
    }


    /**
     * Lists all Users_infos.
     * @FOSRest\Get("users_infos")
     *
     * @return array
     */

    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     * @Route("/api/users_infos", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=ApiRestful::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="The field used to order rewards"
     * )
     * @SWG\Tag(name="rewards")
     * @Security(name="Bearer")
     */
    public function getUserInfoAction()
    {
    	$repository = $this->getDoctrine()->getRepository(ApiRestful::class);

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
    	$user_info = new ApiRestful();
    	$user_info->setGender($request->get('gender'));
    	$user_info->setName($request->get('name'));
    	$user_info->setSurname($request->get('surname'));
    	$user_info->setAge($request->get('age'));
    	$user_info->setEmail($request->get('email'));
    	$user_info->setWeight($request->get('weight'));
    	$user_info->setHeight($request->get('height'));
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($user_info);
    	$em->flush();
    	return View::create($user_info, Response::HTTP_CREATED , []);

    }


    // public function check_your_IMC(Request $request)
    // {
    //     // 1) build the form
    //     $api = new ApiRestful();
    //     $form = $this->createForm(ApiRestfulType::class, $api);

    //     // 2) handle the submit (will only happen on POST)
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {


    //         // 4) save the api & users informations!
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($api);
    //         $entityManager->flush();

    //         // ... do any other work - like sending them an email, etc
    //         // maybe set a "flash" success message for the user

    //         return $this->redirectToRoute('form');
    //     }

    //     return $this->render(
    //         'api_restful/form.html.twig',
    //         array('form' => $form->createView())
    //     );
    // }

}
