<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploader;
use App\Http\Requests\PublicityCreatorRequest;
use App\Http\Requests\PublicityImageRequest;
use App\Http\Requests\PublicityUpdatorRequest;
use App\Http\Resources\PublicityListResource;
use App\Publicity;
use App\Publicity\Contracts\PublicityCreatable;
use App\Publicity\Contracts\PublicityRetrievable;
use App\Publicity\Contracts\PublicityUpdatable;
use App\Publicity\Contracts\PublicityRemovable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicityController extends Controller
{
    /**
     * @var PublicityRetrievable
     */
    private $retrieverService;

    /**
     * @var PublicityCreatable
     */
    private $creatorService;

    /**
     * @var PublicityUpdatable
     */
    private $updatorService;

    /**
     * @var PublicityRemovable
     */
    private $removerService;


    /**
     * PublicityController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(PublicityRetrievable::class);
        $this->creatorService = app()->make(PublicityCreatable::class);
        $this->updatorService = app()->make(PublicityUpdatable::class);
        $this->removerService = app()->make(PublicityRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Publicities"},
     *     path="/publicities",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="desc",
     *        in="query",
     *        example="Teste",
     *     ),
     *     @OA\Parameter(
     *        name="date_create",
     *        in="query",
     *        example="1992-10-11",
     *     ),
     *     @OA\Parameter(
     *        name="date_publish",
     *        in="query",
     *        example="1992-10-11",
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
     *                     @OA\Items(ref="#/components/schemas/PublicityListResource"),
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
            return PublicityListResource::collection($this->retrieverService->getPublicities($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Publicities"},
     *     path="/publicities",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PublicityCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Condição criada com sucesso"
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
     * @param PublicityCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PublicityCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Publicities"},
     *     path="/publicities/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PublicityUpdatorRequest")
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
     *                     example ="Condição atualizada com sucesso"
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
     * @param PublicityUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PublicityUpdatorRequest $request, Publicity $id)
    {
        try {
            $this->updatorService->update($id, $request->all());
            return response()->json(['message' => 'Condição atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Publicities"},
     *     path="/publicities/{id}",
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
     *                     example ="Condição removida com sucesso"
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
     * @param Publicity $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Publicity $id)
    {
        try {
            $this->removerService->delete($id);
            return response()->json(['message' => 'Condição removida com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Publicities"},
     *     path="/publicities/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PublicityListResource"),
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
     * @param Publicity $id
     * @return PublicityListResource
     */
    public function get(Publicity $id)
    {
        return PublicityListResource::make($id);
    }

    /**
     *
     * @OA\Post(
     *     tags={"Publicities"},
     *     path="/publicities/attach-image",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PublicityAttachImageRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Imagem adicionada com sucesso"
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
    public function attachImage(PublicityImageRequest $request)
    {
        $publicity = Publicity::first();
        $images = !is_null($publicity->images) ? json_decode($publicity->images) : [];
        $newImages = FileUploader::uploadFile($request->image);
        array_push($images, $newImages);

        $publicity->images = json_encode($images);
        $publicity->save();

        return response()->json(['message' => 'Imagem adicionada com sucesso!']);
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Publicities"},
     *     path="publicities/remove-image/{index}",
     *     @OA\Parameter(
     *        name="index",
     *        in="path",
     *        example="0",
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
     *                     example ="Imagem removida com sucesso"
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
    public function removeImage(int $index)
    {
        $publicity = Publicity::first();

        if (is_null($publicity->images)) {
            return response()->json(['message' => 'Nenhuma imagem a ser removida']);
        }

        $images = json_decode($publicity->images);

        if (isset($images[$index])) {
            Storage::delete($images[$index]);
            unset($images[$index]);
            $publicity->images = json_encode(array_values($images));
            $publicity->save();
        }

        return response()->json(['message' => 'Imagem removida com sucesso!']);
    }
}
