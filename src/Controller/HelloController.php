<?php

// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;
use App\Service\SweatMessageGenerator;

// notre controller doit forcément hériter de la classe Controller ("use" ci-dessus)
// Le nom de la classe doit être exactement le même que celui du fichier
class HelloController extends Controller
{
    public function index(LoggerInterface $logger)
    {
        // on renvoie ici un texte simple. Une instance de Response doit toujours être renvoyée.
        // return $this->render("hello.html.twig");

        // $prenom1 = "Thomas";
        // $prenom2 = "Alex";
        // return $this->render('_helloprenom.html.twig', array(
        //     "prenom1" => $prenom1,
        //     "prenom2" => $prenom2,
        // ));

        $logger->info("Mon joli log");

        return $this->render('hello.html.twig');

    }

    public function index_perso($prenom, $age){
      return $this->render('hello_perso.html.twig', array(
          "prenom" => $prenom,
          "age" => $age,
      ));
    }

    public function index_perso_error1($age, $prenom){
      return $this->render('hello_perso_error1.html.twig', array(
          "age" => $age,
          "prenom" => $prenom,
      ));
    }

    public function index_prenom($prenom){
      return $this->render('hello_prenom.html.twig', array(
        "prenom" => $prenom
      ));
    }

    public function sendMail($name, \Swift_Mailer $mailer){
      $message = (new \Swift_Message('Coucou beau brun'))
        ->setFrom('bodet.etienne79@gmail.com')
        ->setTo('bodet.etienne79@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails.html.twig
                'emails.html.twig',
                ['name' => $name]
            ),
            'text/html'
        );

      $mailer->send($message);

      //var_dump($message);

      return $this->render('emails.html.twig', array(
        'name' => $name,
      ));
    }

    public function messageGenerator(SweatMessageGenerator $messages){
      //$service = new SweatMessageGenerator();

      return $this->render('sweatmessage.html.twig', array(
        'messages' => $messages->getSweatMessage()
      ));

    }

}

?>
