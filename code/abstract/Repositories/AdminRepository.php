<?php

namespace Repositories;

use Repositories\Interfaces\AdminRepositoryInterface;
use Models\Admin;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * Method creates an admin invitation record for the next registration
     * @param array $adminData
     * @return mixed - invitation details
     */
    public function inviteAdmin(array $adminData): mixed
    {
        return Admin::query()->create($adminData);
    }
}