<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\Category as CategoryAlias;
use App\Form\AdType;
use App\Repository\AdRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/ad")
 */
class AdController extends AbstractController
{
    /**
     * @Route("/", name="ad-list", methods={"GET"})
     * @param AdRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(AdRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $adList = $paginator->paginate(
            $repository->getAllAds(),
            $request->query->getInt('page', 1),
            10
        );

        $params = $this->getTwigParametersWithAside(
            ['adList' => $adList, 'pageTitle' => '']
        );

        return $this->render('ad/index.html.twig', $params);
    }

    private function getTwigParametersWithAside($data){
        $navData = ['categoryList' => $this->getDoctrine()->getRepository(Category::class)->findAll()];
        return array_merge($data, $navData);
    }

    /**
     * @Route("/new", name="ad-new", methods={"GET","POST"})
     * @param Request $request
     * @param CategoryAlias $categoryList
     * @return Response
     */
    public function new(Request $request): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //gestion de l'upload de la photo
            /**
             * @var UploadedFile $uploadedFile
             */
            $uploadedFile = $form['photoInput']->getData();

            if($uploadedFile){
                $newFileName = uniqid('photo_').'.'. $uploadedFile->guessExtension();

                $uploadedFile->move(
                    $this->getParameter('ad.photo.path'),
                    $newFileName
                );

                $ad->setPhoto($newFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();

            $this->addFlash('success', "Ton annonce est publiée !");

            return $this->redirectToRoute('ad-list');
        }

        return $this->render('ad/new.html.twig', [
            'adForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/by-category/{id}", name="show-by-category", requirements={"id":"\d+"})
     * @param Category $category
     * @param AdRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function showByCategory(Category $category, AdRepository $repository, PaginatorInterface $paginator, Request $request){
        $adList = $paginator->paginate(
            $repository->getAllByCategory($category),
            $request->query->getInt('page', 1),
            20
        );
        $params = $this->getTwigParametersWithAside(
            ['adList' => $adList, 'pageTitle' => "de la catégorie : ". $category->getTitleCategory()]
        );
        return $this->render('ad/index.html.twig', $params);
    }

    /**
     * @Route("/{id}", name="ad-details", methods={"GET"})
     */
    public function show(Ad $ad): Response
    {
        return $this->render('ad/details.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ad-edit", methods={"GET","POST"})
     * @param Request $request
     * @param Ad $ad
     * @return Response
     */
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //gestion de l'upload de la photo
            /**
             * @var UploadedFile $uploadedFile
             */
            $uploadedFile = $form['photoInput']->getData();

            if($uploadedFile){
                $newFileName = uniqid('photo_').'.'. $uploadedFile->guessExtension();

                $uploadedFile->move(
                    $this->getParameter('ad.photo.path'),
                    $newFileName
                );

                $ad->setPhoto($newFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Ton annonce est modifiée !");

            return $this->redirectToRoute('ad-list');
        }

        return $this->render('ad/edit.html.twig', [
            'adForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ad-delete", methods={"DELETE"})
     * @param Request $request
     * @param Ad $ad
     * @return Response
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad-list');
    }
}
