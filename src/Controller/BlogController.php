<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            'articles' => $articles,
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

        if ($form->isSubmitted() && $form->isValid()) {

            // ajout Image
            $imgFile = $form['ImgName']->getData();
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imgFile->move(
                        $this->getParameter('imgArticle_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->setImgName($newFilename);
                //EO

                $article->setCreatedAt(new \DateTime());
                $article->setIsActive(true);

                $entityManager->persist($article);

                $entityManager->flush();

                $this->addFlash(
                    'success',
                    ''
                );

                return $this->redirectToRoute('blog');
            }
        }
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/one/{articleId}", name="oneArticle")
     */
    public function oneArticle($articleId)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->find($articleId);

        return $this->render('blog/one.html.twig', [
            'article' => $article
        ]);
    }
}
