<?php

use App\Models\MlceIndent;
use App\Models\MlceRecommendation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/pending-recommendations", function () {
    $pendingRecommendations = MlceRecommendation::where('status', 'Pending')
        ->with([
            'mlceAssignment',
            'mlceAssignment.mlceIndentLocation',
            'mlceAssignment.mlceIndent',
            'mlceAssignment.mlceIndent.customer',
        ])
        ->get();

    // Group recommendations by indent ID
    $recommendationsByIndent = $pendingRecommendations->groupBy('mlceAssignment.mlce_indent_id');

    $indentId = 1;
    $recommendations = $recommendationsByIndent[1];
    $indent = MlceIndent::findOrFail($indentId);
    $users = $indent->allowedUsers;

    // If no users are associated, continue to next indent
    if ($users->isEmpty()) {
        $this->warn("No users associated with indent {$indent->ref_no}");
        return null;
    }

    // Group recommendations by location for better email formatting
    $recommendationsByLocation = $recommendations->groupBy('mlceAssignment.mlce_indent_location_id');

    // Prepare data for email
    $emailData = [
        'indent' => $indent,
        'customer' => $indent->customer,
        'recommendationsByLocation' => $recommendationsByLocation,
    ];

    return view("emails.pending-recommendations", ["user" => $users->first(), "data" => $emailData]);
});
