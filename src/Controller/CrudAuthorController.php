<?php

namespace App\Controller;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/crud/author')]
class CrudAuthorController extends AbstractController
{
        #[Route('/list', name: 'app_crud_author')]
    public function list(AuthorRepository $repo): Response
    {
        $list =$repo->findall();
       return $this->render('crud_author/list.html.twig',['list'=>$list]);
    }

    #[Route('/search/{name}', name: 'app_crud_search')]
    public function listByname(AuthorRepository $repo, Request $request): Response
    {
        $name =$request->get("name");
        
        $list =$repo->findByName($name);
        
        return $this->render('crud_author/list.html.twig',['list'=>$list]);
    }



    #[Route('/insert', name: 'app_crud_insert')]
    public function insertAuthor(ManagerRegistry $doctrine): Response //in place of ManagerRegistry we can use directly EntityManager
    {
        //data praparation  
        $author=new Author();
        $author->setName("Kais");
        $author->setEmail("Kais@gmail.com");
        $author->setAdresse("monastir");
        $author->setNbrBooks(54);
        //call of the ManagerRegistry to access the getManager to be able touse the mathod persist
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->persist($author);
        $manager->flush();
        
        return $this->redirectToRoute('app_crud_author');
    }

    #[Route('/delete/{id}', name: 'app_crud_delete_author')]
    public function deleteAuthor(ManagerRegistry $doctrine,Author $author): Response
    {

        //call of the ManagerRegistry to access the getManager to be able touse the mathod remove
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->remove($author);
        $manager->flush();

        return $this->redirectToRoute('app_crud_author');

    }




    #[Route('/update/{id}', name: 'app_crud_insert')]
    public function updateAuthor(ManagerRegistry $doctrine,Author $author): Response
    {
        //data update praparation  
        $author->setName("Kais");
        $author->setEmail("Kais@gmail.com");
        $author->setAdresse("monastir");
        $author->setNbrBooks(52);
        //call of the ManagerRegistry to access the getManager to be able touse the mathod persist
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->flush();
        
        return $this->redirectToRoute('app_crud_author');
    }


    


}
