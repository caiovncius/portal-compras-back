<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Connection\Contracts\ConnectionCreatable;
use App\Connection\Contracts\ConnectionUpdatable;
use App\Distributor;
use App\Http\Requests\ConnectionCreatorRequest;
use App\Http\Requests\ConnectionUpdatorRequest;
use App\Http\Resources\ConnectionListResource;
use App\Services\FtpService;
use Illuminate\Http\Request;

class DistributorConnectionController extends Controller
{

    /**
     * @var ConnectionCreatable
     */
    private $creatorService;

    /**
     * @var ConnectionUpdatable
     */
    private $updatorService;


    /**
     * DistributorConnectionController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->creatorService = app()->make(ConnectionCreatable::class);
        $this->updatorService = app()->make(ConnectionUpdatable::class);
    }

    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/connection",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionCreatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="distributor",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Conexão criada com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="",
     *     @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     * ),
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             example ="Mensagem de erro"
     *         )
     *     )
     * )
     *
     * )
     */

    /**
     * @param ConnectionCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Distributor $distributor, ConnectionCreatorRequest $request)
    {
        try {
            $this->creatorService->store($distributor, $request->all());
            return response()->json(['message' => 'Conexão criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/connection/test",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionCreatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="distributor",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="testado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="",
     *     @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     * ),
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             example ="Mensagem de erro"
     *         )
     *     )
     * )
     *
     * )
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Distributor $distributor)
    {
        $model = $distributor->connection;

        $data['status'] = false;
        $data['message'] = 'Problemas na conexão!';

        if ($model) {
            $isLoggedIn = @ftp_login(
                ftp_connect($model->host),
                $model->login,
                $model->password
            );
            if ($isLoggedIn) {
                $data['status'] = true;
                $data['message'] = 'Conexão feita com sucesso!';            
            }
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/connection/{connection}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="distributor",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Parameter(
     *        name="connection",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distribuidor atualizado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="",
     *     @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     * ),
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             example ="Mensagem de erro"
     *         )
     *     )
     * )
     *
     * )
     */

    /**
     * @param ConnectionUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Distributor $distributor, ConnectionUpdatorRequest $request)
    {
        try {
            $this->updatorService->update($distributor, $request->all());
            return response()->json(['message' => 'Distribuidor atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
