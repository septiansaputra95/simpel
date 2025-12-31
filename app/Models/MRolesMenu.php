<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MRolesMenu extends Model
{
    //
    protected $primaryKey = "id";
    protected $table = 'm_roles_menus';

    protected $fillable = [
        'id',
        'role_id',
        'menu_id', 
        'can_view', 
        'can_create',
        'can_edit',
        'can_delete'
    ];
}
