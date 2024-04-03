<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class AuthenticationController
 * @package App\Controller
 */
class AuthenticationController extends AbstractController
{
    /**
     * Register a new user.
     *
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordEncoder->encodePassword($user, $data['password']));
        // You might want to handle roles differently, perhaps setting a default role here
        $user->setRoles(['ROLE_USER']);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Authenticate a user.
     *
     * @Route("/login", name="login", methods={"POST"})
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     */
    #[Route('/login', name: "login", methods:['post'] )]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $user = $userRepository->findOneBy(['email' => $data['email']]);
    
        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json(['message' => 'Invalid credentials'], 401);
        }
    
        // Generate JWT token
        $token = $JWTManager->create($user);
    
        return $this->json(['token' => $token]);
    }
}