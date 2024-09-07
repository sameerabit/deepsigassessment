<?php

namespace App\TeamCollection;

use App\Entity\Team;

class TeamCollection
{
    private $teams = [];

    public function __construct(array $hierachyData)
    {
        $this->teams = array_map(fn($raw) => new Team($raw['team'], $raw['parentTeam'], $raw['managerName'], $raw['businessUnit']), $hierachyData);
    }

    public function buildHierarchy(?string $filterTeam = null): array
    {
        $hierarchy = [];
        $teamIndex = [];

        foreach ($this->teams as $team) {
            $teamIndex[$team->getTeamName()] = [
                'teamName'     => $team->getTeamName(),
                'parentTeam'   => $team->getParentTeam(),
                'managerName'  => $team->getManagerName(),
                'businessUnit' => $team->getBusinessUnit(),
                'teams'        => [],
            ];
        }

        try {
            foreach ($teamIndex as $teamName => &$team) {
                if ('' === $team['parentTeam']) {
                    $hierarchy[$teamName] = &$team;
                } else {
                    $teamIndex[$team['parentTeam']]['teams'][$teamName] = &$team;
                }
            }
        } catch (\Exception $ex) {
            throw new \Exception('malicious csv format.');
        }

        if ($filterTeam) {
            $hierarchy = $this->filterHierarchy($hierarchy, $filterTeam);
        }

        return $hierarchy;
    }

    private function filterHierarchy(array $hierarchy, string $filterTeam): array
    {
        foreach ($hierarchy as $teamName => &$team) {
            if ($teamName === $filterTeam) {
                return [$teamName => $team];
            }

            if (!empty($team['teams'])) {
                $filteredSubteams = $this->filterHierarchy($team['teams'], $filterTeam); // traverse through nested elements
                if (!empty($filteredSubteams)) {
                    return [$teamName => array_merge($team, ['teams' => $filteredSubteams])];
                }
            }
        }

        return [];
    }
}
