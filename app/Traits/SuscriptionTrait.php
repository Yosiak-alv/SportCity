<?php 

namespace App\Traits;

trait SuscriptionTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'suscriptionInvoice' => 'suscriptionInvoice',
            'cancelSuscription' => 'cancelSuscription'
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
        ]);
    }
}
