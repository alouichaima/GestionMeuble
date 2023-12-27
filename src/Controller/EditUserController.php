<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditUserController extends AbstractController
{
    #[Route('/editUser/{id}', name: 'app_edit_user')]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        // Check if the user is not logged in
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        // Create the form
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save changes to the database
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash
            ('success', 'Your information has been updated successfully.');

            // Redirect to a different page, e.g., user profile
            return $this->redirectToRoute('app_user_profil');
        }

        // Render the template with the form
        return $this->render('edit_user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
