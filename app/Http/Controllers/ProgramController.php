<?php

namespace App\Http\Controllers;

use App\Exports\ProgramExport;
use App\Http\Requests\ProgramCreatorRequest;
use App\Http\Requests\ProgramMassCreatorRequest;
use App\Http\Requests\ProgramUpdatorRequest;
use App\Http\Requests\ReturnMorphRequest;
use App\Http\Resources\ProgramListResource;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\ReturnListResource;
use App\Program;
use App\Program\Contracts\ProgramCreatable;
use App\Program\Contracts\ProgramRemovable;
use App\Program\Contracts\ProgramRetrievable;
use App\Program\Contracts\ProgramUpdatable;
use App\Returns\Contracts\ReturnsMorphCreatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Excel;

class ProgramController extends Controller
{
    /**
     * @var ProgramRetrievable
     */
    private $retrieverService;

    /**
     * @var ProgramCreatable
     */
    private $creatorService;

    /**
    * @var ReturnsMorphCreatable
    */
    private $returnService;

    /**
     * @var ProgramUpdatable
     */
    private $updatorService;

    /**
     * @var ProgramRemovable
     */
    private $removerService;


    /**
     * ProgramController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(ProgramRetrievable::class);
        $this->creatorService = app()->make(ProgramCreatable::class);
        $this->returnService = app()->make(ReturnsMorphCreatable::class);
        $this->updatorService = app()->make(ProgramUpdatable::class);
        $this->removerService = app()->make(ProgramRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Programs"},
     *     path="/programs",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="123",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ProgramListResource"),
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     allOf={
     *                         @OA\Items(ref="#/components/schemas/PaginationLinks"),
     *                     }
     *                 ),
     *                  @OA\Property(
     *                     property="meta",
     *                     allOf={
     *                         @OA\Items(ref="#/components/schemas/PaginationMeta"),
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        try {
            return ProgramListResource::collection($this->retrieverService->getPrograms($request->query())->paginate(2));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Programs"},
     *     path="/programs",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProgramCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Programa criado com sucesso"
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
     * @param ProgramCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProgramCreatorRequest $request)
    {
        try {
            $data = $this->creatorService->store($request->all());
            return response()->json(['message' => 'Programa criado com sucesso', 'data' => $data], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Programs"},
     *     path="/programs/{model}/returns",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReturnMorphRequest")
     *      ),
     *     @OA\Parameter(
     *        name="model",
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
     *                     example ="retornos criados com sucesso"
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
     * @param ReturnMorphRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returns(ReturnMorphRequest $request, Program $model)
    {
        try {
            $this->returnService->returns($model, $request->all());
            return response()->json(['message' => 'retornos criados com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Programs"},
     *     path="/programs/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProgramUpdatorRequest")
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
     *                     example ="Programa atualizado com sucesso"
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
     * @param ProgramUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProgramUpdatorRequest $request, Program $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Programa atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Programs"},
     *     path="/programs/{id}",
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
     *                     example ="Programa removido com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 example ="Mensagem de error"
     *            )
     *         )
     *     )
     * )
     */

    /**
     * @param Program $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Program $model)
    {
        try {
            $this->removerService->delete($model);
            return response()->json(['message' => 'Programa removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Programs"},
     *     path="/programs/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ProgramListResource"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 example ="Mensagem de error"
     *            )
     *         )
     *     )
     * )
     */

    /**
     * @param Program $model
     * @return ProgramResource
     */
    public function get(Program $model)
    {
        return ProgramResource::make($model);
    }

    /**
     *
     * @OA\Post(
     *     tags={"ProgramMassActions"},
     *     path="/mass-actions/program/create",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProgramMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Programs criados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProgramMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massStore(ProgramMassCreatorRequest $request)
    {
        try {
            foreach ($request->data as $model) {
                $this->creatorService->store($model);
            }
            return response()->json(['message' => 'Programs criados com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"ProgramMassActions"},
     *     path="/mass-actions/program/update",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProgramMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Programs atualizados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProgramMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdate(ProgramMassCreatorRequest $request)
    {
        try {
            $updated = 0;
            $notFound = 0;
            foreach ($request->data as $model) {
                $localData = Program::where('code', $model['code'])->first();

                if (is_null($localData)) {
                    $notFound += 1;
                }

                $this->updaterService->update($localData, $model);
                $updated += 1;
            }
            return response()->json([
                'message' => "Processo concluído com sucesso! Atualizados: {$updated} | não encontrados: {$notFound}"],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"ProgramMassActions"},
     *     path="/mass-actions/program/delete",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProgramMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Programs apagados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProgramMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(ProgramMassCreatorRequest $request)
    {
        try {
            $updated = 0;
            $notFound = 0;
            foreach ($request->data as $model) {
                $localData = Program::where('code', $model['code'])->first();

                if (is_null($localData)) {
                    $notFound += 1;
                }

                $this->removerService->delete($localData);
                $updated += 1;
            }
            return response()->json([
                'message' => "Processo concluído com sucesso! Removidos: {$updated} | não encontrados: {$notFound}"],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Programs"},
     *     path="/programs/search",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="123",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ProgramListResource"),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        try {
            return ProgramListResource::collection($this->retrieverService->getPrograms($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Programs"},
     *     path="/programs/{id}/returns",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ProgramListResource"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 example ="Mensagem de error"
     *            )
     *         )
     *     )
     * )
     */

    /**
     * @param Program $model
     * @return ProgramResource
     */
    public function getReturnsByProgram(Program $model)
    {
        try {
            return ReturnListResource::collection($this->retrieverService->getReturnsByProgram($model)->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function exportPrograms()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new ProgramExport, 'programas.xls');
    }
}
