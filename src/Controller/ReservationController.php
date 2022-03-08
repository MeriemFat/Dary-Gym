<?php

namespace App\Controller;
use App\Controller\ParticipationController;
use App\Entity\Participation;
use App\Entity\Evenement;
use App\Entity\Reservation;
use App\Form\EvenementType;
use App\Form\ReservationType;
use App\Repository\EvenementRepository;
use App\Repository\ReservationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReservationController extends AbstractController
{
    /**
     *@Route("/reserve",name="reservation-list")
     */
    public function home()
    {
        $reservation= $this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return  $this->render('front/reservation/index.html.twig',['evenement' => $reservation]);
    }

    /**
     * @Route("/reserver", name="Ajoute-reserve")
     */
    public function Reserver(Request $request ,\Swift_Mailer $mailer)
    {
        $reserve = new Reservation();
        $form = $this->createForm(ReservationType::class, $reserve);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserve);
            $em->flush();
            $message = (new \Swift_Message('Bienvenu'))
                ->setFrom('fathallah.meriem@esprit.tn')
                ->setTo($reserve->getEmailParticipent())
                ->setBody('bienvenu votre réservation a était enregistrer')
            ;
            $mailer->send($message);
            return $this->redirectToRoute('part-list');
        }
        return $this->render("front/reservation/reservation.html.twig",['form'=> $form->createView()]);
    }

    /**
     * @Route("/searchEventajax ", name="ajaxevent")
     */
    public function searchEventeajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $requestString=$request->get('searchValue');
        $events = $repository->findEvenetbyname($requestString);

        return $this->render('front/reservation/eventajax.html.twig', [
            "evenement"=>$events
        ]);
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getnom();
        }

        return $realEntities;
    }
/*
    /**
     * @Route("/pdf/{id}", name="pdf",methods={"GET"})
     */
    /*
    public function pdf(EvenementRepository $repository , $id)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $events=$repository->find($id);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('front/reservation/pdf.html.twig', [
            "event"=>$events
        ]);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
*/
    /**
     * @Route("/qrcode/{id}",name="qrcode")
     */
    public function qrcode(BuilderInterface $customQrCodeBuilder , $id , EvenementRepository$repository)
    {
        $events = $repository->find($id);
        return new QrCodeResponse($customQrCodeBuilder->size(400)
            ->margin(20)
            ->data('Votre ticket sou le nom de levenement :  '.'nom: '.$events->getNom().'   '.' prix: '.$events->getPrix())
            ->build());
    }


    /**
     * @Route("/reservation/create-checkout-session", name="checkout")
     */
    public function checkout()
    {
        \Stripe\Stripe::setApiKey('sk_test_51ITrmKDemurknTpxCDhbkbloGf2Vp9zDeOfOF80IVNhYUS5RnsYtvcYPYXr1dyygpj70e127PbPpr5HRLqqspqSO00H1gDbJGa');
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'ticket-evenement',
                    ],
                    'unit_amount'=> '20 DT',
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            # These placeholder URLs will be replaced in a following step.
            'success_url'=> $this->generateUrl('success',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('echec',[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse(['id'=>$session->id]);
    }

    /**
     * @Route("/reservation/success", name="success")
     */

    public function success(): Response
    {

        return $this->render('front/reservation/success.html.twig', [

        ]);
    }

    /**
     * @Route("/reservation/echec", name="echec")
     */


    public function echec(): Response
    {
        return $this->render('front/reservation/echec.html.twig', [

        ]);
    }


}
