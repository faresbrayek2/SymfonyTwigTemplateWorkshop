<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use App\Form\AuthorType;



class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showAuthor/{name}', name: 'app_showAuthor')]
    public function showAuthor($name)
    {
        return $this->render('author/show.html.twig', ['n' => $name]);
    }

    #[Route('/showlist', name: 'app_showlist')]
    public function lista()
    {
        $authors = [
            [
                'id' => 1,
                'picture' => '/images/Victor-Hugo.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100,
            ],
            [
                'id' => 2,
                'picture' => '/images/william-shakespeare.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200,
            ],
            [
                'id' => 3,
                'picture' => '/images/Taha_Hussein.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300,
            ],
        ];

        return $this->render("author/list.html.twig", ['authors' => $authors]);
    }

    #[Route('/auhtorDetails/{id}', name: 'app_authorDetails')]

    public function auhtorDetails ($id) {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo','email' => 'victor.hugo@gmail.com','nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare','email' => 'william.shakespeare@gmail.com','nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein','email' => 'taha.hussein@gmail.com','nb_books' => 300),
        );

        return $this->render("author/showAuthor.html.twig",[
            'id' => $id,
            'authors' => $authors,
        ]);
        }
    #[Route('/listAuthor', name: 'list_authors')]
    public function list(AuthorRepository $repository)
    {
        $authors= $repository->findAll();

        return $this->render("author/authors.html.twig",
            array('tabAuthors'=>$authors));
    }

        #[Route('/show/{id}', name: 'showAuthorById')]
    public function showAuthorById($id,AuthorRepository $repository)
    {
        $author= $repository->find($id);
        $Username = $author->getUsername();
        return $this->render("author/showAuthorDetails.html.twig",
            array('author'=>$author));
    }

    
    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAuthor($id,AuthorRepository $repository,ManagerRegistry $managerRegistry)
    {
        $author= $repository->find($id);
        $em= $managerRegistry->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("list_authors");
    }

    #[Route('/addauthor', name: 'add_author')]
    public function addAuthor(ManagerRegistry $managerRegistry)
    {
        $author= new Author();
        $author->setUsername("author4");
        $author->setEmail("author4@gmail.com");
        #1ere method
        #$em= $this->getDoctrine()->getManager();
        #2methode
        $em= $managerRegistry->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute("list_authors");
    }


    #[Route('/update/{id}', name: 'update_author')]
    public function update(ManagerRegistry $managerRegistry,$id,AuthorRepository $repository)
    {
        $author=$repository->find($id);
        $author->setUsername("fares");
        $author->setEmail("fares.brayek@esprit.tn");
        $em= $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("list_authors");
    }

    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $managerRegistry,Request $request)
    {
        $author= new Author();
        $form= $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em= $managerRegistry->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("list_authors");
        }
        return $this->render("author/add.html.twig",
            ['form'=>$form->createView()]);
        // or use renderForm()
    }


}
