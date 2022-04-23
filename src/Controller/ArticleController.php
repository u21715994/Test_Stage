<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine){
        $this->doctrine = $doctrine;
}

    /**
     * @Route("article/liste",name="liste")
     */
    public function liste(){
        $articles = $this->doctrine->getRepository(Article::class)->findAll();
        return $this->render("article/liste.html.twig",['articles' => $articles]);
    }

    /**
     * @Route("article/add",name = "addArticle")
     */
    public function addArticle(Request $request):Response{
        $article = new Article();
        $article->setTitle($request->get('title'));
        $article->setContent($request->get('content'));
        $article->setCover($request->get('cover'));
        $articleForm = $this->createForm(ArticleType::class,$article);
        $articleForm->handleRequest($request);
        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $em = $this->doctrine->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl('liste'));
        }
        return $this->render('article/form_article.html.twig',['articleForm' => $articleForm->createView()]);
    }

    /**
     * @Route("article/edit/form/{id}", name = "editArticle")
     */
    public function editArticle(Request $request, Article $article){
        $articleForm = $this->createForm(ArticleType::class, $article);

        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $this->doctrine->getManager()->flush();
            return $this->redirect($this->generateUrl('liste'));
        }

        return $this->render('article/form_article.html.twig',[
            'articleForm' => $articleForm->createView(),
        ]);
    }

    /**
     * @Route("article/delete/form/{id}", name="deleteArticle")
     */
    public function deleteArticle(Article $article){
        $em = $this->doctrine->getManager();
        
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('liste'));
        $response = new Response();
        $response->send();
    }

}
