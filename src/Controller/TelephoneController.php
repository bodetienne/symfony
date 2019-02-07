<?php

// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Tel;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TelephoneType;

// notre controller doit forcément hériter de la classe Controller ("use" ci-dessus)
// Le nom de la classe doit être exactement le même que celui du fichier
class TelephoneController extends Controller
{
  public function add($marque, $type, $taille){
    $tel = new Tel();
    $tel->setMarque($marque);
    $tel->setType($type);
    $tel->setTaille($taille);

    $em = $this->getDoctrine()->getManager();
    $em->persist($tel);
    $em->flush();
  }

  // public function modify($id, $marque, $type, $taille){
  //     $tel = $this->getDoctrine()->getRepository(Tel::class)->find($id);
  //     if(isset($tel)){
  //       $tel->setMarque($marque);
  //       $tel->setType($type);
  //       $tel->setTaille($taille);
  //
  //       $em = $this->getDoctrine()->getManager();
  //       $em->persist($tel);
  //       $em->flush();
  //       return new Response('La base de donnée a été modifiée');
  //     } else {
  //       return new Response('L\'id entré est nul');
  //     }
  // }

  public function delete($id){
    $tel = $this->getDoctrine()->getRepository(Tel::class)->find($id);
    if(isset($tel)){
      $em = $this->getDoctrine()->getManager();
      $em->remove($tel);
      $em->flush();
      return new Response('La base de donnée a été modifiée');
    } else {
      return new Response('L\'id entré est nul');
    }
  }


  public function index(){
    // création du repository en lui précisant l'entité associée
    $repo = $this->getDoctrine()->getRepository(Tel::class);
    $tels = $repo->findAll();
    return $this->render('index_telephone.html.twig', array(
      'tels' => $tels
    ));
  }

  public function bigTel(){
    $repo = $this->getDoctrine()->getRepository(Tel::class);

    //$bigtels = $repo->findBiggerSizeThan(5.5);
    $bigtels = $repo->findBiggerSizeThanQb(5.5);
    //var_dump($bigtels);
    return $this->render('tel_by_size.html.twig', array(
      'bigtels' => $bigtels
    ));
  }

  public function recherche_marque($marque){
      $repo = $this->getDoctrine()->getRepository(Tel::class);
      $tels = $repo->findTelBy($marque);
      //var_dump($tels);
      return $this->render('tel_by.html.twig', array(
        'tels' => $tels
      ));
  }

  public function url_request($marque, $type){
    $repo = $this->getDoctrine()->getRepository(Tel::class);
    $tels = $repo->findByUrlQb($marque, $type);
    return $this->render('tel_by.html.twig', array(
      'tels' => $tels
    ));
  }

  public function form_tel(Request $request)
  {
      $tel = new Tel();

      // Nous précisons ici que nous voulons utiliser `TelephoneType` et hydrater $tel
      $form = $this->createForm(TelephoneType::class, $tel, [
        'action_name' => 'create' // valeur a envoyer
      ]);

      // nous récupérons ici les informations du formulaire validée
      // c'est-à-dire l'équivalent du $_POST
      // ... et ce, grâce à l'objet $request
      // qui représente les informations sur la requête HTTP reçue (voir l'explication après le code)
      $form->handleRequest($request);

      // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
      if ($form->isSubmitted() && $form->isValid()) {
          // nous enregistrons directement l'objet $tel !
          // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
          $em = $this->getDoctrine()->getManager();
          $em->persist($tel);
          $em->flush();

          // nous redirigeons l'utilisateur vers la route /telephone/
          // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml
          // (il est peut-être différent pour vous, adaptez en conséquence)
          // extrèmement pratique : si nous devons changer l'url en elle-même,
          // nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
          return $this->redirectToRoute('index');
      }

      return $this->render('telephone/new.html.twig', array(
          'form' => $form->createView(),
      ));
  }

  public function modify(Request $request, $id){

    $repo = $this->getDoctrine()->getRepository(Tel::class);
    $tel = $repo->find($id);
    //var_dump($tel);
    if(!isset($tel)){
      return new Response('L\'id entré est nul');
    } else {


      // Nous précisons ici que nous voulons utiliser `TelephoneType` et hydrater $tel

      $form = $this->createForm(TelephoneType::class, $tel, [
        'action_name' => 'modify' // valeur a envoyer
      ]);

      // nous récupérons ici les informations du formulaire validée c'est-à-dire l'équivalent du $_POST
      // ... et ce, grâce à l'objet $request qui représente les informations sur la requête HTTP reçue (voir l'explication après le code)
      $form->handleRequest($request);

      // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
      if ($form->isSubmitted() && $form->isValid()) {
          // nous enregistrons directement l'objet $tel !
          // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
          $em = $this->getDoctrine()->getManager();
          $em->persist($tel);
          $em->flush();

          // nous redirigeons l'utilisateur vers la route /telephone/
          // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml (il est peut-être différent pour vous, adaptez en conséquence)
          // extrèmement pratique : si nous devons changer l'url en elle-même, nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
          return $this->redirectToRoute('index');
      }

      return $this->render('telephone/new.html.twig', array(
          'form' => $form->createView(),

      ));
    }

  }


}
?>
