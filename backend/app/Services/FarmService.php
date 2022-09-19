<?php

namespace App\Services;

use App\Models\Farm;
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

        $newFarm = $user->farm()->create($farmAttributes);
        $newFarm->warehouse()->create();
        return $newFarm;
    }

    public function find($farmId)
    {
        return Farm::findOrFail($farmId);
        // return $this->farmRepository->find($farmId);
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
