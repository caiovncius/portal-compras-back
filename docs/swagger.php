<?php
/**
 *
 * @OA\Info(
 *     title="API Portal de compras - Farmácias Associadas",
 *     version="1.0.0"
 * )
 *
 * @OA\Get(
 *     path="/",
 *     description="Status da API",
 *     @OA\Response(response="200", description="Status da API")
 * )
 *
 * ******** Schemas params ********
 *
 * @OA\Schema(
 *   schema="UserStatus",
 *   type="string",
 *   enum={"ACTIVE", "INACTIVE"}
 * )
 *
 * @OA\Schema(
 *   schema="UserType",
 *   type="string",
 *   enum={"COMMERCIAL", "PHARMACY", "SUPPLIER"}
 * )
 *
 *  @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     @OA\Property(property="first", type="string", example="http://api.test/api/users?page=1"),
 *     @OA\Property(property="last", type="string", example="http://api.test/api/users?page=10"),
 *     @OA\Property(property="next", type="string", example="http://api.test/api/users?page=3"),
 * )
 *
 * @OA\Schema(
 *     schema="ProfileFunctions",
 *     type="object",
 *     @OA\Property(property="key", type="string", example="users"),
 *     @OA\Property(property="permission", type="string", example="NO_PERMISSION"),
 * )
 *
 * @OA\Schema(
 *     schema="ProfilePermission",
 *     type="object",
 *     @OA\Property(property="functionality", type="string", example="Permissão 1"),
 *     @OA\Property(property="permission", type="string", example="FREE_ACCESS"),
 * )
 *
 * @OA\Schema(
 *     schema="DistributorContacts",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="distributor_id", type="integer", example="1"),
 *     @OA\Property(property="function", type="string", example="Teste"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="email", type="string", example="teste@domain.com"),
 *     @OA\Property(property="telephone", type="string", example="123"),
 * )
 *
 * @OA\Schema(
 *     schema="DistributorConnection",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="distributorId", type="integer", example="1"),
 *     @OA\Property(property="ftpActive", type="string", example="Teste"),
 *     @OA\Property(property="transferency", type="string", example="teste"),
 *     @OA\Property(property="host", type="string", example="localhost"),
 *     @OA\Property(property="pathSend", type="string", example="123"),
 *     @OA\Property(property="login", type="string", example="123"),
 *     @OA\Property(property="password", type="string", example="123"),
 *     @OA\Property(property="pathReturn", type="string", example="123"),
 * )
 *
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example="2"),
 *     @OA\Property(property="from", type="integer", example="1"),
 *     @OA\Property(property="last_page", type="integer", example="10"),
 *     @OA\Property(property="path", type="string", example="http://api.test/api/users"),
 *     @OA\Property(property="per_page", type="integer", example="20"),
 *     @OA\Property(property="to", type="integer", example="3"),
 *     @OA\Property(property="total", type="integer", example="10"),
 * )
 *
 * @OA\Schema(
 *   schema="ValidationResponse",
 *   @OA\Property(property="message", type="string", example="The given data was invalid."),
 *   @OA\Property(
 *     property="errors",
 *     type="array",
 *     @OA\Items(
 *         type="array",
 *         @OA\Items(type="string"),
 *         example="Campo teste é obrigatório",
 *     ),
 *   )
 * )
 *
 * @OA\Schema(
 *     schema="UserLoginRequest",
 *     type="object",
 *     title="User oauth token",
 *     required={"grant_type", "client_id", "client_secret", "username", "password"},
 *     @OA\Property(property="grant_type", type="string", example="password"),
 *     @OA\Property(property="client_id", type="string", example=" 90b5d935-da48-475d-9eed-ea6e2aad8ca7"),
 *     @OA\Property(property="client_secret", type="string", example="Wx9DjqnKUFyemOEC04vtFcDTH3on5bVdgJrLIswN"),
 *     @OA\Property(property="username", type="string", example="my@email.com"),
 *     @OA\Property(property="password", type="string", example="12345678"),
 * )
 *
 * ******** Global params ********
 *
 * @OA\Parameter(
 *     name="Authorization",
 *     in="header",
 *     required=true
 * )
 *
 * ******** Global requests ********
 *
 * @OA\Post(
 *     tags={"Users"},
 *     path="/oauth/token",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="token_type", type="string", example ="Bearer"),
 *                 @OA\Property(property="expires_in", type="int", example ="35999"),
 *                 @OA\Property(property="access_token", type="string", example ="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVjZWRmYTM2NzIxMDg3NjlhYTAzNmI0NzFjZGFlOGI4MWQyZmQ5NDE5MTI1OTUwM2Y0OGQyMTIwZjI4N2U2MDRjM2FlYTNmNmIwZDE0ZTJlIn0.eyJhdWQiOiIzIiwianRpIjoiNWNlZGZhMzY3MjEwODc2OWFhMDM2YjQ3MWNkYWU4YjgxZDJmZDk0MTkxMjU5NTAzZjQ4ZDIxMjBmMjg3ZTYwNGMzYWVhM2Y2YjBkMTRlMmUiLCJpYXQiOjE1OTExMTQyMDAsIm5iZiI6MTU5MTExNDIwMCwiZXhwIjoxNTkxMTUwMjAwLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.lXeOXHDdZs1J6EDs3bCBjhMLTCURFAswfk6plXqFQfJxnEB-JmTyZbFEmB9LvoWzJ8oGeFZ2L7dHBC6vcVgdcBXkxJOWNmSSDK5PZC7F30ppjhAf4oo6WCUKj9YtU8ChUeCuRfGE4kU98KOeBav9iunf9QkJayV6sTCB0zhtky6C30cdBJGNgkOQJU7Lmx0MADXVCtgAVBTJBDAzJDjrjmzkuf_xqTJQdSuTr9xKZB556jbu03hD1fW-ARhhTSQrTeFcSlar5B3db7lBqWtaC7z6geXx_eiQq3aiaDhifvSdHaRIlQGqVwZBjjqSfS4xZIiWX1D-2A2t66Y3S2mzOzPrU7nW58VTEgV82nSPRa9EtMPG63brfTPB2P6HjEzBsnAHQrlCpQ2SvKvrVfIBZQKNbBMAWo14oS-0syL0yZQVaDUF7jZyHp0gB4iwQvFH2IpCicGuFa26HJlBfZuCp4qvu1PRnQFwxX9hSXjFfoBumL0k9kPuJ0SMvkgyE7_IeHQw29dwHF-4Z2uj2yoonxU7qYdB7aFKJXxIrtUmRoIuYn5J-9RQsHzF6stCS_wSQnpc-Pa_xybC_8Cq2mEzDPTU7We5hmKJZwE7se-S0zT4NNnQs78IF1dm11cGY1KrQZKZdACpImUyEclX4Uw4_nYvg0W1bezZN-ET432J3ao"),
 *                 @OA\Property(property="refresh_token", type="string", example ="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVjZWRmYTM2NzIxMDg3NjlhYTAzNmI0NzFjZGFlOGI4MWQyZmQ5NDE5MTI1OTUwM2Y0OGQyMTIwZjI4N2U2MDRjM2FlYTNmNmIwZDE0ZTJlIn0.eyJhdWQiOiIzIiwianRpIjoiNWNlZGZhMzY3MjEwODc2OWFhMDM2YjQ3MWNkYWU4YjgxZDJmZDk0MTkxMjU5NTAzZjQ4ZDIxMjBmMjg3ZTYwNGMzYWVhM2Y2YjBkMTRlMmUiLCJpYXQiOjE1OTExMTQyMDAsIm5iZiI6MTU5MTExNDIwMCwiZXhwIjoxNTkxMTUwMjAwLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.lXeOXHDdZs1J6EDs3bCBjhMLTCURFAswfk6plXqFQfJxnEB-JmTyZbFEmB9LvoWzJ8oGeFZ2L7dHBC6vcVgdcBXkxJOWNmSSDK5PZC7F30ppjhAf4oo6WCUKj9YtU8ChUeCuRfGE4kU98KOeBav9iunf9QkJayV6sTCB0zhtky6C30cdBJGNgkOQJU7Lmx0MADXVCtgAVBTJBDAzJDjrjmzkuf_xqTJQdSuTr9xKZB556jbu03hD1fW-ARhhTSQrTeFcSlar5B3db7lBqWtaC7z6geXx_eiQq3aiaDhifvSdHaRIlQGqVwZBjjqSfS4xZIiWX1D-2A2t66Y3S2mzOzPrU7nW58VTEgV82nSPRa9EtMPG63brfTPB2P6HjEzBsnAHQrlCpQ2SvKvrVfIBZQKNbBMAWo14oS-0syL0yZQVaDUF7jZyHp0gB4iwQvFH2IpCicGuFa26HJlBfZuCp4qvu1PRnQFwxX9hSXjFfoBumL0k9kPuJ0SMvkgyE7_IeHQw29dwHF-4Z2uj2yoonxU7qYdB7aFKJXxIrtUmRoIuYn5J-9RQsHzF6stCS_wSQnpc-Pa_xybC_8Cq2mEzDPTU7We5hmKJZwE7se-S0zT4NNnQs78IF1dm11cGY1KrQZKZdACpImUyEclX4Uw4_nYvg0W1bezZN-ET432J3ao"),
 *             )
 *         )
 *     ),
 *
 * )
 */
