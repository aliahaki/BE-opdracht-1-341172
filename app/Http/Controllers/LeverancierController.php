<?php

namespace App\Http\Controllers;

use App\Repositories\LeverancierRepository;

class LeverancierController extends Controller
{
    private LeverancierRepository $leverancierRepository;

    public function __construct(LeverancierRepository $leverancierRepository)
    {
        $this->leverancierRepository = $leverancierRepository;
    }

    // User Story 1 - Scenario 01
    public function index()
    {
        $leveranciers = $this->leverancierRepository->getLeveranciers();

        return view('leveranciers.index', compact('leveranciers'));
    }

    // User Story 1 - Scenario 01 en 02
    public function producten(int $id)
    {
        $leverancier = $this->leverancierRepository->getLeverancier($id);

        if ($leverancier === null) {
            abort(404);
        }

        $producten = $this->leverancierRepository->getGeleverdeProducten($id);

        $geenProducten = empty($producten);

        $response = response()->view(
            'leveranciers.producten',
            compact('leverancier', 'producten', 'geenProducten')
        );

        if ($geenProducten) {
            $response->header(
                'Refresh',
                '3;url=' . route('leveranciers.index')
            );
        }

        return $response;
    }
}
