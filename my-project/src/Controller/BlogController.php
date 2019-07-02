<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'default.html.twig',
            ['articles' => $articles]
        );
    }

    public function new()
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'blog_list', correspondant à l'url /blog/list/5
        return $this->redirectToRoute('blog_list', ['page' => 5]);
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="show")
     * @return Response A response instance
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException("No slug has been sent to find an article in article's table.");
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     * @return Response A response instance
     */
    public function showByCategory(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(category::class)
            ->findOneBy(['name' => mb_strtolower($categoryName)]);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(["Category" => ($category)], ['id' =>'DESC'], 3);
        return $this->render(
            'blog/category.html.twig',
            [
                'category' => $category,
                'articles' => $articles,

            ]
        );

    }
}
