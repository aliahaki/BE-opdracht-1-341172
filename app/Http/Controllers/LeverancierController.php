<?php

namespace App\Http\Controllers;

use App\Repositories\LeverancierRepository;
use Illuminate\Http\Request;

class LeverancierController extends Controller
{
    private LeverancierRepository $leverancierRepository;

    public function __construct(
        LeverancierRepository $leverancierRepository
    ) {
        $this->leverancierRepository = $leverancierRepository;
    }

    // ============================================================
    // USER STORY 1
    // Overzicht leveranciers
    // ============================================================

    public function index()
    {
        $leveranciers = $this->leverancierRepository
            ->getLeveranciers();

        return view(
            'leveranciers.index',
            compact('leveranciers')
        );
    }

    // ============================================================
    // USER STORY 1
    // Geleverde producten van een leverancier
    // ============================================================

    public function producten(int $id)
    {
        $leverancier = $this->leverancierRepository
            ->getLeverancier($id);

        if ($leverancier === null) {
            abort(404);
        }

        $producten = $this->leverancierRepository
            ->getGeleverdeProducten($id);

        $geenProducten = empty($producten);

        $response = response()->view(
            'leveranciers.producten',
            compact(
                'leverancier',
                'producten',
                'geenProducten'
            )
        );

        // Scenario 02:
        // Na 3 seconden terug naar Overzicht Leveranciers
        if ($geenProducten) {
            $response->header(
                'Refresh',
                '3;url=' . route('leveranciers.index')
            );
        }

        return $response;
    }

    // ============================================================
    // USER STORY 2
    // Scherm Levering product tonen
    // ============================================================

    public function levering(
        int $leverancierId,
        int $productId
    ) {
        $levering = $this->leverancierRepository
            ->getProductLeveringDetails(
                $leverancierId,
                $productId
            );

        if ($levering === null) {
            abort(404);
        }

        $melding = null;

        return view(
            'leveranciers.levering',
            compact(
                'levering',
                'melding'
            )
        );
    }

    // ============================================================
    // USER STORY 2
    // Nieuwe levering opslaan
    // ============================================================

    public function leveringOpslaan(
        Request $request,
        int $leverancierId,
        int $productId
    ) {
        // Server-side validatie
        $request->validate(
            [
                'aantal' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'datum_eerstvolgende_levering' => [
                    'required',
                    'date',
                ],
            ],
            [
                'aantal.required' =>
                'Vul het aantal producteenheden in.',

                'aantal.integer' =>
                'Het aantal producteenheden moet een heel getal zijn.',

                'aantal.min' =>
                'Het aantal producteenheden moet minimaal 1 zijn.',

                'datum_eerstvolgende_levering.required' =>
                'Vul de datum van de eerstvolgende levering in.',

                'datum_eerstvolgende_levering.date' =>
                'Vul een geldige datum in.',
            ]
        );

        $resultaat = $this->leverancierRepository
            ->voegNieuweLeveringToe(
                $leverancierId,
                $productId,
                (int) $request->input('aantal'),
                $request->input(
                    'datum_eerstvolgende_levering'
                )
            );

        // ========================================================
        // HAPPY SCENARIO
        // Levering is succesvol toegevoegd
        // ========================================================

        if ((int) $resultaat->Succes === 1) {
            return redirect()
                ->route(
                    'leveranciers.producten',
                    $leverancierId
                );
        }

        // ========================================================
        // UNHAPPY SCENARIO
        // Product wordt niet meer geproduceerd
        // ========================================================

        $levering = $this->leverancierRepository
            ->getProductLeveringDetails(
                $leverancierId,
                $productId
            );

        if ($levering === null) {
            abort(404);
        }

        $melding = $resultaat->Melding;

        $response = response()->view(
            'leveranciers.levering',
            compact(
                'levering',
                'melding'
            )
        );

        // Na 4 seconden terug naar Geleverde producten
        $response->header(
            'Refresh',
            '4;url=' . route(
                'leveranciers.producten',
                $leverancierId
            )
        );

        return $response;
    }
}
