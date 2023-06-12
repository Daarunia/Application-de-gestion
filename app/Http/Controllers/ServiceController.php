<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
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

        Service::create($request->validate([
            'name' => ['required', 'max:50'],
            'reference' => ['required', 'max:50'],
            'price' => ['required', 'max:50'],
        ]));

        return redirect()->route('services');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'reference' => ['required', 'max:50'],
            'price' => ['required', 'max:50'],
        ]);

        $service = Service::findOrFail($id);
        $service->name = $request->input('name');
        $service->reference = $request->input('reference');
        $service->price = $request->input('price');
        $service->save();

        return redirect()->route('services');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services');
    }
}
