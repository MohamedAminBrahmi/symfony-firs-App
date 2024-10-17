<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/new', name: 'app_new_book')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $book = new Book();

        $form=$this->createForm(BookType::class, $book);
       
        $form=$form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
            $manager = $doctrine->getManager();
            $manager->persist($book);
            $manager->flush();
        }
        return $this->render('book/form.html.twig',[
            'form' => $form->createView()]);
        
    }

    #[Route('/list', name: 'app_list_book')]
    public function listBook(BookRepository $repo):Response{
        $list =$repo->findAll();
        return $this->render('book/index.html.twig',['list'=>$list]);
    }






}
