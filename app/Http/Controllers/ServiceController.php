<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    // The price changes with the quantity, you need to check the controllers to modify the quantity calculation.
    // don't change the reference order for quantity calculation.
    public $serviceMapping = [
        'Notification de transit' => ['DOU002', 'DOU003'],
        'Impression de documents' => ['DOU014', 'DOU015', 'DOU016'],
    ];

    private $transitTiers = [
        1,
    ];

    private $printingTiers = [
        10,
        20
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Inertia::render('Service', [
            'services' => Service::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'reference' => [
                'required',
                Rule::unique('services')->ignore($request->id),
            ],
            'price' => 'required',
        ]);

        Service::create($validatedData);

        return Inertia::render('Service', [
            'services' => Service::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:50'],
            'reference' => ['required', 'max:50'],
            'price' => ['required', 'max:50'],
        ]);

        $service = Service::findOrFail($id);
        $service->fill($validatedData);
        $service->save();

        return Inertia::render('Service', [
            'services' => Service::all(),
        ]);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return Inertia::render('Service', [
            'services' => Service::all(),
        ]);
    }

    //API function that returns the price, for each service.
    public function getPrice($name, $quantity)
    {
        // decoded name
        $name = str_replace('|', '/', $name);
        // Check if the name is present in the mapper for exceptional cases.
        if (array_key_exists($name, $this->serviceMapping)) {
            if ($name === 'Notification de transit') {
                $firstTransitPrice = Service::where('reference', $this->serviceMapping[$name][0])->first()->price;
                $unitTransitPrice = Service::where('reference', $this->serviceMapping[$name][1])->first()->price;

                if ($quantity <= $this->transitTiers[0]) {
                    return response()->json(['price' => (int) $firstTransitPrice * $quantity]);
                } else {
                    return response()->json(['price' => (int) $firstTransitPrice + $unitTransitPrice * ($quantity - $this->transitTiers[0])]);
                }
            } elseif ($name === 'Impression de documents') {
                $firstPrintingPrice = Service::where('reference', $this->serviceMapping[$name][0])->first()->price;
                $secondPrintingPrice = Service::where('reference', $this->serviceMapping[$name][1])->first()->price;
                $unitPrintingPrice = Service::where('reference', $this->serviceMapping[$name][2])->first()->price;

                if ($quantity <= $this->printingTiers[0]) {
                    return response()->json(['price' => (int) $firstPrintingPrice * $quantity]);
                } elseif($quantity >= 11 && $quantity <= $this->printingTiers[1]){
                    return response()->json(['price' => (int) $firstPrintingPrice * $this->printingTiers[0] + $secondPrintingPrice * ($quantity - $this->printingTiers[0])]);
                } else {
                    return response()->json(['price' => (int) $firstPrintingPrice * $this->printingTiers[0] + $secondPrintingPrice * $this->printingTiers[0] + $unitPrintingPrice * ($quantity - $this->printingTiers[1])]);
                }
            }
        } else {
            $service = Service::where('name', $name)->first();
            if ($service) {
                return response()->json(['price' => (int) $service->price * $quantity]);
            } else {
                return response()->json(['error' => 'Service not found'], 404);
            }
        }
        return response()->json(['error' => 'Invalid service'], 400);
    }
}
