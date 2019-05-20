<?php
// src/Controller/BlogController.php
namespace App\Controller;


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
    /**
     * @Route("/blog/list/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page = 1)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }
    public function new()
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'blog_list', correspondant à l'url /blog/list/5
        return $this->redirectToRoute('blog_list', ['page' => 5]);
    }
}
