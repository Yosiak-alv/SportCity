<?php 

namespace App\Traits;

trait PurchaseTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'cancelPurchase' => 'cancelPurchase',
            'purchaseInvoice' => 'purchaseInvoice'
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
        ]);
    }
}