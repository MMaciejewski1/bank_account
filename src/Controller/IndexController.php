<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountRepository;
use App\Entity\Customer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
class IndexController extends AbstractController
{
    #[Route('/api/posts', methods: ['GET', 'HEAD'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =  $doctrine->getManager()
            ->getRepository(Customer::class)
            ->findAll();
 
        $data = [];
 
        foreach ($products as $product) {
           $data[] = [
               'id' => $product->getId(),
               'name' => $product->getName(),
               'description' => $product->getDescription(),
           ];
        }
 
 
        return $this->json($data);
    }
}