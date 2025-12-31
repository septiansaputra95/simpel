<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMenu extends Model
{
    //
    protected $primaryKey = "id";
    protected $table = 'm_menus';

    protected $fillable = [
        'id',
        'menuname',
        'route', 
        'icon', 
        'parent_id',
        'order',
        'is_active'
    ];

    public function roles()
    {
        return $this->belongsToMany(MRoles::class, 'm_roles_menus', 'menu_id', 'role_id')
                    ->withPivot(['can_view', 'can_create', 'can_edit', 'can_delete']);
    }

    public function children()
    {
        return $this->hasMany(MMenu::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(MMenu::class, 'parent_id');
    }
}
