<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\admin;

use App\Entity\Environnement;
use App\Repository\EnvironnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminEnvironnementController
 *
 * @author intad
 */
class AdminEnvironnementController extends AbstractController {

    /**
     * 
     * @var EnvironnementRepository
     */
    private $repository;

    /**
     * 
     * @param EnvironnementRepository $repository
     */
    public function __construct(EnvironnementRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/environnements", name="admin.environnements")
     * @return Response
     */
    public function index(): Response {
        $environnements = $this->repository->findAll();
        return $this->render("admin/admin.environnements.html.twig", [
                    'environnements' => $environnements
        ]);
    }

    /**
     * @Route("/admin/environnment/suppr/{id}", name="admin.environnement.suppr")
     * @param int $id
     * @return Response
     */
    public function suppr(int $id): Response {
        $environnement = $this->repository->find($id);
        if ($environnement) {
            $this->repository->remove($environnement, true);
        }
        return $this->redirectToRoute('admin.environnements');
    }

    /**
     * @Route("/admin/environnement/ajout", name="admin.environnement.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $nomEnvironnement = $request->get("nom");
        $environnement = new Environnement();
        $environnement->setNom($nomEnvironnement);
        $this->repository->add($environnement, true);
        return $this->redirectToRoute('admin.environnements');
    }

}
