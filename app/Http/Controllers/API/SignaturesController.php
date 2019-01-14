<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Criteria\SignaturesCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SignatureCreateRequest;
use App\Http\Requests\SignatureUpdateRequest;
use App\Repositories\SignatureRepository;
use App\Validators\SignatureValidator;

class SignaturesController extends Controller
{
    protected $repository;

    /**
     * @var SignatureValidator
     */
    protected $validator;

    /**
     * SignaturesController constructor.
     *
     * @param SignatureRepository $repository
     * @param SignatureValidator $validator
     */
    public function __construct(SignatureRepository $repository, SignatureValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->repository->where('id','!=',23);
        //$signatures = $this->repository->getByCriteria(new SignaturesCriteria());
        $signatures = $this->repository->paginate($limit = null, $columns = ['*']);
        
        return response()->json($signatures, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SignatureCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SignatureCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $signature = $this->repository->create($request->all());

            $response = [
                'message' => 'Signature created.',
                'data'    => $signature,
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);

         }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $signature = $this->repository->find($id);

        return response()->json([
                'data' => $signature,
            ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  SignatureUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SignatureUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $signature = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Signature updated.',
                'data'    => $signature,
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
             ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
                'message' => 'Signature deleted.',
                'deleted' => $deleted,
            ]);
        
    }
}
