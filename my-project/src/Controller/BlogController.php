<?php
// src/Controller/BlogController.php
namespace App\Controller;


use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Thomas',
        ]);
    }

    public function new()
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'blog_list', correspondant à l'url /blog/list/5
        return $this->redirectToRoute('blog_list', ['page' => 5]);
    }

    /**
     * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9-\.:\/\/=&]+"},
     *     name="blog_show")
     */
    public function show(string $slug='Mon premier slug')
    {
        $title = ucwords(str_replace('-', ' ', $slug));
        return $this->render('blog/show.html.twig', [
            'slug' => $title,
        ]);
    }
}

