<?php

namespace App\Http\Resources;

use App\Models\Servico\Servico;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicoResource extends JsonResource
{
    // /**
    //  * @throws Exception
    //  */
  
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'cliente_nome' => $this->clienteServico()[0]["nome"],
            'servico_tipo' => $this->tipoServico()[0]["tipo"],
            'descricao' => $this->descricao,
            'status_tipo' => $this->statusServico()[0]["tipo"]
        ];
    }
}
