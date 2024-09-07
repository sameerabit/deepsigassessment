<?php

namespace App\Entity;

class Team
{
    private array $teams = [];

    public function __construct(
        private string $teamName,
        private string $parentTeam,
        private string $managerName,
        private string $businessUnit,
    ) {
    }

    public function addTeam($team)
    {
        $this->teams[] = $team;
    }

    public function getTeams()
    {
        $this->teams;
    }

    public function getTeamName()
    {
        return $this->teamName;
    }

    public function getParentTeam()
    {
        return $this->parentTeam;
    }

    public function getManagerName()
    {
        return $this->managerName;
    }

    public function getBusinessUnit()
    {
        return $this->businessUnit;
    }

    public function setTeamName(string $teamName)
    {
        $this->teamName = $teamName;
    }

    public function setParentTeam(string $parentTeam)
    {
        $this->parentTeam = $parentTeam;
    }

    public function setManagerName(string $managerName)
    {
        $this->managerName = $managerName;
    }

    public function setBusinessUnit(string $businessUnit)
    {
        $this->businessUnit = $businessUnit;
    }
}
