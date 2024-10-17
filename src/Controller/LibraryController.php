<?php

namespace App\Controller;

use App\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Name;
use Symfony\Component\HttpFoundation\Request;

#[Route('/library')]
class LibraryController extends AbstractController
{   
    #[Route('/showForm', name: 'app_crud_library')]
    public function showForm(): Response{
        return $this->render('library/library.html.twig');
    }




    #[Route('/read', name: 'app_crud_read')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $libraryRepository = $doctrine->getRepository(Library::class);
        $list = $libraryRepository->findAll();
       return $this->render('library/libraryList.html.twig',['list'=>$list]);
    }


    #[Route('/create', name: 'app_crud_create')]
    public function insertLib(ManagerRegistry $doctrine , Request $request): Response
    {
        //data praparation  
        $lib=new Library();
        $lib->setName($request->request->get('name'));
        $lib->setWebSite($request->request->get('webSite'));
        $lib->setDateCreation(new \DateTime($request->request->get('dateCreation')));


        //call of the ManagerRegistry to access the getManager to be able touse the mathod persist
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->persist($lib);
        $manager->flush();
        
        return $this->redirectToRoute('app_crud_read');
    }
    #[Route('/update/{id}', name: 'app_crud_update')]
    public function modifLib(ManagerRegistry $doctrine , Request $request): Response
    {
        //data praparation  
        $lib=new Library();
        $lib->setName("modif");
        $lib->setWebSite("modif.tn");


        //call of the ManagerRegistry to access the getManager to be able touse the mathod persist
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->flush();
        
        return $this->redirectToRoute('app_crud_read');
    }

    #[Route('/delete/{id}', name: 'app_delete_lib')]
    public function deleteLib(ManagerRegistry $doctrine,Library $library): Response
    {

        //call of the ManagerRegistry to access the getManager to be able touse the mathod remove
        $manager=$doctrine->getManager();
        // data praparation in the database 
        $manager->remove($library);
        $manager->flush();

        return $this->redirectToRoute('app_crud_read');

    }
}
