<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
