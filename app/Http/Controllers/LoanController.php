<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index()
    {
        $loans = LoanRequest::with('equipment')->latest()->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function create(Request $request)
    {
        $equipments = Equipment::where('status', 'tersedia')->orderBy('name')->get();
        $selected = $request->query('equipment_id');

        return view('loans.create', compact('equipments', 'selected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'borrower_name' => 'required|min:3|max:100',
            'borrower_nim' => 'required|size:8',
            'borrower_email' => 'required|email|max:100',
            'loan_date' => 'required|date|after_or_equal:today',
            'expected_return_date' => 'required|date|after_or_equal:loan_date',
            'purpose' => 'nullable|string',
        ]);

        $loanDate = Carbon::parse($validated['loan_date']);
        $returnDate = Carbon::parse($validated['expected_return_date']);

        $days = $loanDate->diffInDays($returnDate) + 1;
        if ($days > 7) {
            throw ValidationException::withMessages([
                'expected_return_date' => 'Durasi peminjaman maksimal 7 hari kalender.',
            ]);
        }

        DB::transaction(function () use ($validated, $days) {
            $equipment = Equipment::lockForUpdate()->findOrFail($validated['equipment_id']);

            if ($equipment->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'equipment_id' => "Perangkat tidak dapat dipinjam karena berstatus '{$equipment->status}'.",
                ]);
            }

            LoanRequest::create([
                'equipment_id' => $equipment->id,
                'borrower_name' => $validated['borrower_name'],
                'borrower_nim' => $validated['borrower_nim'],
                'borrower_email' => $validated['borrower_email'],
                'loan_date' => $validated['loan_date'],
                'expected_return_date' => $validated['expected_return_date'],
                'purpose' => $validated['purpose'] ?? null,
                'status' => 'diajukan',
                'total_estimated_fee' => $days * $equipment->daily_rental_fee,
            ]);

            $equipment->update(['status' => 'dipinjam']);
        });

        return redirect()->route('equipments.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}