<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category-list", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        $categoryList = $this   ->getDoctrine()
                                ->getRepository(Category::class)
                                ->findAll();

        return $this->render('ad/_navbarre.html.twig', ['categoryList' => $categoryList]);

    }

}
