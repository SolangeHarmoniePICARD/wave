<?php

namespace App\Controller;

use App\Form\TransferType;
use App\Entity\Transfer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TransferController extends AbstractController
{

    // public function index()
    // {
    //     return $this->render('transfer/index.html.twig', [
    //         'controller_name' => 'TransferController',
    //     ]);
    // }

    //créer un formulaire pour transfert

     /**
      * @Route("/transfer/new")
      */
    public function new (){
      $transfer = new Transfer();
      $transfer->setFileName("test");
      $transfer->setSender("test sender");
      $transfer->setRecipient("test recipient");

      $form = $this->createForm(TransferType::class, $transfer);

      return $this->render('transfer/index.html.twig', [
        'form'=>$form->createView(),
        'controller_name' => 'TransferController'
      ]);
    }
}
