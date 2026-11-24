<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    /**
     * Defined Categories and Statuses per activity instructions.
     */
    public static array $categories = ['Paddles', 'Balls', 'Nets', 'Accessories'];
    public static array $statuses = ['Available', 'Unavailable'];

    /**
     * Display a listing of the equipment.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Equipment::with('user')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('equipment_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $equipments = $query->paginate(10)->withQueryString();

        return view('equipment.index', compact('equipments', 'search'));
    }

    /**
     * Show the form for creating a new equipment record.
     */
    public function create()
    {
        return view('equipment.create', [
            'categories' => self::$categories,
            'statuses' => self::$statuses,
        ]);
    }

    /**
     * Store a newly created equipment record in storage.
     */
    public function store(Request $request)
    {
        // 1. Server-side validation per requirements
        $validated = $request->validate([
            'equipment_name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(self::$categories)],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'availability_status' => ['required', Rule::in(self::$statuses)],
        ], [
            'equipment_name.required' => 'The equipment name is required.',
            'category.required' => 'Please select a valid category (Paddles, Balls, Nets, or Accessories).',
            'unit_price.required' => 'The unit price is required.',
            'unit_price.numeric' => 'The unit price must be a valid number.',
            'unit_price.min' => 'The unit price cannot be negative.',
            'description.required' => 'Please provide a detailed description.',
            'availability_status.required' => 'Please choose Available or Unavailable.',
        ]);

        // 2. Link record to the authenticated user on server-side
        $validated['user_id'] = Auth::id();

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment "' . $validated['equipment_name'] . '" was added successfully!');
    }

    /**
     * Display the specified equipment record.
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('user');
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified equipment record.
     */
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', [
            'equipment' => $equipment,
            'categories' => self::$categories,
            'statuses' => self::$statuses,
        ]);
    }

    /**
     * Update the specified equipment record in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'equipment_name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(self::$categories)],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'availability_status' => ['required', Rule::in(self::$statuses)],
        ], [
            'equipment_name.required' => 'The equipment name is required.',
            'category.required' => 'Please select a valid category.',
            'unit_price.required' => 'The unit price is required.',
            'unit_price.numeric' => 'The unit price must be numeric.',
            'unit_price.min' => 'The unit price cannot be negative.',
            'description.required' => 'The description is required.',
            'availability_status.required' => 'Availability status is required.',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment "' . $equipment->equipment_name . '" was updated successfully!');
    }

    /**
     * Remove the specified equipment record from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $name = $equipment->equipment_name;
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment "' . $name . '" has been deleted.');
    }
}