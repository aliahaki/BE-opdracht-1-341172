<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MagazijnController extends Controller
{
    // Scenario 01: Magazijn overzicht gesorteerd op Barcode (oplopend)
    public function index()
    {
        $producten = DB::table('Magazijn')
            ->join('Product', 'Magazijn.ProductId', '=', 'Product.Id')
            ->select(
                'Product.Id as ProductId',
                'Product.Naam',
                'Product.Barcode',
                'Magazijn.VerpakkingsEenheid',
                'Magazijn.AantalAanwezig'
            )
            ->orderBy('Product.Barcode', 'asc')
            ->get();

        return view('magazijn.index', compact('producten'));
    }

    // Scenario 01 & 02: Leveringsinformatie
    public function levering($id)
    {
        $product = DB::table('Product')->where('Id', $id)->first();

        // Check aantal aanwezig in magazijn
        $magazijnInfo = DB::table('Magazijn')->where('ProductId', $id)->first();

        // Haal de leverancier op die aan het product gekoppeld is
        $leverancier = DB::table('ProductPerLeverancier')
            ->join('Leverancier', 'ProductPerLeverancier.LeverancierId', '=', 'Leverancier.Id')
            ->where('ProductPerLeverancier.ProductId', $id)
            ->select(
                'Leverancier.Naam',
                'Leverancier.ContactPersoon',
                'Leverancier.LeverancierNummer',
                'Leverancier.Mobiel'
            )
            ->first();

        // Haal de leveringsgegevens op gesorteerd op DatumLevering (oplopend)
        $leveringsInfo = DB::table('ProductPerLeverancier')
            ->join('Leverancier', 'ProductPerLeverancier.LeverancierId', '=', 'Leverancier.Id')
            ->where('ProductPerLeverancier.ProductId', $id)
            ->select(
                'Leverancier.Naam as LeverancierNaam',
                'Leverancier.ContactPersoon',
                'Leverancier.LeverancierNummer',
                'Leverancier.Mobiel',
                'ProductPerLeverancier.DatumLevering',
                'ProductPerLeverancier.Aantal',
                'ProductPerLeverancier.DatumEerstVolgendeLevering'
            )
            ->orderBy('ProductPerLeverancier.DatumLevering', 'asc')
            ->get();

        // Scenario 02 controle: AantalAanwezig is NULL of 0
        $geenVoorraad = is_null($magazijnInfo?->AantalAanwezig) || $magazijnInfo?->AantalAanwezig == 0;

        // Als er geen voorraad is, stel een PHP refresh header in voor 4 seconden redirect
        if ($geenVoorraad) {
            header("refresh:4;url=" . route('magazijn.index'));
        }

        return view('magazijn.levering', compact('product', 'leverancier', 'leveringsInfo', 'geenVoorraad'));
    }

    // Scenario 01 & 02 van User Story 02: Allergeneninformatie
    public function allergenen($id)
    {
        // Haal product op
        $product = DB::table('Product')->where('Id', $id)->first();

        // Haal allergenen op gesorteerd op Allergeen.Naam (oplopend)
        $allergenen = DB::table('ProductPerAllergeen')
            ->join('Allergeen', 'ProductPerAllergeen.AllergeenId', '=', 'Allergeen.Id')
            ->where('ProductPerAllergeen.ProductId', $id)
            ->select('Allergeen.Naam', 'Allergeen.Omschrijving')
            ->orderBy('Allergeen.Naam', 'asc')
            ->get();

        // Check of er allergenen zijn
        $geenAllergenen = $allergenen->isEmpty();

        // Als er geen allergenen zijn, stel een PHP refresh header in voor 4 seconden redirect
        if ($geenAllergenen) {
            header("refresh:4;url=" . route('magazijn.index'));
        }

        return view('magazijn.allergenen', compact('product', 'allergenen', 'geenAllergenen'));
    }
}
