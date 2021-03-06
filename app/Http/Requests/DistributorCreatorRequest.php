<?php

namespace App\Http\Requests;

use App\Distributor;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="DistributorCreatorRequest",
 *     type="object",
 *     title="Distributor form request",
 *     required={"code", "cnpj", "name", "category", "stateId"},
 *     @OA\Property(property="code", type="string", example="001"),
 *     @OA\Property(property="cnpj", type="string", example="00.0001/0004.14"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="category", type="string", example="NATIONAL or REGIONAL"),
 *     @OA\Property(property="stateId", type="integer", example="2"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="connection", ref="#/components/schemas/ConnectionCreatorRequest")
 * )
 */
class DistributorCreatorRequest extends FormRequest
{
    /**
     * Determine if the Distributor is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|unique:distributors,code',
            'cnpj' => 'required|cnpj|unique:distributors,cnpj',
            'name' => 'required|string',
            'status' => 'in:ACTIVE,INACTIVE',
            'category' => 'required|in:NATIONAL,REGIONAL',
            'stateId' => 'required',
            'contacts' => 'nullable|array',
            'contacts.*.function' => 'required|string',
            'contacts.*.name' => 'required|string',
            'contacts.*.email' => 'required|email',
            'contacts.*.telephone' => 'required|string',
            'returns' => 'array|nullable',
            'returns.*.code' => 'required|string|unique:returns,code,returnable_type,',
            'returns.*.description' => 'required|string',
            'connection' => 'nullable',
            'connection.isFtpActive' => 'required|boolean',
            'connection.transferMode' => 'required|string',
            'connection.host' => 'required|string',
            'connection.sendDirectory' => 'required|string',
            'connection.login' => 'required|string',
            'connection.password' => 'required|string',
            'connection.returnDirectory' => 'required|string',
            'connection.port' => 'numeric',
            'connection.mask' => 'string',
            'connection.removeFile' => 'boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'code' => 'Código',
            'name' => 'Nome',
            'contacts.*.function' => 'Função',
            'contacts.*.name' => 'Nome',
            'contacts.*.email' => 'Email',
            'contacts.*.telephone' => 'Telefone',
            'connection.isFtpActive' => 'FTP Ativo',
            'connection.transferMode' => 'Modo de transferência',
            'connection.host' => 'Host',
            'connection.sendDirectory' => 'Diretório Envio Pedido',
            'connection.login' => 'Login',
            'connection.password' => 'Senha',
            'connection.returnDirectory' => 'Diretório Retorno Pedido',
            'connection.port' => 'Porta',
            'connection.mask' => 'Máscara download',
            'connection.removeFile' => 'Remover arquivos'
        ];
    }
}
