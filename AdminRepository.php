<?php

namespace App\Repositories\AdminRepository;

use App\Filters\AdminsFilter;
use App\Models\Admin;
use App\Repositories\BaseRepository;


class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return \App\Models\AdminRole
     */
    public function getAdminPermissionsByAdminId(int $id): \App\Models\AdminRole {
        return $this->find($id)->roles()->get()->first();
    }

    /**
     * @param $data
     * @return int[]
     */
    public function getAdminPermissions($data): array
    {
        return [
            'super' => isset($data['is_super']) ? 1 : 0,
            'product_categories' => isset($data['toProductCategories']) ? 1 : 0,
            'products' => isset($data['toProducts']) ? 1 : 0,
            'features' => isset($data['toFeatures']) ? 1 : 0,
            'users' => isset($data['toUsers']) ? 1 : 0,
            'banners' => isset($data['toBanners']) ? 1 : 0,
            'sliders' => isset($data['toSliders']) ? 1 : 0,
            'social_media' => isset($data['toSocialMedia']) ? 1 : 0,
            'send_costs' => isset($data['toSendCosts']) ? 1 : 0,
            'settings' => isset($data['toSettings']) ? 1 : 0,
            'discounts' => isset($data['toDiscounts']) ? 1 : 0,
            'factors' => isset($data['toFactors']) ? 1 : 0,
            'sets' => isset($data['toSets']) ? 1 : 0,

        ];
    }

    /**
     * @param $data
     */
    public function createAdmin($data)
    {
       $admin = $this->create($data);
       $admin->roles()->create($this->getAdminPermissions($data));
    }

    public function updateAdmin($data, $id)
    {
      $this->update($data, $id);
        $admin = $this->find($id);

        if ($admin->roles()->get()->count() > 0) {
            $admin->roles()->forceDelete();
        }

     return $admin->roles()->create($this->getAdminPermissions($data));

    }
    public function deleteAdmin( $id)
    {
        $admin = $this->find($id);
        $admin->roles()->delete();
        $this->model->find($id)->delete();
    }

    public  function getAdminsByFilters()
    {
        $queryParam=[
            'q' => request()->q,
            'roles'=> request()->roles,
            'page' => request()->page
        ];
        $admins= new AdminsFilter($queryParam,10);
        $admins->filter();
        return $admins->getResult();
    }
}
