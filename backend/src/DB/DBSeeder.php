<?php

namespace DeepCode\DB;

use DeepCode\Models\Role;
use DeepCode\Models\User;
use DeepCode\Modules\Authentication\Repositories\IRolesRepository;
use DeepCode\Modules\Authentication\Repositories\IUser_RolesRepository;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Services\IPasswordHashingService;

class DBSeeder
{
    private IUserRepository $userRepository;
    private IRolesRepository $rolesRepository;
    private IUser_RolesRepository $user_RolesRepository;
    private IPasswordHashingService $hashingService;

    public function __construct(IUserRepository $userRepository,
                                IRolesRepository $rolesRepository,
                                IPasswordHashingService $hashingService,
                                IUser_RolesRepository $user_RolesRepository){
        $this->userRepository = $userRepository;
        $this->rolesRepository = $rolesRepository;
        $this->hashingService = $hashingService;
        $this->user_RolesRepository = $user_RolesRepository;
    }

    public function seed(): void{
        // check existence admin role
        $adminRole = $this->rolesRepository->getRoleByName("Admin");

        if($adminRole == null){
            $adminRole = new Role();
            $adminRole->Name = "Admin";

            $this->rolesRepository->insert($adminRole);
            $adminRole = $this->rolesRepository->getRoleByName("Admin");
        }

        // check is there admin
        $admin = $this->userRepository->findByLogin("Admin");

        if($admin == null){
            $admin = new User();

            $admin->Login = "Admin";
            $admin->Password = $this->hashingService->hashPassword($_ENV['ADMIN_PASSWORD']);
            $admin->Name = "Admin";
            $this->userRepository->insert($admin);

            $admin = $this->userRepository->findByLogin("Admin");
        }

        // give role for admin
        if(!$this->user_RolesRepository->isUserHaveRole($admin->Id, $adminRole->Id)){
            $this->user_RolesRepository->addRoleForUser($admin->Id, $adminRole->Id);
        }
    }
}