<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploader;
use App\Http\Requests\PublicityImageRequest;
use App\Http\Requests\PublicityUpdatorRequest;
use App\Http\Resources\PublicityListResource;
use App\Publicity;
use App\Publicity\Contracts\PublicityUpdatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicityController extends Controller
{
    /**
     * @var PublicityUpdatable
     */
    private $updatorService;


    /**
     * PublicityController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->updatorService = app()->make(PublicityUpdatable::class);
    }

    /**
     *
     * @OA\Put(
     *     tags={"Publicities"},
     *     path="/publicities",
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
    public function update(PublicityUpdatorRequest $request)
    {
        try {
            $model = Publicity::find(1);

            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Publicidade atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Publicities"},
     *     path="/publicities",
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
     * @return PublicityListResource
     */
    public function get()
    {
        $model = Publicity::find(1);

        return PublicityListResource::make($model);
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
