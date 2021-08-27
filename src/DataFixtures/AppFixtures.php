<?php
    namespace App\Controller;

    use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;

    
    
    
    class AppFixtures extends AbstractController{
        /**
         * Route("/homee", name="defaultt", name="homee")
         */
        public function index(Request $request){
            
            $entityManager = $this->$this->getDoctrine()->getManager();
        
            $user = new User();
            $user->setname('Robert');
            $entityManager->persists($user);
            $entityManager->flush();

            dump('A new user was saved with the id of '. $user->getId());
            return $this->render('default/index.html.twig',[
                'controller_name' => 'DefaultController'
            ]);

        
        
        }
    }
