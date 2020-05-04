<?php

namespace App\FlightTicket;

/**
 *
 */
class LocationsRepository
{
    public function getAll(string $fileName) : array
    {
        $edges = $this->loadFromCsv($fileName);

        return $this->buildLocationsGraph($edges);
    }

    public function loadFromCsv(string $fileName) : array
    {
        $filePath = storage_path('app/' . $fileName);

        return file($filePath);
    }

    // Mounts the graph from the csv data
    private function buildLocationsGraph(array $edges) : array
    {
        $locations = [];

        foreach ($edges as $i => $data) {
            list($originCode, $destinationCode, $cost) = explode(',', $data);

            if (!isset($locations[$originCode])) {
                $locations[$originCode] = new Location($originCode);
            }
            if (!isset($locations[$destinationCode])) {
                $locations[$destinationCode] = new Location($destinationCode);
            }

            $locations[$originCode]->addDestination(
                new Destination($locations[$destinationCode], (float) $cost)
            );
        }

        return $locations;
    }
}
