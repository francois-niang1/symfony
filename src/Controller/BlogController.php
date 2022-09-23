<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/** * Class BlogController * @package App\Controller  */

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]

    public function index(ArticlesRepository $articlesRepository, Request $request): Response
    {
        $articles = $articlesRepository->findBy([],['date' => 'DESC']);
        dump($articles);
        return $this->render('blog/index.html.twig', [ 'articles' => $articles, ]);
    }

    #[Route('/blog/detail/{id}', name: 'detail')]
    public function SingleArticle(Articles $article): Response
    {
        return $this->render('blog/detail.html.twig', compact('article'));
    }
}