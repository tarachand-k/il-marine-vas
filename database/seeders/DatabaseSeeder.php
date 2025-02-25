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
        $customer1 = Customer::factory()->create([
            "name" => "Customer 1",
            "email" => "customer1@admin.com",
        ]);

        $customer2 = Customer::factory()->create([
            "name" => "Customer 2",
            "email" => "customer2@admin.com",
        ]);

        collect(array_column(UserRole::cases(), "value"))->each(function ($role) use ($customer1) {
            User::factory()->create([
                "created_by_id" => $role !== UserRole::ILGIC_MLCE_ADMIN->value ? 1 : null,
                "customer_id" =>
                    in_array($role, [UserRole::INSURED_ADMIN->value, UserRole::INSURED_REPRESENTATIVE->value])
                        ? $customer1->id
                        : null,
                "name" => $role,
                "email" => $role === UserRole::ILGIC_MLCE_ADMIN->value
                    ? "admin@admin.com"
                    : implode("-", explode(" ", strtolower($role)))."@admin.com",
                "role" => $role,
            ]);
        });

        collect(["Insured Admin", "Insured Representative"])->each(function ($role) use ($customer2) {
            User::factory()->create([
                "created_by_id" => 1,
                "customer_id" => $customer2->id,
                "name" => $role,
                "email" => implode("-", explode(" ", strtolower($role)))."2@admin.com",
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

        $mlceIndent1 = MlceIndent::factory()->create([
            "created_by_id" => 1,
            "mlce_type_id" => 3,
            "customer_id" => $customer1->id,
        ]);

        $mlceIndent2 = MlceIndent::factory()->create([
            "created_by_id" => 1,
            "mlce_type_id" => 3,
            "customer_id" => $customer2->id,
        ]);

        $mlceIndent1->users()->attach(4, ["type" => "RM"]);
        $mlceIndent1->users()->attach(6, ["type" => "U/W"]);
        $mlceIndent2->users()->attach(4, ["type" => "RM"]);
        $mlceIndent2->users()->attach(6, ["type" => "U/W"]);

        $indentLocation1 = MlceIndentLocation::factory()->create([
            "mlce_indent_id" => $mlceIndent1->id,
            "location" => "Mumbai",
            "status" => MlceIndentLocationStatus::NOT_ASSIGNED->value,
        ]);

        $mlceAssignment1 = MlceAssignment::factory()->create([
            "mlce_indent_id" => $mlceIndent1->id,
            "mlce_indent_location_id" => $indentLocation1->id,
            "inspector_id" => 2,
            "supervisor_id" => 3,
        ]);

        $indentLocation2 = MlceIndentLocation::factory()->create([
            "mlce_indent_id" => $mlceIndent2->id,
            "location" => "Mumbai",
            "status" => MlceIndentLocationStatus::NOT_ASSIGNED->value,
        ]);

        $mlceAssignment2 = MlceAssignment::factory()->create([
            "mlce_indent_id" => $mlceIndent2->id,
            "mlce_indent_location_id" => $indentLocation1->id,
            "inspector_id" => 2,
            "supervisor_id" => 3,
        ]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment1->id,
            'status' => AssigneeLocationTrackStatus::CMMI->value,
        ]);
        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment1->id,
            'status' => AssigneeLocationTrackStatus::ROS_2C_MLCE->value,
        ]);

        AssignmentObservation::factory()->create(["mlce_assignment_id" => $mlceAssignment1->id,]);
        AssignmentObservation::factory()->create(["mlce_assignment_id" => $mlceAssignment1->id,]);

        MlceRecommendation::factory()->create(["mlce_assignment_id" => $mlceAssignment1->id]);
        MlceRecommendation::factory()->create(["mlce_assignment_id" => $mlceAssignment1->id]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment1->id,
            'status' => AssigneeLocationTrackStatus::CMCD->value,
        ]);
        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment1->id,
            'status' => AssigneeLocationTrackStatus::DMC->value,
        ]);

        $mlceAssignment1->update([
            "location_status" => AssigneeLocationTrackStatus::DMC->value,
            "status" => MlceAssignmentStatus::COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s")
        ]);

        $mlceReport1 = MlceReport::factory()->create([
            "mlce_indent_id" => $mlceIndent1->id,
            "customer_id" => $mlceIndent1->customer_id,
        ]);

        $mlceReport1->views()->createMany([
            [
                "user_id" => 7,
                "ip_address" => fake()->ipv4(),
                "device_info" => fake()->userAgent()
            ],
            [
                "user_id" => 8,
                "ip_address" => fake()->ipv4(),
                "device_info" => fake()->userAgent()
            ],
            [
                "user_id" => 7,
                "page_name" => "Acknowledgment",
                "ip_address" => fake()->ipv4(),
                "device_info" => fake()->userAgent()
            ],
            [
                "user_id" => 8,
                "page_name" => "Acknowledgment",
                "ip_address" => fake()->ipv4(),
                "device_info" => fake()->userAgent()
            ],
        ]);

        $mlceReport1->increment("view_count", 2);
    }
}
