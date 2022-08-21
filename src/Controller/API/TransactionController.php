<?php
namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountRepository;
use App\Entity\TransDetails;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
class TransactionController extends AbstractController
{
    #[Route('/api/transaction/history/{id}', methods: ['GET', 'HEAD'])]
    public function history(ManagerRegistry $doctrine,string $id): Response
    {
        $products =  $doctrine->getManager()
            ->getRepository(TransDetails::class)
            ->findBy(['acnumber'=>$id]);
 
        $data = [];
 
        foreach ($products as $product) {
           $data[] = [
               'date' => $product->getDot()->format('Y-m-d'),
               'type' => $product->getMedium(),
               'Amount' => $product->getAmount(),
               'Value' => $product->getValue(),
           ];
        }
 
 
        return $this->json($data);
    }
}