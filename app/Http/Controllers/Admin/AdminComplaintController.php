<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AdminComplaintController extends Controller
{
    /**
     * Display a listing of complaints.
     */
    public function index(Request $request)
    {
        $query = Complaint::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $complaints = $query->orderBy('status', 'asc') // Pending first (alphabetically 'pending' comes after 'in_progress', maybe specify order logic properly later)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'resolver']);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Resolve the complaint and send response.
     */
    public function resolve(Request $request, Complaint $complaint)
    {
        $request->validate([
            'staff_response' => 'required|string',
            'status' => 'required|in:in_progress,resolved',
        ]);

        $complaint->update([
            'staff_response' => $request->staff_response,
            'status' => $request->status,
            'resolved_by' => Auth::id(),
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        // Log activity
        ActivityLog::log('complaint_resolved', "Updated complaint status to {$request->status}: #{$complaint->id}", $complaint);

        // Notify User
        try {
            $complaint->user->notify(new \App\Notifications\ComplaintResolved($complaint));
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Complaint updated successfully.');
    }
}
