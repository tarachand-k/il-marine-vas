<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {
        $data = $request->validate([
            "command" => ['required', 'string']
        ]);

        Artisan::call($data["command"]);

        return $this->respondSuccess(
            "Command executed successfully!"
        );
    }
}
