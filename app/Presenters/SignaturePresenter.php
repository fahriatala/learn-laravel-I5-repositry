<?php

namespace App\Presenters;

use App\Transformers\SignatureTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SignaturePresenter.
 *
 * @package namespace App\Presenters;
 */
class SignaturePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SignatureTransformer();
    }
}
