<?php

namespace App\Controller\Admin;

use App\Entity\Artitcle;
use App\Repository\ArtitcleRepository;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminArtitcleController extends AbstractController
{
    // Pour les trois entités (Artitcle, Category, Brand): faire le CRUD complet dans
    // des AdminController

    // Modèle des routes @Route("/admin/create/artitcle/", name="admin_create_artitcle")
    // Bonus : trouver un moyen de pouvoir supprimer des catégories et des brands même
    // si elles sont liés à un artitcle

    /**
     * @Route("admin/artitcles", name="admin_artitcle_list")
     */
    public function adminListArtitcle(ArtitcleRepository $artitcleRepository)
    {
        $artitcles = $artitcleRepository->findAll();

        return $this->render("admin/adminArtitcles.html.twig", ['artitcles' => $artitcles]);
    }

    /**
     * @Route("admin/artitcle/{id}", name="admin_artitcle_show")
     */
    public function adminShowArtitcle($id, ArtitcleRepository $artitcleRepository)
    {
        $artitcle = $artitcleRepository->find($id);

        return $this->render("admin/adminArtitcle.html.twig", ['artitcle' => $artitcle]);
    }

    /**
     * @Route("admin/update/artitcle/{id}", name="admin_update_artitcle")
     */
    public function adminUpdateArtitcle(
        $id,
        ArtitcleRepository $artitcleRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $artitcle = $artitcleRepository->find($id);

        $artitcleForm = $this->createForm(ArtitcleType::class, $artitcle);

        $artitcleForm->handleRequest($request);

        if ($artitcleForm->isSubmitted() && $artitcleForm->isValid()) {
            $entityManagerInterface->persist($artitcle);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_artitcle_list");
        }


        return $this->render("admin/adminArtitcleform.html.twig", ['artitcleForm' => $artitcleForm->createView()]);
    }

    /**
     * @Route("admin/create/artitcle/", name="admin_artitcle_create")
     */
    public function adminArtitcleCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $artitcle = new Artitcle();

        $artitcleForm = $this->createForm(ArtitcleType::class, $artitcle);

        $artitcleForm->handleRequest($request);

        if ($artitcleForm->isSubmitted() && $artitcleForm->isValid()) {
            $entityManagerInterface->persist($artitcle);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_artitcle_list");
        }


        return $this->render("admin/adminArtitcleform.html.twig", ['artitcleForm' => $artitcleForm->createView()]);
    }

    /**
     * @Route("admin/delete/artitcle/{id}", name="admin_delete_artitcle")
     */
    public function adminDeleteArtitcle(
        $id,
        ArtitcleRepository $artitcleRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $artitcle = $artitcleRepository->find($id);

        $entityManagerInterface->remove($artitcle);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_artitcle_list");
    }
}