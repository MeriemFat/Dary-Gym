<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class ParticipationController extends AbstractController
{
    /** @var Client $twilio */
        private $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * @Route("/list",name="part-list")
     */
    public function participant()
    {
        $parte = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render('admin/participant/index.html.twig', ['reservation' => $parte]);
    }

    /**
     * @Route("/qrcode/{id}",name="qrcode")
     */
    public function qrcode(BuilderInterface $customQrCodeBuilder , $id , ReservationRepository$repository)
    {

        $reservation = $repository->find($id);
        return new QrCodeResponse($customQrCodeBuilder->size(400)
        ->margin(20)
        ->data('nompart : '.$reservation->getNamepart().'ville : '.$reservation->getVille())
        ->build());
    }
    /**
     * @Route("/supprimer/{id}", name="deleteParticipants")
     */
    public function supppart($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //recupere le classroom a supprime
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

        //on passe a la supppresion
        $em->remove($reservation);
        $em->flush();

        $phone_number = $reservation->getNumtelephonepart();
        $name = $reservation->getNamepart();

        $this->twilio->messages->create(
            '+216'.$phone_number,
            [ 'from' => getenv('TWILIO_NUMBER'),
            'body' => "Désolé M./Mme. ".$name.". Votre participation a été annulée." ]);

        return $this->redirectToRoute('part-list');

    }
}
