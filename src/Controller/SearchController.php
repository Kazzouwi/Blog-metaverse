<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController {

    #[Route('/search', name: 'app_article_search')]
    public function search(Request $request, ArticleRepository $articleRepository)
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);

        $articles = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $articles = $articleRepository->findBySearch($searchData);

            return $this->render('article/articleSearch.html.twig', [
                'form' => $form->createView(),
                'articles' => $articles
            ]);
        }

        return $this->render('article/articleSearch.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles
        ]);
    }
}