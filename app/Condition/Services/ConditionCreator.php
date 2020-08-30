<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionCreatable;
use App\ConditionPartner;
use App\Distributor;
use App\Program;

class ConditionCreator implements ConditionCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $model = Condition::create($data);

            foreach ($data['partners'] as $partner) {
                $partnerType = ConditionPartner::PARTNER_TYPE_DISTRIBUTOR;
                $hasPartner = Distributor::find($partner['partnerId']);

                if ($partner['type'] === ConditionPartner::PARTNER_TYPE_PROGRAM) {
                    $partnerType = ConditionPartner::PARTNER_TYPE_PROGRAM;
                    $hasPartner = Program::find($partner['partnerId']);
                }

                if (is_null($hasPartner)) {
                    throw new \Exception(sprintf('Parceiro %s não encontrado', $partner['partnerId']));
                }

                $model->partners()->create([
                    'partner_type' => $partnerType,
                    'partner_id' => $partner['partnerId']
                ]);
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
