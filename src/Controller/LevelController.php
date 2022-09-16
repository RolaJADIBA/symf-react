<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class LevelController extends AbstractController
{
    /**
     * @Route("/level", name="app_level_index", methods={"GET"})
     */
    public function index(LevelRepository $levelRepository): Response
    {
        return $this->render('admin/level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/level/new", name="app_level_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LevelRepository $levelRepository): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->add($level, true);

            return $this->redirectToRoute('app_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/level/new.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/level/{id}", name="app_level_show", methods={"GET"})
     */
    public function show(Level $level): Response
    {
        return $this->render('admin/level/show.html.twig', [
            'level' => $level,
        ]);
    }

    /**
     * @Route("/level/{id}/edit", name="app_level_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->add($level, true);

            return $this->redirectToRoute('app_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/level/edit.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/level/{id}", name="app_level_delete", methods={"POST"})
     */
    public function delete(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$level->getId(), $request->request->get('_token'))) {
            $levelRepository->remove($level, true);
        }

        return $this->redirectToRoute('app_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
