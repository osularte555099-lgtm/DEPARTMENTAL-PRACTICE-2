<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the Equipment Reports page with combined filters.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $status = $request->query('availability_status');

        $query = Equipment::with('user');

        // Apply Category Filter if provided
        if (!empty($category)) {
            $query->where('category', $category);
        }

        // Apply Availability Status Filter if provided
        if (!empty($status)) {
            $query->where('availability_status', $status);
        }

        $equipments = $query->orderBy('equipment_name', 'asc')->get();

        // Calculate summary metrics for reports
        $totalRecords = $equipments->count();
        $totalValue = $equipments->sum('unit_price');
        $availableCount = $equipments->where('availability_status', 'Available')->count();
        $unavailableCount = $equipments->where('availability_status', 'Unavailable')->count();

        $categories = ['Paddles', 'Balls', 'Nets', 'Accessories'];
        $statuses = ['Available', 'Unavailable'];

        return view('reports.index', compact(
            'equipments',
            'category',
            'status',
            'categories',
            'statuses',
            'totalRecords',
            'totalValue',
            'availableCount',
            'unavailableCount'
        ));
    }

    /**
     * Export Filtered Equipment to CSV / Excel format.
     */
    public function exportExcel(Request $request)
    {
        $category = $request->query('category');
        $status = $request->query('availability_status');

        $query = Equipment::with('user');

        if (!empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($status)) {
            $query->where('availability_status', $status);
        }

        $equipments = $query->orderBy('equipment_name', 'asc')->get();

        $filename = 'Pickleball_Equipment_Report_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($equipments) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM so Excel opens special characters cleanly
            fputs($file, "\xEF\xBB\xBF");

            // CSV Columns Header
            fputcsv($file, [
                'ID',
                'Equipment Name',
                'Category',
                'Unit Price ($)',
                'Availability Status',
                'Description',
                'Recorded By',
                'Created At',
            ]);

            foreach ($equipments as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->equipment_name,
                    $item->category,
                    number_format($item->unit_price, 2, '.', ''),
                    $item->availability_status,
                    $item->description,
                    $item->user->name ?? 'System Admin',
                    $item->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Filtered Equipment to a formatted PDF-ready Printable Document.
     */
    public function exportPdf(Request $request)
    {
        $category = $request->query('category');
        $status = $request->query('availability_status');

        $query = Equipment::with('user');

        if (!empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($status)) {
            $query->where('availability_status', $status);
        }

        $equipments = $query->orderBy('equipment_name', 'asc')->get();
        $generatedAt = now()->format('F d, Y h:i A');

        return view('reports.pdf', compact('equipments', 'category', 'status', 'generatedAt'));
    }
}