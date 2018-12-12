<?php

namespace App\Transformers;

class UserTransformer extends BaseTransformer
{

    /**
     * Method used to transform an item.
     *
     * @param $item mixed The item to be transformed.
     *
     * @return array The transformed item.
     */
    public function transform($item): array
    {
        return [
            'id' => (int)$item->id,
            'uuid' => (string)$item->uuid,
            'full_name' => (string)$item->full_name,
            'first_name' => (string)$item->first_name,
            'last_name' => (string)$item->last_name,
            'username' => (string)$item->username,
            'email' => (string)$item->email,
            'registered' => $item->created_at->toDateString(),
            'phone_number' => (string)$item->phone_number,
            'email_verified_at' => (string)$item->email_verified_at,
            'gender' => (int)$item->gender,
            'pay_day' => (string)$item->pay_day,
            'date_of_birth' => isset($item->date_of_birth) ? $item->date_of_birth->toDateString() : '',
            'address' => (string)$item->address,
            'start_work_date' => isset($item->start_work_date) ? $item->start_work_date->toDateString() : '',
            'base_salary' => (float)$item->base_salary,
            'avatar_url' => (string)$item->hasMedia('avatars') ? config('app.url') . $item->getMedia('avatars')->first()->getUrl('thumb') : 'http://i.pravatar.cc/500?img=' . $item->id,
            'status' => (boolean)$item->status,
            'resigned_at' => (string)$item->resigned_at,
            'bonus' => (float)$item->bonus,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
            'deleted_at' => (string)$item->deleted_at,
            'bio' => (string)$item->bio,
            'roles' => $item->roles->pluck('name')->all()
        ];
    }
}
