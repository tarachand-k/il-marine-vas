<?php

use App\Http\Controllers\Api\V1\AboutUsController;
use App\Http\Controllers\Api\V1\AcknowledgmentController;
use App\Http\Controllers\Api\V1\AssigneeLocationTrackController;
use App\Http\Controllers\Api\V1\AssignmentObservationController;
use App\Http\Controllers\Api\V1\AssignmentPhotoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CommandController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\MarineVasController;
use App\Http\Controllers\Api\V1\MlceAssignmentController;
use App\Http\Controllers\Api\V1\MlceIndentController;
use App\Http\Controllers\Api\V1\MlceRecommendationController;
use App\Http\Controllers\Api\V1\MlceReportController;
use App\Http\Controllers\Api\V1\MlceTypeController;
use App\Http\Controllers\Api\V1\NavigationReportManualController;
use App\Http\Controllers\Api\V1\ReportViewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VideoController;
use App\Http\Controllers\Api\V1\VideoViewController;
use App\Http\Controllers\Api\V1\WhyMlceController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    // open routes
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::post("forgot-password", [AuthController::class, "forgotPassword"]);
    Route::post("reset-password", [AuthController::class, "resetPassword"]);

    // secure routes
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("update-password", [AuthController::class, "updatePassword"]);
        Route::get("profile", [UserController::class, 'profile']);
        Route::post("logout", [AuthController::class, "logout"]);

        Route::apiResources([
            "users" => UserController::class,
            "acknowledgments" => AcknowledgmentController::class,
            "about-us" => AboutUsController::class,
            "marine-vas" => MarineVasController::class,
            "navigation-report-manuals" => NavigationReportManualController::class,
            "why-mlce" => WhyMlceController::class,
            "customers" => CustomerController::class,
            "mlce-types" => MlceTypeController::class,
            "mlce-indents" => MlceIndentController::class,
            "mlce-assignments" => MlceAssignmentController::class,
            "assignee-location-tracks" => AssigneeLocationTrackController::class,
            "assignment-observations" => AssignmentObservationController::class,
            "mlce-recommendations" => MlceRecommendationController::class,
            "assignment-photos" => AssignmentPhotoController::class,
            "mlce-reports" => MlceReportController::class,
            "mlce-reports.views" => ReportViewController::class,
            "videos" => VideoController::class,
            "videos.views" => VideoViewController::class,
        ], [
            // ⛔ do not delete or update this, else the updating will not work.
            'parameters' => [
                'about-us' => 'about_us',
                'marine-vas' => 'marine_vas',
            ]
        ]);

        Route::post("mlce-assignments/{mlce_assignment}/assignee-location-tracks",
            [AssigneeLocationTrackController::class, "store"]);

        Route::prefix("mlce-assignments/{mlce_assignment}")
            ->controller(MlceAssignmentController::class)->group(function () {
                Route::patch("complete", "completeAssignment");
                Route::patch("cancel", "cancelAssignment");
            });

        Route::prefix("mlce-reports/{mlce_report}")
            ->controller(MlceReportController::class)->group(function () {
                Route::patch("approve", "approveReport");
                Route::patch("publish", "publishReport");
            });

        Route::get("dashboard", DashboardController::class);
    });

    // open route (only for backend use)
    Route::post("commands", CommandController::class);
});
