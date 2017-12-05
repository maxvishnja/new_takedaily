<?php

namespace App;

use App\Apricot\Repositories\StockRepository;

class TakeDaily
{
    /**
     * @var StockRepository
     */
    private $repo;

    public function __construct(StockRepository $repo)
    {
        $this->repo = $repo;
    }

    public function createBox($orderPlan)
    {
        return $orderPlan;
        $stockVitamins = $this->repo->getAllByType('vitamin');
    }
}
