<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountRepository;
use App\Entity\Customer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\SecurityUser;
use Symfony\Component\HttpFoundation\Request;
class IndexController extends AbstractController
{
    private ?SecurityUser $user=null; 
    #[Route('/', methods: ['GET', 'HEAD'], name:"index")]
    public function index(ManagerRegistry $doctrine): Response
    {
        if(!$this->user){
            $this->user = new SecurityUser($doctrine);
        }

        if($this->user->checkCredentials()){

            return $this->render('index.html.twig', [
                'mail' => $this->user->getEmail()
            ]);

        }
        else{
            return $this->render('login.html.twig', [
                'name' => ''
            ]);
        }
    }
    #[Route('/login', methods: ['POST'])]
    public function login(ManagerRegistry $doctrine,Request $request): Response
    {
        if(!$this->user){
            $this->user = new SecurityUser($doctrine);
        }

        $this->user->getUser($request->request->get('email'),$request->request->get('password'));
        
        return $this->redirectToRoute('index');
    }


}