<?php

namespace App\Controller;

use App\Entity\Auth;
use App\Form\AuthType;
use App\Repository\AuthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route('/', name: 'app_auth_index', methods: ['GET'])]
    public function index(AuthRepository $authRepository): Response
    {
        return $this->render('auth/index.html.twig', [
            'auths' => $authRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_auth_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AuthRepository $authRepository): Response
    {
        $auth = new Auth();
        $form = $this->createForm(AuthType::class, $auth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authRepository->add($auth, true);

            return $this->redirectToRoute('app_auth_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/new.html.twig', [
            'auth' => $auth,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_auth_show', methods: ['GET'])]
    public function show(Auth $auth): Response
    {
        return $this->render('auth/show.html.twig', [
            'auth' => $auth,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_auth_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Auth $auth, AuthRepository $authRepository): Response
    {
        $form = $this->createForm(AuthType::class, $auth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authRepository->add($auth, true);

            return $this->redirectToRoute('app_auth_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/edit.html.twig', [
            'auth' => $auth,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_auth_delete', methods: ['POST'])]
    public function delete(Request $request, Auth $auth, AuthRepository $authRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auth->getId(), $request->request->get('_token'))) {
            $authRepository->remove($auth, true);
        }

        return $this->redirectToRoute('app_auth_index', [], Response::HTTP_SEE_OTHER);
    }
}
