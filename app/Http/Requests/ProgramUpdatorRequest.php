<?php

namespace App\Http\Requests;

use App\Program;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProgramUpdatorRequest",
 *     type="object",
 *     title="Program update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class ProgramUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Program is authorized to make this request.
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
            'code' => 'required|string|unique:programs,code,' . $this->id,
            'name' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'contacts' => 'array',
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
