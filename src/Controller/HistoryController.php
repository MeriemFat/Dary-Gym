<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\Evenement;
use App\Form\ArchiveType;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     *@Route("/acceuille",name="acceuille-list")
     */
    public function home()
    {
        $blog= $this->getDoctrine()->getRepository(Archive::class)->findAll();
        return  $this->render('front/history/index.html.twig',['blog' => $blog]);
    }
    /**
     * @Route("/addacceuille", name="acceuille")
     */
    public function Acceuille(Request $request)
    {
        $blog = new Archive();
        $form = $this->createForm(ArchiveType::class, $blog);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('acceuille-list');
        }
        return $this->render("admin/history/history.html.twig",['form'=> $form->createView()]);
    }

}
