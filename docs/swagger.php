<?php
/**
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
 *     @OA\Property(property="id", type="string", example="1"),
 *     @OA\Property(property="name", type="string", example="User module"),
 *     @OA\Property(property="key", type="string", example="user_module"),
 *     @OA\Property(property="permission", type="string", example="FREE_ACCESS"),
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
 * ******** Global params ********
 *
 * @OA\Parameter(
 *     name="Authorization",
 *     in="header",
 *     required=true
 * )
 */
