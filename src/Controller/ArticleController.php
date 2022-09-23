<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/add.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }


    #[Route('/article', name: 'app_article')]
    public function CreateArticle(Request $request,EntityManagerInterface $entityManager): Response
    {
        $article = new Articles();
        $article -> setDate(new \DateTime());
        $idUser = $this->getUser('id');
        $article -> setUser($idUser);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }
        return $this->render('article/add.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }
}
