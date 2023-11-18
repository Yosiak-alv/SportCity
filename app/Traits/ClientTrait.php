<?php 

namespace App\Traits;

trait ClientTrait {
    
    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'restore' => 'restore',
            'updatePassword' => 'updatePassword',

            'createSystem' => 'createSystem',
            'storeSystem' => 'createSystem',
            'editSystem' => 'updateSystem',
            'updateSystem' => 'updateSystem',
            'destroySystem' => 'deleteSystem',

            'createSuscription' => 'createSuscription',
            'storeSuscription' => 'createSuscription',
            'showSuscription' => 'showSuscription',
            'cancelSuscription' => 'cancelSuscription',
            'suscriptionInvoice' => 'suscriptionInvoice',

            'assignAttendance' => 'assignAttendance',
            'storeAttendance' => 'assignAttendance',
            'attendaceShow' => 'attendaceShow',
            'registerAttendanceDate' => 'registerAttendanceDate',
            'destroyAttendace' => 'destroyAttendace',

            'createPurchase' => 'createPurchase',
            'storePurchase' => 'createPurchase',
            'showPurchase' => 'showPurchase',
            'purchaseInvoice' => 'purchaseInvoice',
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
            /* 'addToOrder',
            'removeFromOrder', */
        ]);
    }
}
