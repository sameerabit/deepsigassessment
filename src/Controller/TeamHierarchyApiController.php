<?php

namespace App\Controller;

use App\Service\HierachyDataService;
use App\TeamCollection\TeamCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TeamHierarchyApiController extends AbstractController
{
    private $hierachyDataService;

    public function __construct(HierachyDataService $hierachyDataService)
    {
        $this->hierachyDataService = $hierachyDataService;
    }

    #[Route('api/team-hierarchy', name: 'app_team_hierarchy_api')]
    public function index(Request $request): JsonResponse
    {
        $hierachyData = $this->hierachyDataService->getData('hierachy.csv');
        try {
            $teamCollection = new TeamCollection($hierachyData); // hydrating the array into object collection
            $filterTeam     = $request->query->get('_q');
            return $this->json(['data' => $teamCollection->buildHierarchy($filterTeam)]);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
