<?php
// src/Controller/StripeController.php
namespace App\Controller;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function payment(Request $request): Response
    {
        // Configure Stripe avec votre clé secrète
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Créer une session de paiement
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'dzd',
                        'product_data' => [
                            'name' => 'Chambre test',
                        ],
                        'unit_amount' => 20000, // Montant en centimes (20 USD)
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment', // Mode paiement unique
            'success_url' => $this->generateUrl('payment_success', [], 0), // URL de succès après paiement
            'cancel_url' => $this->generateUrl('payment_cancel', [], 0), // URL de retour en cas d'annulation
        ]);

        // Rediriger l'utilisateur vers la page de paiement
        return $this->redirect($session->url);
    }

    #[Route('/payment-success', name: 'payment_success')]
    public function paymentSuccess(): Response
    {
        return $this->render('stripe/success.html.twig');
    }

    #[Route('/payment-cancel', name: 'payment_cancel')]
    public function paymentCancel(): Response
    {
        return $this->render('stripe/cancel.html.twig');
    }
}

