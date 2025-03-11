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
use App\Models\Marketing;
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

        $admin = User::factory()->create([
            "name" => "IL Admin",
            "email" => "admin@admin.com",
            "role" => UserRole::ILGIC_MLCE_ADMIN->value,
        ]);

        $roles = collect(array_column(UserRole::cases(), "value"));
        $systemRoles = $roles->filter(fn($role) => !(in_array($role,
            [UserRole::INSURED_ADMIN->value, UserRole::INSURED_REPRESENTATIVE->value])));
        $insuredRoles = $roles->filter(fn($role) => in_array($role,
            [UserRole::INSURED_ADMIN->value, UserRole::INSURED_REPRESENTATIVE->value]));
        $systemRolesWithoutAdmin = $systemRoles->filter(fn($role) => $role !== UserRole::ILGIC_MLCE_ADMIN->value);

        $systemRolesWithoutAdmin->each(function ($role) use ($admin) {
            User::factory()->create([
                "created_by_id" => $admin->id,
                "email" => implode("-", explode(" ", strtolower($role)))."@admin.com",
                "role" => $role,
            ]);
        });

        $customer1 = Customer::factory()->create([
            "name" => "Customer 1",
            "email" => "customer1@admin.com",
        ]);

        $customer2 = Customer::factory()->create([
            "name" => "Customer 2",
            "email" => "customer2@admin.com",
        ]);

        // created users for customer 1
        $insuredRoles->each(function ($role) use ($admin, $customer1) {
            User::factory()->create([
                "created_by_id" => $admin->id,
                "customer_id" => $customer1->id,
                "email" => implode("-", explode(" ", strtolower($role)))."@admin.com",
                "role" => $role,
            ]);
        });

        // create users for customer 2
        $insuredRoles->each(function ($role) use ($admin, $customer2) {
            User::factory()->create([
                "created_by_id" => $admin->id,
                "customer_id" => $customer2->id,
                "role" => $role,
            ]);
        });

        Customer::all()->each(function ($customer) use ($admin) {
            $mlceIndent = MlceIndent::factory()->create([
                "created_by_id" => $admin->id,
                "mlce_type_id" => 3,
                "customer_id" => $customer->id,
                "insured_representative_id" => User::where("role",
                    UserRole::INSURED_REPRESENTATIVE->value)->where("customer_id", $customer->id)->first()->id,
                "rm_id" => User::where("role", UserRole::RM->value)->first()->id,
                "vertical_rm_id" => User::where("role", UserRole::VERTICAL_RM->value)->first()->id,
                "under_writer_id" => User::where("role", UserRole::UW->value)->first()->id,
            ]);

            $mlceIndent->allowedUsers()->attach($customer->users()
                ->where("role", UserRole::INSURED_ADMIN->value)->first()->id);


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

            $mlceReport = MlceReport::factory()->create([
                "mlce_indent_id" => $mlceIndent->id,
                "customer_id" => $mlceIndent->customer_id,
            ]);
        });

        $mlceIndent = MlceIndent::first();
        $mlceAssignment = MlceAssignment::first();

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::CMMI->value,
        ]);
        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::ROS_2C_MLCE->value,
        ]);

        AssignmentObservation::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
        ]);
        AssignmentObservation::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
        ]);

        MlceRecommendation::factory()->create([
            "customer_id" => $customer1->id,
            "mlce_assignment_id" => $mlceAssignment->id
        ]);
        MlceRecommendation::factory()->create([
            "customer_id" => $customer1->id,
            "mlce_assignment_id" => $mlceAssignment->id
        ]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::CMCD->value,
        ]);
        $mlceAssignment->update([
            "location_status" => AssigneeLocationTrackStatus::CMCD->value,
            "status" => MlceAssignmentStatus::COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s")
        ]);

        AssigneeLocationTrack::factory()->create([
            "mlce_assignment_id" => $mlceAssignment->id,
            'status' => AssigneeLocationTrackStatus::DMC->value,
        ]);


        $mlceReport = MlceReport::first();

        $mlceReport->views()->createMany([
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

        $mlceReport->increment("view_count", 2);

        Marketing::factory()->create();
    }
}
