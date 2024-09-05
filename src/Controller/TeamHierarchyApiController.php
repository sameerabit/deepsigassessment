<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TeamHierarchyApiController extends AbstractController
{
    #[Route('api/team-hierarchy', name: 'app_team_hierarchy_api')]
    public function index(): JsonResponse
    {
        return $this->json([]);
    }
}
