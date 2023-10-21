<?php 

namespace App\Traits;

trait UserTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'updatePassword' => 'updatePassword',
            
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
        ]);
    }
}
