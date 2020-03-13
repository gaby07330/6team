<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Article;
use App\Form\ArticleFormType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles ,
        ]);
    }

    /**
     * @Route("/new", name="newArticle")
     */
    public function newArticle(Request $request)
    {
    	$article = new Article();

    	$entityManager = $this->getDoctrine()->getManager();
    	$form = $this->createForm(ArticleFormType::class, $article);
		$form->handleRequest(($request));

		if($form->isSubmitted() && $form->isValid())
        {

			$article->setCreatedAt(new \DateTime());
			$article->setIsActive(true);

			$entityManager->persist($article);

			$entityManager->flush();

	        $this->addFlash(
                'success',
                '');

            return $this->redirectToRoute('blog');		
		}

        return $this->render('blog/new.html.twig', [
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/one/{articleId}", name="oneArticle")
     */
    public function oneArticle($articleId)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->find($articleId);

        return $this->render('blog/one.html.twig',[
            'article'=> $article
        ]);

    }



}
