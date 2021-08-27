<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Services\GiftService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    // public function __construct()
    // {
    //     // user $logger
    // }


    // this compiles first before anything else
    // public function __construct(GiftService $gifts)
    // {
    // $gifts->gifts = ['a' , 'b' , 'c' , 'd' , 'e' , 'f'];
    // }



    /**
     * @Route("/home", name="default")
     */
    public function index(GiftService $gifts, Request $request, SessionInterface $session)
    {
        // $users = ['Georges' , 'Fouad' , 'Rosana' , 'Theresa' , 'Jean' , 'Samer'];
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $session->set('name',  'session value');
        // $session->remove('name'); // clear a specific sesion data
        $session->clear(); // clear all sessions data
        // if($session->has('name')){
        //     exit($session->get('name'));
        // }

        // exit($request->query->get('page' , 'default'));
        // exit($request->server->get('HTTP_HOST'));
        // $request->isXmlHttpRequest(); // is it an Ajax request?
        // $request->request->get('page');
        // $request->files->get('foo');

        // exit($request->cookies->get('PHPSESSID'));


        // $entityManager = $this->getDoctrine()->getManager();
        // $user1 = new User; $user2 = new User; $user3 = new User;
        // $user4 = new User; $user5 = new User; $user6 = new User;

        // $user1->setName('Georges');
        // $user1->setAge('20');
        // $user2->setName('Foad');
        // $user2->setAge('20');
        // $user3->setName('Rosana');
        // $user3->setAge('20');
        // $user4->setName('Theresa');
        // $user4->setAge('20');
        // $user5->setName('Jean');
        // $user5->setAge('20');
        // $user6->setName('Samer');
        // $user6->setAge('20');

        // $entityManager->persist($user1); //Preparing user
        // $entityManager->persist($user2); //Preparing user
        // $entityManager->persist($user3); //Preparing user
        // $entityManager->persist($user4); //Preparing user
        // $entityManager->persist($user5); //Preparing user
        // $entityManager->persist($user6); //Preparing user
        // $entityManager->flush(); // Saving to the db

        $this->addFlash(
            'notice',
            'Your changes were added'
        );

        $this->addFlash(
            'warning',
            'test'
        );


        // $cookie = new Cookie(
        //     'my_cookie', // Cookie name
        //     'cookie value', // Cookie value
        //     time() + (2 * 365 * 24 * 60 * 60) // Expires after 2 years
        // );

        // $res = new Response();
        // $res->headers->setCookie($cookie);
        // $res->send(); // how to send cookies to the browser


        // $res = new Response();
        // $res->headers->clearCookie('my_cookie');
        // $res->send();

        if (!$users) {
            throw $this->createNotFoundException('The users do not exist');
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $gifts->gifts,
        ]);
    }


    // adding "?" means that it's not required
    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     * 
     */

    public function index2()
    {
        return new Response('Optional parameters in url and requirements for parameters');
    }


    /**
     * @Route(
     *  "/articles/{_locale}/{year}/{slug}/{category}",
     *  defaults={"category": "computers"},
     *  requirements={
     *      "_locale": "en|fr",
     *      "category": "computers|rtv",
     *      "year": "\d+"
     *  }
     * )
     */


    public function index3()
    {
        return new Response('An advanced route example');
    }

    /**
     * @Route({
     *      "nl": "/over-ons",
     *      "en": "/about-us",
     *      }, name="about_us")
     */

    public function index4()
    {
        return new Response('Translated routes');
    }

    /**
     * @Route("/homes", name="defaults")
     */
    public function index5()
    {
        return new Response('test');
    }









    /**
     * @Route("/generate-url{param?}" , name="generate_url")
     */

    public function generate_url()
    {
        exit($this->generateUrl(
            'generate_url',
            array('param' => 10),
            UrlGeneratorInterface::ABSOLUTE_URL,
        ));
    }

    /**
     * @Route("/download")
     */
    public function download()
    {
        $path = $this->getParameter('download_directory');
        return $this->file($path . 'file.pdf');
    }


    /**
     * @Route("/redirect-test")
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('route_to_redirect', array('param' => 10));
    }

    /**
     * @Route("/url-to-redirect/{param?}" , name="route_to_redirect")
     */
    public function methodToRedirect()
    {
        exit('Test redicrection');
    }

    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController()
    {
        $response = $this->forward(
            'App\Controller\DefaultController::methodToForwardTo',
            array('param' => 1)
        );
        return $response;
    }

    /**
     * @Route("/url-to-forward-to/{param?}" , name="route_to_forward_to")
     */
    public function methodToForwardTo($param)
    {
        exit('Text controller forwarding - ' . $param);
    }


    public function mostPopularPosts($number = 3)
    {
        // database call:
        $posts = ['post 1', 'post 2', 'post 3', 'post 4'];
        return $this->render('default/most_popular_posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * Route("/homee", name="defaultt", name="homee")
     */
    public function index6(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setname('Robert');
        $entityManager->persist($user);
        $entityManager->flush();

        dump('A new user was saved with the id of ' . $user->getId());
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
