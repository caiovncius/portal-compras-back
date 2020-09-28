<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCreatorRequest;
use App\Http\Requests\ContactUpdatorRequest;
use App\Http\Resources\ContactListResource;
use App\Contact;
use App\Contact\Contracts\ContactCreatable;
use App\Contact\Contracts\ContactRetrievable;
use App\Contact\Contracts\ContactUpdatable;
use App\Contact\Contracts\ContactRemovable;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @var ContactRetrievable
     */
    private $retrieverService;

    /**
     * @var ContactCreatable
     */
    private $creatorService;

    /**
     * @var ContactUpdatable
     */
    private $updatorService;

    /**
     * @var ContactRemovable
     */
    private $removerService;


    /**
     * ContactController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(ContactRetrievable::class);
        $this->creatorService = app()->make(ContactCreatable::class);
        $this->updatorService = app()->make(ContactUpdatable::class);
        $this->removerService = app()->make(ContactRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Contacts"},
     *     path="/contacts",
     *     @OA\Parameter(
     *        name="distributor_id",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="function",
     *        in="query",
     *        example="Teste",
     *     ),
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        example="teste@domain.com",
     *     ),
     *     @OA\Parameter(
     *        name="telephone",
     *        in="query",
     *        example="teste@domain.com",
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
     *                     @OA\Items(ref="#/components/schemas/ContactListResource"),
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
            return ContactListResource::collection($this->retrieverService->getContacts($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Contacts"},
     *     path="/contacts",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContactCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distribuidor criado com sucesso"
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
     * @param ContactCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContactCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Distribuidor criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Contacts"},
     *     path="/contacts/{contact}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContactUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="contact",
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
     * @param ContactUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContactUpdatorRequest $request, Contact $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Distribuidor atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Contacts"},
     *     path="/contacts/{contact}",
     *     @OA\Parameter(
     *        name="contact",
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
     *                     example ="Distribuidor removido com sucesso"
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
     * @param Contact $Contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Contact $Contact)
    {
        try {
            $this->removerService->delete($Contact);
            return response()->json(['message' => 'Distribuidor removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Contacts"},
     *     path="/contacts/{contact}",
     *     @OA\Parameter(
     *        name="contact",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ContactListResource"),
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
     * @param Contact $model
     * @return ContactListResource
     */
    public function get(Contact $model)
    {
        return ContactListResource::make($model);
    }
}
