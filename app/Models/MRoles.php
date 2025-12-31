<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MRoles extends Model
{
    //
    protected $primaryKey = "id";
    protected $table = 'm_roles';

    protected $fillable = [
        'id',
        'rolesname',
        'description'
    ];

    public function menus()
    {
        return $this->belongsToMany(MMenu::class, 'm_roles_menus', 'role_id', 'menu_id')
                    ->withPivot(['can_view', 'can_create', 'can_edit', 'can_delete']);
    }
}
