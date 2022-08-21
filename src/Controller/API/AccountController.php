<?php
namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountRepository;
use App\Entity\Account;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Controller\Service\TransactionServive;
use App\Service\SecurityUser;

class AccountController extends AbstractController
{
    private ?SecurityUser $user=null; 

    #[Route('/api/account', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        if(!$this->user){
            $this->user = new SecurityUser($doctrine);
        }
        $products =  $doctrine->getManager()
            ->getRepository(Account::class)
            ->findBy(['mail'=>$this->user->getEmail()]);
 
        $data = [];
        foreach($products as $product){
           $data[] = [
               'id' => $product->getAcid(),
               'name' => $product->getOpeningBalance(),
               'description' => $product->getMail(),
           ];
        }
        return $this->json($data);
    }
    #[Route('/api/account/create', methods: ['GET'])]
    public function create(ManagerRegistry $doctrine): Response
    {
            if(!$this->user){
                $this->user = new SecurityUser($doctrine);
            }
            $ac = new Account();
            $num = 'PL91' . substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(14/strlen($x)) )),1,14);
            $ac->setAcid($num);
            $ac->setMail($this->user->getEmail());
            $ac->setPassword(md5($this->user->getPassword()));
            $ac->setStatus('active');
            $ac->setOpeningBalance(0);
            $ac->setDate(new \DateTime());
            $em = $doctrine->getManager();
            $em->persist($ac);
            $em->flush();

            return $this->json($num);

    }
    #[Route('/api/account/login/{mail}/{password}', methods: ['GET'])]
    public function login(ManagerRegistry $doctrine,string $mail,string $password): Response
    {
        if(!$this->user){
            $this->user = new SecurityUser($doctrine);
        }

       return $this->json($this->user->getUser($mail,$password));

    }
    #[Route('/api/account/addFunds/{id}/{value}', methods: ['GET'])]
    public function addFunds(ManagerRegistry $doctrine,int $id,int $value): Response
    {
        $product =  $doctrine->getManager()
            ->getRepository(Account::class)
            ->findOneBy(['acid'=>$id]);

        $product->setOpeningBalance($product->getOpeningBalance() + $value);
        $doctrine->getManager()->flush();
 
        TransactionServive::newTransaction($id,'add',$product->getOpeningBalance(),$value,$doctrine);

        return $this->json($product->getOpeningBalance());
    }
    #[Route('/api/account/withdrawFunds/{id}/{value}', methods: ['GET'])]
    public function withdrawFunds(ManagerRegistry $doctrine,string $id,int $value): Response
    {
        $product =  $doctrine->getManager()
        ->getRepository(Account::class)
        ->findOneBy(['acid'=>$id]);

        $product->setOpeningBalance($product->getOpeningBalance() - $value);
        $doctrine->getManager()->flush();
        TransactionServive::newTransaction($id,'withdraw',$product->getOpeningBalance(),$value,$doctrine);

        return $this->json($product->getOpeningBalance());
    }
    #[Route('/api/account/checkFunds/{id}', methods: ['GET'])]
    public function checkFunds(ManagerRegistry $doctrine,string $id): Response
    {
        $product =  $doctrine->getManager()
            ->getRepository(Account::class)
            ->findOneBy(['acid'=>$id]);
 
        return $this->json($product->getOpeningBalance());
    }
}