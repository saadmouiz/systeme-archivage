<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'is_active'];

    public function hasAccess($section)
    {
        $permissions = [
            'admin1' => ['financiers', 'employes', 'administratif', 'rh', 'pointages', 'courriers'],
            'admin2' => ['beneficiaires', 'evenement', 'communication', 'courriers'],
            'admin3' => ['pointages', 'beneficiaires', 'courriers'],
            'superadmin' => ['financiers', 'employes', 'administratif', 'rh', 'beneficiaires', 'partenaires', 'evenement', 'communication', 'pointages', 'courriers'],
        ];

        $userRole = $this->roles->first()->name ?? null;
        return $userRole && in_array($section, $permissions[$userRole] ?? []);
    }
}