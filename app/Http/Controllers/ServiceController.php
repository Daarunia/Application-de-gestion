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
        'Notification de transit' => ['DOU002' => 1, 'DOU003' => null],
        'Impression de documents' => ['DOU014' => 10, 'DOU015' => 20, 'DOU016' => null],
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

    /**
     * API function that returns the price, for each service.
     */
    public function getPrice($name, $quantity)
    {
        // decoded name
        $name = str_replace('|', '/', $name);
        // Check if the name is present in the mapper for exceptional cases.
        if (array_key_exists($name, $this->serviceMapping)) {
            $total = 0;
            $remainingUnits = $quantity;
            $totalValue = 0;

            foreach($this->serviceMapping[$name] as $key => $value){
                $service = Service::where('reference', $key)->first();

                if($quantity <= $value || $value === null){
                    $total += $remainingUnits * $service->price;
                    return response()->json(['price' => $total]);
                } else {
                    $total += ($value - $totalValue) * $service->price;
                    error_log('total :'.$total.'  value : '.$value.'  price :'.$service->price);
                    $remainingUnits = $quantity - $value;
                }
                $totalValue += $value;
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

    /**
     * Return the unique name of all services.
     */
    public function getNomServices()
    {
        $services = Service::all();

        // Use the mapping: if the current reference exists in the mapping, replace it with the corresponding nickname.
        foreach ($services as $service) {
            $reference = $service['reference'];
            foreach ($this->serviceMapping as $name => $references) {
                if (array_key_exists($reference, $references)) {
                    $service['name'] = $name;
                    break;
                }
            }
        }

        //To distinct services and avoid duplicates.
        return $services->pluck('name')->unique();
    }

    /**
     * Return the id of each service with the quantity
     */
    public function getServicesId($categories)
    {

    }
}
