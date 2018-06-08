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
use App\Entity\ApiRestful;

class ApiRestfulController extends Controller
{

    /**
     * @Route("/api-restful", name="api_restful")
     */
    public function index()
    {
    	return $this->render('api_restful/index.html.twig', [
    		'controller_name' => 'ApiRestfulController',
    	]);
    }


    /**
     * Lists all Users_infos.
     * @FOSRest\Get("/users_infos")
     *
     * @return array
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
     * @FOSRest\Post("/user_info")
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
}
