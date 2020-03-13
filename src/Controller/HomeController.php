<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Home;
use App\Form\HomeType;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
    	$repository = $this->getDoctrine()->getRepository(Home::class);

        $bandeau = $repository ->findOneBy(['position'=>'bandeau']);
        $porfolio1 = $repository ->findOneBy(['position'=>'porfolio 1']);
        $porfolio2 = $repository ->findOneBy(['position'=>'porfolio 2']);
        $porfolio3 = $repository ->findOneBy(['position'=>'porfolio 3']);
        $porfolio4 = $repository ->findOneBy(['position'=>'porfolio 4']);
    	
        return $this->render('home/index.html.twig', [
            'bandeau'=>$bandeau , 
            'porfolio1'=> $porfolio1,
            'porfolio2'=> $porfolio2,
            'porfolio3'=> $porfolio3,
            'porfolio4'=> $porfolio4
        ]);
    }


    /**
     * @Route("/home/set/{homeId}", name="setHome")
     */
    public function setHome(Request $request, $homeId )
    {
        // Récupération de l'element
        $repository = $this->getDoctrine()->getRepository(Home::class);
        $home = $repository->find($homeId);

        // Initialisation du formulaire
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(HomeType::class, $home);

        $form->handleRequest(($request));

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($home);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Modification réussi');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/update.html.twig',[
            'form'=> $form->createView(),
        ]);

    }//EO setHome





}
