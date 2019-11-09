<?php

namespace Souktel\ACL\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseComponent
 *
 * @property int id
 * @property string title
 * @property array placeholder
 * @property int component_type_id
 * @property string component_type_key
 *
 * @package App\Models
 */
class Permission extends Model
{

    /**
     * @var string
     */
    protected $table = 'permissions';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'created_at', 'updated_at',
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

}
