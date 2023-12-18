<?php

namespace App\Http\Controllers\Api\v1;
use App\Enums\BannerStatus;
use App\Http\Resources\v1\BannerResource;
use App\Http\Resources\v1\UserResource;
use App\Http\Controllers\BackendController;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Models\Banner;
class CustomerController extends BackendController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');

    }
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
  public function index()
   {
   
      $users = User::whereHas('roles', function ($query) {
        $query->where('id', 2);
      })->get();

      return $this->successresponse(['success' => 200, 'data' => UserResource::collection($users)]);
   }

}
