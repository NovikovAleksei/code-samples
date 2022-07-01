<?php

namespace Repositories\Interfaces;

interface AdminRepositoryInterface
{
    /**
     * Method creates an admin invitation record for the next registration
     * @param array $adminData
     * @return mixed - invitation details
     */
    public function inviteAdmin(array $adminData): mixed;
}