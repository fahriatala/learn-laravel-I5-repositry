<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Signature.
 *
 * @package namespace App\Entities;
 */
class Signature extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'signatures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    #protected $primaryKey = 'id';

    protected $fillable = ['name','email','body'];

}
