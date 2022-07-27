<?php

namespace App\Services;

use App\Repositories\FarmRepository;
use App\Repositories\UserRepository;

class FarmService
{

    private FarmRepository $farmRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, FarmRepository $farmRepository)
    {
        $this->userRepository = $userRepository;
        $this->farmRepository = $farmRepository;
    }

    public function create($farmAttributes, $userId)
    {
        $user = $this->userRepository->find($userId);

        return $user->farm()->create($farmAttributes);
    }

    public function find($farmId)
    {
        return $this->farmRepository->find($farmId);
    }

    public function update($farmAttributes, $farmId)
    {
        $this->farmRepository->update($farmAttributes, $farmId);
        return $this->farmRepository->find($farmId);
    }
    public function delete($id)
    {
        return $this->farmRepository->delete($id);
    }
}
