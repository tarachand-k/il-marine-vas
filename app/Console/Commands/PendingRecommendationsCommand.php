<?php

namespace App\Console\Commands;

use App\Mail\PendingRecommendationsMail;
use App\Models\MlceIndent;
use App\Models\MlceRecommendation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PendingRecommendationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:send-pending-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email alerts for pending MLCE recommendations';

    /**
     * Execute the console command.
     */
    public function handle(): int {
        Log::info('Starting to process pending recommendations...');

        // Get all pending recommendations
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

        $processedCount = 0;

        foreach ($recommendationsByIndent as $indentId => $recommendations) {
            // Get the indent and related users
            $indent = MlceIndent::findOrFail($indentId);
            $users = $indent->allowedUsers;

            // If no users are associated, continue to next indent
            if ($users->isEmpty()) {
                Log::warning("No users associated with indent {$indent->ref_no}");
                continue;
            }

            // Group recommendations by location for better email formatting
            $recommendationsByLocation = $recommendations->groupBy('mlceAssignment.mlce_indent_location_id');

            // Prepare data for email
            $emailData = [
                'indent' => $indent,
                'customer' => $indent->customer,
                'recommendationsByLocation' => $recommendationsByLocation,
            ];

            // Send email to each user
            foreach ($users as $user) {
                Mail::to($user->email)->send(new PendingRecommendationsMail($emailData, $user));
                Log::info("Sent pending recommendations email to {$user->email} for indent {$indent->ref_no}");
                $processedCount++;
            }
        }

        Log::info("Completed processing. Sent {$processedCount} emails.");
        return 0;
    }
}
