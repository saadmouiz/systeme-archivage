<?php
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{


    public function assignRole(Admin $admin, $role)
    {
        $admin->assignRole($role);
        return back()->with('success', 'Rôle assigné avec succès');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
            'role' => 'required|in:super_admin,pointages,administratif,financiers,rh,employés,bénéficiaires,partenaires,communication,événement'
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),        
            'role' => $request->role, // Assurez-vous que cette ligne récupère bien la valeur envoyée
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin ajouté avec succès');
    }
}
 