<?php
namespace App\Controller\Service;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountRepository;
use App\Entity\TransDetails;
use Doctrine\Persistence\ManagerRegistry;
class TransactionServive
{

    public static  function newTransaction(string $acnumber, string $type, int $value,int $amount,ManagerRegistry $doctrine)
    {
        $t = new TransDetails();
        $t->setAcnumber($acnumber);
        $t->setMedium($type);
        $t->setValue($value);
        $t->setAmount($amount);
        $t->setDot(new \DateTime());
        $em = $doctrine->getManager();
        $em->persist($t);
        $em->flush();
    }
}