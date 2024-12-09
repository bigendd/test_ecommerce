<?php

namespace App\Controller\Admin;

use App\Entity\Apartments;
use App\Entity\Images;
use App\Form\ApartmentsType;
use App\Repository\ApartmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/apartments')]
final class AdminApartmentsController extends AbstractController
{
    #[Route(name: 'app_admin_apartments_index', methods: ['GET'])]
    public function index(ApartmentsRepository $apartmentsRepository): Response
    {
        return $this->render('admin_apartments/index.html.twig', [
            'apartments' => $apartmentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_apartments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $apartment = new Apartments();
        $form = $this->createForm(ApartmentsType::class, $apartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les fichiers d'images
            $files = $form->get('images')->getData();
            
            if ($files) {
                foreach ($files as $file) {
                    // Créer un nom unique pour chaque image
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    
                    // Déplacer l'image dans le répertoire des uploads
                    $file->move(
                        $this->getParameter('images_directory'), // Paramètre défini dans services.yaml
                        $filename
                    );

                    // Créer une nouvelle instance de l'entité Image et l'associer à l'appartement
                    $image = new Images();
                    $image->setUrl($filename);
                    $image->setApartments($apartment); // Associer l'image à l'appartement
                    $apartment->addImage($image); // Ajouter l'image à l'appartement
                }
            }

            // Sauvegarder l'appartement et ses images
            $entityManager->persist($apartment);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_apartments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_apartments/new.html.twig', [
            'apartment' => $apartment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_apartments_show', methods: ['GET'])]
    public function show(Apartments $apartment): Response
    {
        return $this->render('admin_apartments/show.html.twig', [
            'apartment' => $apartment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_apartments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apartments $apartment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApartmentsType::class, $apartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'ajout de nouvelles images
            $files = $form->get('images')->getData();
            
            if ($files) {
                foreach ($files as $file) {
                    // Créer un nom unique pour chaque image
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    
                    // Déplacer l'image dans le répertoire des uploads
                    $file->move(
                        $this->getParameter('images_directory'), // Paramètre défini dans services.yaml
                        $filename
                    );

                    // Créer une nouvelle instance de l'entité Image et l'associer à l'appartement
                    $image = new Images();
                    $image->setUrl($filename);
                    $image->setApartments($apartment); // Associer l'image à l'appartement
                    $apartment->addImage($image); // Ajouter l'image à l'appartement
                }
            }

            // Sauvegarder l'appartement et ses images
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_apartments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_apartments/edit.html.twig', [
            'apartment' => $apartment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_apartments_delete', methods: ['POST'])]
    public function delete(Request $request, Apartments $apartment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $apartment->getId(), $request->get('_token'))) {
            // Supprimer les images liées à l'appartement (optionnel, si vous souhaitez supprimer les fichiers)
            foreach ($apartment->getImages() as $image) {
                $filePath = $this->getParameter('images_directory') . '/' . $image->getUrl();
                if (file_exists($filePath)) {
                    unlink($filePath); // Supprimer le fichier de l'image
                }
                $entityManager->remove($image); // Supprimer l'entité Image
            }

            $entityManager->remove($apartment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_apartments_index', [], Response::HTTP_SEE_OTHER);
    }
}
