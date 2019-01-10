<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SignatureCreateRequest;
use App\Http\Requests\SignatureUpdateRequest;
use App\Repositories\SignatureRepository;
use App\Validators\SignatureValidator;

/**
 * Class SignaturesController.
 *
 * @package namespace App\Http\Controllers;
 */
class SignaturesController extends Controller
{
    /**
     * @var SignatureRepository
     */
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
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $signatures = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $signatures,
            ]);
        }

        return view('signatures.index', compact('signatures'));
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
                'data'    => $signature->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $signature,
            ]);
        }

        return view('signatures.show', compact('signature'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $signature = $this->repository->find($id);

        return view('signatures.edit', compact('signature'));
    }

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
                'data'    => $signature->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Signature deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Signature deleted.');
    }
}
