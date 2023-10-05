<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $allowedParams = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];

    public function transform(Request $request): array
    {
        $eloQuery = [];

        foreach ($this->allowedParams as $param => $operators){
            $query = $request->query($param) ?? null;
            if(is_null($query)) {
                continue;
            }
            //obtengo un parametro valido. Ahora chequeo con que operador lo agrego
            $dbColumn = $this->columnMap[$param] ?? $param;
            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$dbColumn, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }

}
