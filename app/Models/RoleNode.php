<?php

declare (strict_types= 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleNode extends Model
{
    use HasFactory;

    protected $table = 'roles_node';
    
    protected $fillable = 
    [
        'node_id',
        'role'
    ];

    //relationships (pending) to be implemented as those model classes are created
    // public function resourcesNode()
    // {
    //     return $this->hasMany(resourcesNode::class,  'role_node_id', 'node_id');
    // }

    // public function bookmarksNode()
    // {
    //     return $this->hasMany(bookmarksNode::class,  'role_node_id', 'node_id');
    // }

    // public function likesNode()
    // {
    //     return $this->hasMany(likesNode::class,  'role_node_id', 'node_id');
    // }


}

