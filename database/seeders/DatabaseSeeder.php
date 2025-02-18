<?php

namespace Database\Seeders;

use App\Enums\AssigneeLocationTrackStatus;
use App\Enums\MlceAssignmentStatus;
use App\Enums\MlceIndentLocationStatus;
use App\Enums\UserRole;
use App\Models\AboutUs;
use App\Models\Acknowledgment;
use App\Models\AssigneeLocationTrack;
use App\Models\AssignmentObservation;
use App\Models\Customer;
use App\Models\MarineVas;
use App\Models\MlceAssignment;
use App\Models\MlceIndent;
use App\Models\MlceIndentLocation;
use App\Models\MlceRecommendation;
use App\Models\MlceReport;
use App\Models\MlceType;
use App\Models\NavigationReportManual;
use App\Models\User;
use App\Models\WhyMlce;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $customer = Customer::factory()->create([
            "name" => "Customer 1",
            "email" => "customer@admin.com",
        ]);

        collect(array_column(UserRole::cases(), "value"))->each(function ($role) use ($customer) {
            User::factory()->create([
                "created_by_id" => $role !== UserRole::ILGIC_MLCE_ADMIN->value ? 1 : null,
                "customer_id" =>
                    in_array($role, [UserRole::INSURED_ADMIN->value, UserRole::INSURED_REPRESENTATIVE->value])
                        ? $customer->id
                        : null,
                "name" => $role,
                "email" => $role === UserRole::ILGIC_MLCE_ADMIN->value
                    ? "admin@admin.com"
                    : implode("-", explode(" ", strtolower($role)))."@admin.com",
                "role" => $role,
            ]);
        });

        Acknowledgment::factory()->create([
            "title" => "Acknowledgment 1",
            "content" => "<h1>Acknowledgment 1 - Hello world </h1>",
        ]);

        AboutUs::factory()->create([
            "title" => "About Us 1",
            "content" => "<h1>About Us 1 - Hello world </h1>",
        ]);

        MarineVas::factory()->create([
            "title" => "Marine VAS 1",
            "content" => "<h1>Marine VAS 1 - Hello world </h1>",
        ]);

        NavigationReportManual::factory()->create([
            "title" => "Navigation Report Manual 1",
            "content" => "<h1>Navigation Report Manual 1 - Hello world </h1>",
        ]);

        WhyMlce::factory()->create([
            "title" => "Why MLCE 1",
            "content" => "<h1>Why MLCE 1 - Hello world </h1>",
        ]);

        $mlceTypes = [
            [
                "name" => "Value Addition",
                "description" => "Engagement to evaluate, assess & mitigate risk"
            ],
            [
                "name" => "Mitigating risk & losses",
                "description" => "Pre Loss - Managing SLR & loss frequency"
            ],
            [
                "name" => "Reducing loss occurrences",
                "description" => "Loss prevention - Considering Loss ratio & frequency factor",
            ],
            [
                "name" => "Post loss Activity",
                "description" => "Loss investigation & minimization"
            ],
        ];

        MlceType::factory()->createMany($mlceTypes);

        $mlceIndent = MlceIndent::factory()->create([
            "created_by_id" => 1,
            "mlce_type_id" => 3,
            "customer_id" => $customer->id,
        ]);

        $mlceIndent->users()->attach(4, ["type" => "RM"]);
        $mlceIndent->users()->attach(6, ["type" => "U/W"]);

        $indentLocation = MlceIndentLocation::factory()->create([
            "mlce_indent_id" => $mlceIndent->id,
            "location" => "Mumbai",
            "status" => MlceIndentLocationStatus::NOT_ASSIGNED->value,
        ]);

        $mlceAssignment = MlceAssignment::factory()->create([
            "mlce_indent_id" => $mlceIndent->id,
            "mlce_indent_location_id" => $indentLocation->id,
            "inspector_id" => 2,
            "supervisor_id" => 3,
        ]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::CMMI->value,
        ]);
        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::ROS_2C_MLCE->value,
        ]);

        AssignmentObservation::factory()->create(["mlce_assignment_id" => $mlceAssignment->id,]);
        AssignmentObservation::factory()->create(["mlce_assignment_id" => $mlceAssignment->id,]);

        MlceRecommendation::factory()->create(["mlce_assignment_id" => $mlceAssignment->id]);
        MlceRecommendation::factory()->create(["mlce_assignment_id" => $mlceAssignment->id]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::CMCD->value,
        ]);
        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::DMC->value,
        ]);

        $mlceAssignment->update([
            "status" => MlceAssignmentStatus::COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s")
        ]);

        $mlceReport = MlceReport::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            "mlce_indent_id" => $mlceIndent->id,
            "customer_id" => $mlceIndent->customer_id,
        ]);

        $mlceReport->views()->createMany([["user_id" => 7], ["user_id" => 8]]);

        $mlceReport->increment("view_count", 2);
    }
}
