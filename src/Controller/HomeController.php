<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $articles = $articleRepository->findBy([], ['id' => 'DESC'], 5);
        $categories = $categoryRepository->findAll();

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}