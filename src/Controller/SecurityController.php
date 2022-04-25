<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        //On crée un nouvel exemplaire de l'entité 'User', afin de pouvoir remplir l'objet via le formulaire, puis insertions en BDD.
        
        $user = new User();

        //On exécute la méthode createForm(de la classe AbstractController), afin de créer un formulaire en rapport avec la classe 'RegistrationType' pour utiliser les getters et setters afin de remplir l'objet $user.

        $form =  $this->createForm(RegistrationType::class, $user, [
            'validation_groups' => ['registration', 'default']
        ]);

        //On définit 'un groupe de validation de contrainte afin qu'elle ne soient prise en compte uniquement lors de l'inscription et nn lors de la modification dans le backOffice.

        $form->handleRequest($request);

        dump($request);

        if($form->isValid() && $form->isSubmitted()){
            //si le formulaire a bien été rempli (isValid) et si il a été envoyé (isSubmitted) et qu'ils correspondent aux bon setters de l'objet $user, alors on entre ic dans le if.

            $hash = $hasher->hashPassword($user, $user->getPassword());

        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
