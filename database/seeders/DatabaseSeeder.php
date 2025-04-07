<?php

namespace Database\Seeders;

use App\Enums\AssigneeLocationTrackStatus;
use App\Enums\MlceAssignmentStatus;
use App\Enums\MlceIndentLocationStatus;
use App\Enums\MlceIndentStatus;
use App\Enums\MlceRecommendationClosurePriority;
use App\Enums\MlceRecommendationTimeline;
use App\Enums\MlceReportStatus;
use App\Enums\UserRole;
use App\Models\AboutUs;
use App\Models\Acknowledgment;
use App\Models\AssigneeLocationTrack;
use App\Models\AssignmentObservation;
use App\Models\Customer;
use App\Models\Disclaimer;
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

        Disclaimer::factory()->create();

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
                "about" => $role === UserRole::MARINE_EXT_TEAM_MEMBER->value ? fake()->paragraphs(asText: true) : null,
            ]);
        });

        $customer1 = Customer::factory()->create([
            "name" => "JSW Paints",
            "email" => "customer@jsw-paints.in",
            "rm_id" => User::firstWhere("role", UserRole::RM->value)->id,
            "under_writer_id" => User::firstWhere("role", UserRole::UW->value)->id,
            "channel_partner_id" => User::firstWhere("role", UserRole::CHANNEL_PARTNER->value)->id,
        ]);

        $customer2 = Customer::factory()->create([
            "name" => "Xiaomi India",
            "email" => "customer@xiaomi.in",
            "rm_id" => User::firstWhere("role", UserRole::RM->value)->id,
            "under_writer_id" => User::firstWhere("role", UserRole::UW->value)->id,
            "channel_partner_id" => User::firstWhere("role", UserRole::CHANNEL_PARTNER->value)->id,
        ]);

        Customer::all()->each(function ($customer) use ($admin, $insuredRoles) {
            $insuredRoles->each(fn($role) => User::factory()->create([
                "created_by_id" => $admin->id,
                "customer_id" => $customer->id,
                "role" => $role,
            ]));

            $mlceIndent = MlceIndent::factory()->create([
                "created_by_id" => $admin->id,
                "mlce_type_id" => 3,
                "customer_id" => $customer->id,
                "insured_representative_id" => User::where("customer_id", $customer->id)
                    ->where("role", UserRole::INSURED_REPRESENTATIVE->value)->first()->id,
                "rm_id" => User::where("role", UserRole::RM->value)->first()->id,
                "vertical_rm_id" => User::where("role", UserRole::VERTICAL_RM->value)->first()->id,
                "under_writer_id" => User::where("role", UserRole::UW->value)->first()->id,
            ]);

            $mlceIndent->allowedUsers()->attach(User::where("customer_id", $customer->id)
                ->where("role", UserRole::INSURED_ADMIN->value)->first()->id);

//            $mlceIndent->allowedUsers()->attach(User::where("customer_id", $customer->id)
//                ->where("role", UserRole::INSURED_REPRESENTATIVE->value)->first()->id);

            $mlceReport = MlceReport::factory()->create([
                "mlce_indent_id" => $mlceIndent->id,
                "customer_id" => $mlceIndent->customer_id,
            ]);

            $indentLocations = ["Mumbai", "Pune"];

            foreach ($indentLocations as $location) {
                $indentLocation = MlceIndentLocation::factory()->create([
                    "mlce_indent_id" => $mlceIndent->id,
                    "location" => $location,
                    "status" => MlceIndentLocationStatus::NOT_ASSIGNED->value,
                ]);

                $mlceAssignment = MlceAssignment::factory()->create([
                    "mlce_indent_id" => $mlceIndent->id,
                    "mlce_indent_location_id" => $indentLocation->id,
                    "inspector_id" => 2,
                    "supervisor_id" => 3,
                ]);
                $indentLocation->update(["status" => MlceIndentLocationStatus::PENDING->value]);

                AssigneeLocationTrack::factory()->create([
                    "mlce_assignment_id" => $mlceAssignment->id,
                    'status' => AssigneeLocationTrackStatus::CMMI->value,
                ]);
                AssigneeLocationTrack::factory()->create([
                    "mlce_assignment_id" => $mlceAssignment->id,
                    'status' => AssigneeLocationTrackStatus::ROS_2C_MLCE->value,
                ]);

                AssignmentObservation::factory()->create([
                    "ref_no" => AssignmentObservation::generateRefNo($indentLocation->location, $mlceAssignment->id),
                    "mlce_assignment_id" => $mlceAssignment->id,
                ]);
                AssignmentObservation::factory()->create([
                    "ref_no" => AssignmentObservation::generateRefNo($indentLocation->location, $mlceAssignment->id),
                    "mlce_assignment_id" => $mlceAssignment->id,
                ]);

                MlceRecommendation::factory()->create([
                    "mlce_indent_id" => $mlceIndent->id,
                    "ref_no" => MlceRecommendation::generateRefNo($indentLocation->location, $mlceAssignment->id),
                    "sub_location" => "Loading Procedure",
                    "closure_priority" => MlceRecommendationClosurePriority::HIGH->value,
                    "timeline" => MlceRecommendationTimeline::DAYS_7->value,
                    "mlce_assignment_id" => $mlceAssignment->id,
                    "brief" => "Loading and securing to be done as per the SOP.",
                    "current_observation" => "We noted the loading and securing is done as per the SOP.",
                    "hazard" => "If not followed the damage could occur to the packing, absence of lashing, improper vehicle selection etc., could result in recurring damages",
                    "recommendations" => "Any abnormalities / damages observed on material, packing, stacking, lashing, vehicle condition, holes in tarpaulin / roof of the vehicle, protruding objects, water marks etc., should be photographed before unloading and the same should be informed to the supplier and the transporter.
                                            The stacking of the containers to be in line with the SOP."
                ]);

                MlceRecommendation::factory()->create([
                    "mlce_indent_id" => $mlceIndent->id,
                    "ref_no" => MlceRecommendation::generateRefNo($indentLocation->location, $mlceAssignment->id),
                    "sub_location" => "Transport / Carrier Vehicle",
                    "timeline" => MlceRecommendationTimeline::DAYS_90->value,
                    "closure_priority" => MlceRecommendationClosurePriority::LOW->value,
                    "mlce_assignment_id" => $mlceAssignment->id,
                    "brief" => "Each vehicle associated with the Insured shall be tracked for its on time schedule, theft/pilferage control and monitor performance.",
                    "current_observation" => "Sim Based Tracking application is implemented for tracking purpose.",
                    "hazard" => "Lack of transit visibility can lead to delivery delays. Over-speeding can damage the cargo’s external packaging, which may result in customer rejection.",
                    "recommendations" => "ILGIC shall create a TRIP creation dashboard to the client.
                                            The dispatch coordinator at Plant  will feed basic info, i.e consignment serial no, destination , transport name  (chosen from drop down) and driver’s details
                                            ILGICnd team or the CHA  will rig the portable GPS device in the cabin that shall be synchronous with the tracking system.  Client will have a LIVE 24x7 trackig of the trips/ and reversing of devices managed by ILGIC.",
                ]);

                AssigneeLocationTrack::factory()->create([
                    "mlce_assignment_id" => $mlceAssignment->id,
                    'status' => AssigneeLocationTrackStatus::CMCD->value,
                ]);

                $mlceAssignment->update([
                    "status" => MlceAssignmentStatus::SURVEY_COMPLETED->value,
                    "completed_at" => now()->format("Y-m-d H:i:s")
                ]);
                $indentLocation->update(["status" => MlceIndentLocationStatus::COMPLETED->value]);

                AssigneeLocationTrack::factory()->create([
                    "mlce_assignment_id" => $mlceAssignment->id,
                    'status' => AssigneeLocationTrackStatus::DMC->value,
                ]);

                $mlceAssignment->update(["status" => MlceAssignmentStatus::DEMOBILISED->value]);
                $mlceAssignment->update(["status" => MlceAssignmentStatus::RECOMMENDATIONS_SUBMITTED->value]);
            }

            $mlceReport->update([
                "status" => MlceReportStatus::APPROVED->value,
                "submitted_at" => now()->format("Y-m-d H:i:s"),
                "approved_by_id" => $admin->id,
                "approved_at" => now()->format("Y-m-d H:i:s"),
            ]);
            $mlceIndent->update(["status" => MlceIndentStatus::IN_CLIENT_REVIEW->value]);

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
        });
    }
}

