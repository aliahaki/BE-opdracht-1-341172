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

        // Haal de leverancier- en leveringsgegevens op gesorteerd op DatumLevering (oplopend)
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
        $geenVoorraad = is_null($magazijnInfo->AantalAanwezig) || $magazijnInfo->AantalAanwezig == 0;

        return view('magazijn.levering', compact('product', 'leveringsInfo', 'geenVoorraad'));
    }
}