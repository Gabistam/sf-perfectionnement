<?php

namespace App\Controller\Front;

use App\Repository\WriterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;

class WriterController extends AbstractController
{

    public function writerList(WriterRepository $writerRepository)
    {
        $writers = $writerRepository->findAll();

        return $this->render("front/writers.html.twig", ['writers' => $writers]);
    }

    public function writerShow($id, WriterRepository $writerRepository)
    {
        $writer = $writerRepository->find($id);

        return $this->render("front/writer.html.twig", ['writer' => $writer]);
    }


    public function frontSearch(Request $request, WriterRepository $writerRepository)
    {

        // Récupérer les données rentrées dans le formulaire
        $term = $request->query->get('term');
        // query correspond à l'outil qui permet de récupérer les données d'un formulaire en get
        // pour un formulaire en post on utilise query

        $writers = $writerRepository->searchByTerm($term);

        return $this->render('front/search.html.twig', ['writers' => $writers, 'term' => $term]);
    }
}