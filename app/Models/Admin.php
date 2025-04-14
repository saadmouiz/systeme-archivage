<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $fillable = ['name', 'email', 'password'];

    public function hasAccess($section)
    {
        $permissions = [
            'admin1' => ['financiers', 'employes', 'administratif', 'rh'],
            'admin2' => ['beneficiaires',  'evenement', 'communication'],
            'admin3' => ['pointages' , 'beneficiaires'],
            'superadmin' => ['financiers', 'employes', 'administratif', 'rh', 'beneficiaires', 'partenaires', 'evenement', 'communication','pointages'],
        ];

        $userRole = $this->roles->first()->name ?? null;
        return $userRole && in_array($section, $permissions[$userRole] ?? []);
    }
}