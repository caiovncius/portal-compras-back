<?php

namespace App\Http\Controllers;

use App\Program;
use App\Connection;
use App\Connection\Contracts\ConnectionCreatable;
use App\Connection\Contracts\ConnectionUpdatable;
use App\Http\Requests\ConnectionCreatorRequest;
use App\Http\Requests\ConnectionUpdatorRequest;
use App\Http\Resources\ConnectionListResource;
use Illuminate\Http\Request;

class ProgramConnectionController extends Controller
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
     * ProgramConnectionController constructor.
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
     *     tags={"Programs"},
     *     path="/programs/{id}/connection",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionCreatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="id",
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
     * @param Program $model
     * @param ConnectionCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConnectionCreatorRequest $request, Program $model )
    {
        try {
            $this->creatorService->store($model, $request->all());
            return response()->json(['message' => 'Conexão criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *     tags={"Programs"},
     *     path="/programs/{id}/connection/test",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionCreatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="id",
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
    public function test(Program $model)
    {
        $model = $model->connection;

        $statusCode = 400;
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

                $statusCode = 200;
            }
        }

        return response()->json($data, $statusCode);
    }

    /**
     *
     * @OA\Put(
     *     tags={"Programs"},
     *     path="/programs/{id}/connection",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ConnectionUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="id",
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
     *                     example ="Programa Conexão atualizado com sucesso"
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
     * @param Program $model
     * @param ConnectionUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Program $model, ConnectionUpdatorRequest $request)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Programa Conexão atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
