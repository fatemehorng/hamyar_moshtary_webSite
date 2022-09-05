<?php

namespace App\Http\Controllers\Admin
;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Repositories\City\CityRepositoryInterface;
use App\Repositories\Province\ProvinceRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\UserAddress\UserAddressRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(readonly private UserRepositoryInterface $userRepository,
                                readonly private ProvinceRepositoryInterface $provinceRepository,
                                readonly private CityRepositoryInterface $cityRepository,
                                readonly private UserAddressRepositoryInterface $userAddressRepository){}

    public  function  index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
{
        $provinces = $this->provinceRepository->all();
        $cities = $this->cityRepository->all();
        $users=$this->userRepository->getUsersByFilters();
        return view('admin.users.index',compact('users','provinces','cities'));
    }

    public  function  create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $cities = $this->cityRepository->all();
        $provinces = $this->provinceRepository->all();
        return view('admin.users.create',compact( 'provinces', 'cities'));

    }
    public function store(StoreUserRequest $request)
    {
        return $this->userRepository->create($request->all());
    }

    public function show($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = $this->userRepository->find($id);
        return view('admin.users.details', compact('user'));

    }

    public function update(Request  $request, $id): \Illuminate\Http\RedirectResponse
    {
       $this->userRepository->update($request->all(), $id);
       return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->userRepository->delete($id);
        return redirect()->back();
    }
}
