<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\CategoryCenter;
use App\Models\Contract;
use App\Models\Town;
use App\Models\UserTown;
use App\Models\CulturalSpace;
use App\Models\UserCulturalSpace;

class CulturalSpacesController extends Controller
{
    /**
     * Render the 'Welcome' view using Inertia.
     *
     * @return \Inertia\Response
     */
    public function welcome() {
        $categoryCenters = $this->getCategoryCenters();
        $contracts = $this->getContracts();

        return Inertia::render('Welcome', [
            'categoryCenters' => $categoryCenters,
            'contracts' => $contracts
        ]);
    }

    /**
     * Render the CulturalActivities page.
     *
     * @return \Inertia\Response
     */
    public function culturalActivities() {
        return Inertia::render('CulturalActivities', []);
    }

    /**
     * Render the CulturalActivities2 page.
     *
     * @return \Inertia\Response
     */
    public function culturalActivities2() {
        return Inertia::render('CulturalActivities2', []);
    }

    /**
     * Get category centers from the CategoryCenter model.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategoryCenters() {
        $categoryCenters = CategoryCenter::getCategoriesCenters();
        return $categoryCenters;
    }

    /**
     * Get contracts from the Contract model.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContracts() {
        $contracts = Contract::getContracts();
        return $contracts;
    }

    /**
     * Render the CulturalSpaces page with the specified ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function getSpaceCulture(Request $request, $id): Response {
        return Inertia::render('CulturalSpaces', ['id' => $id]);
    }

    /**
     * Render the CulturalSpaces2 page with the specified ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function getSpaceCulture2(Request $request, $id): Response {
        return Inertia::render('CulturalSpaces2', ['id' => $id]);
    }

    /**
     * Add a favorite poblacio.
     *
     * @param   string  $name  The name of the poblacio to add as a favorite.
     *
     * @return  void
     */
    public function addFavoritePoblacio($name) {
        $town = new Town();
        $town->addFavoritePoblacio($name);

    }

    /**
     * Get the ID of a town by its name.
     *
     * @param   string  $name  The name of the town.
     *
     * @return  int|null        The ID of the town, or null if not found.
     */
    public function getIdTownByName($name) {
        $town = new Town();
        return $town->getIdTownByName($name);
    }

    /**
     * Get the ID of a cultural space by its name.
     *
     * @param   string  $name  The name of the cultural space.
     *
     * @return  int|null        The ID of the cultural space, or null if not found.
     */
    public function getIdCultureSpaceByName($name) {
        $culturalSpace = new CulturalSpace();
        return $culturalSpace->getIdCultureSpaceByName($name);
    }

    /**
     * Add a favorite space.
     *
     * @param   int  $id  The ID of the space to add as a favorite.
     *
     * @return  void
     */
    public function addFavoriteSpace($id){
        $userTown = new UserTown();
        $userTown->addFavorite($id);
    }

    /**
     * Add a favorite user town.
     *
     * @param   int  $id_town  The ID of the town to add as a favorite.
     * @param   int  $id_user  The ID of the user.
     *
     * @return  void
     */
    public function addFavouriteUserTown($id_town, $id_user){
        $userTown = new UserTown();
        $userTown->addFavouriteUserTown($id_town, $id_user);
    }

    /**
     * Add a favorite cultural space.
     *
     * @param   string  $name  The name of the cultural space to add as a favorite.
     *
     * @return  void
     */
    public function addFavouriteCulturalSpace($name){
        $culturalSpace = new CulturalSpace();
        $culturalSpace->addFavouriteCulturalSpace($name);
    }

    /**
     * Add a favorite cultural space user.
     *
     * @param   int  $id_cultural_space  The ID of the cultural space to add as a favorite.
     * @param   int  $id_user            The ID of the user.
     *
     * @return  void
     */
    public function addFavouriteCulturalSpaceUser($id_cultural_space, $id_user){
        $userCulturalSpace = new UserCulturalSpace();
        $userCulturalSpace->addFavouriteCulturalSpaceUser($id_cultural_space, $id_user);
    }

    /**
     * Delete a favorite city for the current user.
     *
     * @param   int       $id       The ID of the city to delete.
     * @param   Request   $request  The current request.
     *
     * @return  void
     */
    public function deleteFavouriteCity($id, Request $request){
        $userTown = new UserTown();
        $userId = auth()->id();
        $userTown->deleteFavouriteCity($id, $userId);
    }
}