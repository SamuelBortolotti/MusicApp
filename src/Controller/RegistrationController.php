<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hachage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            
            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/registerAll', name: 'app_register_multiple_users')]
    public function registerMultiple(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $content = file_get_contents($request->files->get('csv_users'));
        $content_array = preg_split("/\r\n|\n|\r/", $content);

        foreach ($content_array as $line) {
            $datas = explode(";", $line);

            $user = new User();
            $user->setEmail($datas[0]);
            $user->setNom($datas[2]);
        
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $datas[1]
                )
            );

            $user->setRoles(['ROLE_USER']);
            

            $entityManager->persist($user);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_user_index');
    }
}
