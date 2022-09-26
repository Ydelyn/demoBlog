<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Form\ArticleType;


use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(ArticleRepository $repo)
    {

        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController', 'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur mon DemoBlog',
            'age' => 25
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager)
    { // initialement function create()

        // Si il n' y a pas d'articles, ajouter un nouvel article
        if (!$article) {
            $article = new Article(); // nous déclarons un article qui est vide mais pret à être rempli
        }
        $article->setTitle('Titre à la con')
            ->setContent('Contenu de l\'article');
        // $form est un objet complexe, nous allons demander à symfony de nous stocker leformulaire dans une variable simple à utilier.
        // $form = $this->createFormBuilder($article) // cela va créer un objet qui est lié à notre article
        //     // add() fonction permettant de créer des champs dans un formulaire
        //     ->add('title')
        //     ->add('content')
        //     ->add('image')
        //     ->getForm(); // permet d'afficher le rendu final
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        // si le formulaire est bien soumit et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // si l'article n'a pas d'identifiant, donc pour une insertion, on ajoute la date de création
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime()); // on ajoute la date à l'insertion
            }
            $manager->persist($article); // on prépare l'insertion
            $manager->flush(); // on insère
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]); // on redirige vers la page 'show.html.twig' avec le bon ID une fois l'articlecrée
        }
        return $this->render('blog/create.html.twig', [
            // createView() va retourner un petit objet qui représente l'affichage du formulaire, on le récupère sur la page create.html.twig
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/contact", name="blog_contact")
     */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre Email a bien été envoyé');
            $manager->persist($contact); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion
        }

        return $this->render("blog/contact.html.twig", [
            'formContact' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article, Request $request, EntityManagerInterface $manager)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime()) // on génère la date pour l'insertion
                ->setArticle($article); // on relie l'article au commentaire
            $manager->persist($comment); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }
}
