<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function SingleArticle(Request $request, EntityManagerInterface $entityManager, Articles $article): Response
    {
        $comment = new Commentaires();
        $comment -> setDate(new \DateTime());
        $User = $this->getUser();
        $comment->setUser($User);
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        dump($article);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render('blog/detail.html.twig', [
            'commentForm' => $form->createView(),
            'article' => $article
        ]);
    }
}