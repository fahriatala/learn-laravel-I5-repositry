<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Signature;

/**
 * Class SignatureTransformer.
 *
 * @package namespace App\Transformers;
 */
class SignatureTransformer extends TransformerAbstract
{
    /**
     * Transform the Signature entity.
     *
     * @param \App\Entities\Signature $model
     *
     * @return array
     */
    public function transform(Signature $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'email'      => $model->email,
            'body'       => $model->body,
            /* place your other model properties here */

            // 'created_at' => $model->created_at,
            // 'updated_at' => $model->updated_at
        ];
    }
}
