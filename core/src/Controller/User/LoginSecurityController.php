<?php

namespace App\Controller\User;

use App\Entity\User\AppUser;
use App\Repository\UserRepository;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginSecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/password', name: 'app_password')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof AppUser) {
            return new Response('HTTP UNAUTHORIZED', Response::HTTP_UNAUTHORIZED);
        }

        $error = null;
        if ($request->isMethod(Request::METHOD_POST)) {
            $payload = $request->getPayload();
            $token = $payload->getString('token');

            if (!$this->isCsrfTokenValid('change-password', $token)) {
                $error = 'Csrf token invalide.';
            } else {
                $error = $this->changePassword($passwordHasher, $userRepository, $user, $payload);
                //si pas d'erreur
                if ($error === null) {
                    return $this->redirectToRoute('admin_dashboard');
                }
            }
        }

        return $this->render('login/change.html.twig', [
            'error' => $error,
        ]);
    }

    /**
     * Permet de changer le mdp d'un utilisateur en fonction de sa saisie
     * @param UserPasswordHasherInterface $passwordHasher
     * @param UserRepository $userRepository
     * @param AppUser $user
     * @param InputBag $payload
     * @return string|null message d'erreur si il y en a une sinon ça c'est bien passé
     */
    private function changePassword(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, AppUser $user, InputBag $payload): string | null
    {
        //init
        $oldpass = $payload->getString('oldpass', '');
        $newpass1 = $payload->getString('newpass1', '');
        $newpass2 = $payload->getString('newpass2', '');

        //test des champs
        if (empty($oldpass) || empty($newpass1) || empty($newpass2)) {
            return 'Champs manquants !';
        }

        //test si new mdp identique
        if ($newpass1 !== $newpass2) {
            return 'Les mots de passes saisies sont différents !';
        }

        //test de l'ancien mdp
        if (!$passwordHasher->isPasswordValid($user, $oldpass)) {
            return 'Mot de passe invalid !';
        }

        //save du nouveau mdp
        $hashedPassword = $passwordHasher->hashPassword($user, $newpass1);
        $userRepository->upgradePassword($user, $hashedPassword);
        return null;
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
