<?php 

namespace App\Traits;

trait TrainingSessionTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'disassociateAllClients' => 'disassociateAllClients',
            'disassociateAllExercises' => 'disassociateAllExercises',
            'disassociateAllCoaches' => 'disassociateAllCoaches',
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
            'disassociateAllClients',
            'disassociateAllExercises',
            'disassociateAllCoaches',
        ]);
    }
}
