<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    #[route('/admin/products', name: 'app_admin_products')]
    public function adminProducts(ProductRepository $productRepository) : Response
    {

        $em = $this->getDoctrine()->getManager();

        $colonnes = $em->getClassMetadata(Product::class)->getFieldNames();

        $products = $productRepository->findAll();

        return $this->render('admin/products.html.twig', [
            'colonnes' => $colonnes,
            'products' => $products     
        ]);
    }


    #[route('/admin/products/create', name: 'app_admin_products_create')]
    public function adminProductCreate(Request $request, EntityManagerInterface $manager) : Response
    {
        $product = new Product();

        $id = $product->getId();

        $form = $this->createForm(ProductType::class, $product);


        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', "Le produit : '" . $product->getTitle() . "' a bien été ajouté ");

            return $this->redirectToRoute('app_admin_products');

        }


        return $this->render('admin/products/create.html.twig', [
                'form' => $form->createView(),
                'id' => $id
        ]);
    }

    #[route('/admin/products/edit/{id}', name: 'app_admin_products_edit')]
    public function adminProductEdit(Product $product2 ,Request $request, EntityManagerInterface $manager) : Response
    {
        $id = $product2->getId();

        $form = $this->createForm(ProductType::class, $product2);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->flush();


            $this->addFlash('info', "Le produit : '" . $product2->getTitle() . "' a bien été modifié ");

            return $this->redirectToRoute('app_admin_products');
                
        }



        return $this->render('admin/products/edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }


    #[route('/admin/products/delete/{id}', name: 'app_admin_products_delete')]
    public function AdminDeleteProducts(Product $product, EntityManagerInterface $manager) : Response
    {       
        $manager->remove($product);
        $manager->flush();

            $this->addFlash('danger', "Le produit : '" . $product->getTitle() . "' a bien été supprimé ");

        return $this->redirectToRoute('app_admin_products');
    }
}
