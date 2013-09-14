<?php namespace CostingResource\Cutting;

interface DataInterface {

	public function getMaterials();

    public function getMachines();

    public function getCountries();

    public function getMaterial($id);
    
    public function getMachine($id);

    public function getCountry($id);

    public function getLastCuttingSpeedEntryForMaterial($materialId);

    public function getStartHoleByMaterialAndThickness($materialId, $thickness);

    public function getCuttingSpeedByMaterialAndThickness($materialId, $thickness);

    public function getManipulationSpeed();

    public function getManipulationStartEndDistance();

    public function getAverageDistanceBetweenFeatures();
}