<?php

namespace App\Condition\Services;

use App\ConditionPartner;
use App\Contact;
use App\Condition;
use App\Condition\Contracts\ConditionUpdatable;
use App\Distributor;
use App\Program;

class ConditionUpdater implements ConditionUpdatable
{
    /**
     * @param Condition $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Condition $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            $model->partners()->delete();

            foreach ($data['partners'] as $partner) {
                $partnerType = ConditionPartner::PARTNER_TYPE_DISTRIBUTOR;
                $hasPartner = Distributor::find($partner['id']);

                if ($partner['type'] === ConditionPartner::PARTNER_TYPE_PROGRAM) {
                    $partnerType = ConditionPartner::PARTNER_TYPE_PROGRAM;
                    $hasPartner = Program::find($partner['id']);
                }

                if (is_null($hasPartner)) {
                    throw new \Exception(sprintf('Parceiro %s não encontrado', $partner['partnerId']));
                }

                $model->partners()->create([
                    'partner_type' => $partnerType,
                    'partner_id' => $partner['id']
                ]);
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
