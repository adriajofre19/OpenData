<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Activitat;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Role;
use App\Models\Contract;
use App\Models\Message;

class ProcedureController extends Controller
{
    /**
     * Render the view for displaying statistics.
     *
     * @return \Inertia\Response
     */
    public function view() {
        $result1 = $this->calculateCategoryPercentage();
        $result2 = $this->calculatePlanPercentage();

        return Inertia::render('Stats', [
            'result1' => $result1,
            'result2' => $result2
        ]);
    }

    /**
     * Calculate the percentage for each category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateCategoryPercentage() {
        DB::select('CALL CalculateCategoryPercentage()');
        $result = DB::table('category_results')->get();
        return response()->json($result);
    }

    /**
     * Calculate the percentage for each plan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatePlanPercentage() {
        DB::select('CALL CalculatePlanPercentage()');
        $result = DB::table('plan_results')->get();
        return response()->json($result);
    }
}