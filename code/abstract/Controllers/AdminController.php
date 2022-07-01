<?php

namespace Controllers;

use Controllers\Controller;
use Repositories\Interfaces\AdminRepositoryInterface;
use Requests\StoreAdminRequest;

class AdminController extends Controller
{
    protected AdminRepositoryInterface $repository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->repository = $adminRepository;
    }

    public function storeAdmin(StoreAdminRequest $request)
    {
        $adminData = $request->validated();

        try {
            $invitation = $this->repository->inviteAdmin($adminData);

            if ($invitation) {
                return response()->json(['message' => __('admin_stored_successfully')]);
            }
        } catch (\Error $e) {
            return $e->getMessage();
        }
    }
}