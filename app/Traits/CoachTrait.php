<?php 

namespace App\Traits;

trait CoachTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'restore' => 'restore',
            'showTrainingSession' => 'showTrainingSession',
            'updatePassword' => 'updatePassword'
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
            'showTrainingSession',
        ]);
    }
}
