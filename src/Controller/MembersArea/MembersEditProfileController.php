<?php

declare(strict_types=1);

namespace App\Controller\MembersArea;

use App\Form\Type\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MembersEditProfileController extends AbstractController
{
    public function __construct(private readonly Environment $twig, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/espace-membres/edit/profile', name: 'members_edit_profile')]
    public function __invoke(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return new Response($this->twig->render('members/edit_profile.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
