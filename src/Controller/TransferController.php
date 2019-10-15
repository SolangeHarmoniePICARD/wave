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
use Symfony\Bundle\SwiftmailerBundle\Swiftmailer;
// require_once '../../vendor/autoload.php';

class TransferController extends AbstractController
{
  /**
  * @Route("/", name ="transfer")
  */
  public function new(Request $request){
    $transfer = new Transfer();

    $form = $this->createForm(TransferType::class, $transfer);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      /** @var UploadedFile $userFile */
      $userFile = $form['file']->getData();

      // this condition is needed because the 'file' field is not required
      // so the PDF file must be processed only when a file is uploaded
      if ($userFile) {
          $originalFilename = pathinfo($userFile->getClientOriginalName(), PATHINFO_FILENAME);
          // this is needed to safely include the file name as part of the URL
          $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
          $newFilename = $safeFilename.'-'.uniqid().'.'.$userFile->guessExtension();

          // Move the file to the directory where files are stored
          try {
              $userFile->move(
                  $this->getParameter('files_directory'),
                  $newFilename
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
              echo $e;
          }

          // updates the 'userFilename' property to store the PDF file name
          // instead of its contents
          $transfer->setFilename($newFilename);
          // $this->send_mail($transfer, $mailer);
      }

      // ... persist the $transfer variable or any other work

      // Create the message
      $mail = (new \Swift_Message())
        ->setSubject('Wave - Fichiers envoyés par ' . $fileTransfer->getNameFrom())
        ->setFrom([$fileTransfer->getSender()])
        ->setTo([$fileTransfer->getRecipient()])

        $cid = $mail->embed(\Swift_Image::fromPath('images/spouting-whale.png'));
        $mail->setBody(
          $this->renderView('transfer/email.html.twig', [
            'recipientName' => $fileTransfer->getRecipient(),
            'sender' => $fileTransfer->getSender(),
            'link' => 'zip/'.$fileTransfer->getFileName().'.zip',
            'logo' => $cid
          ]),
          'text/html'
        );

        $mailer->send($mail);
    }

    return $this->render('transfer/index.html.twig', [
      'form'=>$form->createView(),
      'controller_name' => 'TransferController'
    ]);
  }

  /**
  * @Route("/send", name ="send")
  */
  public function send_mail(\Swift_Mailer $mailer)
  {
    // $transport = (new Swift_SmtpTransport('smtp.example.org', 25));
    // Create the Mailer using your created Transport
    // $mailer = new Swift_Mailer($transport);

    // return $this->render(...);
  }

}
