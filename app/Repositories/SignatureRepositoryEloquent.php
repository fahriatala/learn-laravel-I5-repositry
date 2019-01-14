<?php

namespace App\Repositories;

use App\Criteria\SignaturesCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SignatureRepository;
use App\Entities\Signature;
use App\Validators\SignatureValidator;
use App\Presenters\SignaturePresenter;

/**
 * Class SignatureRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SignatureRepositoryEloquent extends BaseRepository implements SignatureRepository
{

    protected $fieldSearchable = [
    'name'=>'like',
    'email',
    'body'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Signature::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SignatureValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        #$this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(SignaturesCriteria::class));
    }

    public function presenter()
    {
        return "App\\Presenters\\SignaturePresenter";
    }
    
}
