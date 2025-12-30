<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the user's complaints.
     */
    public function index()
    {
        $complaints = Auth::user()->complaints()->orderBy('created_at', 'desc')->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $complaint = Auth::user()->complaints()->create([
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // Log activity
        ActivityLog::log('complaint_submitted', "Submitted complaint: {$complaint->subject}", $complaint);

        // Notify Admins
        try {
            $admins = \App\Models\User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'manager', 'staff']);
            })->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\ComplaintSubmitted($complaint));
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint submitted successfully. We will get back to you soon.');
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        // Ensure user owns the complaint
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }

        return view('complaints.show', compact('complaint'));
    }
}
