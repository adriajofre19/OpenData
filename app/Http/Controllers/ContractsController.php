<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Contract;

class ContractsController extends Controller
{
    /**
     * Render the contracts index page.
     *
     * @return \Inertia\Response
     */
    public function index() {
        $contracts = $this->getContracts();
        return Inertia::render('Contracts', [
            'contracts' => $contracts
        ]);
    }

    /**
     * Retrieve contracts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContracts() {
        $contracts = Contract::getContracts();
        return $contracts;
    }
}