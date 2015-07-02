<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;

class SettingRepository extends Repository {

    const STOCK_EMPTY_ALERT = 'stock_empty_alert';

    function getModelName()
    {
        return 'App\Models\Settings';
    }

    public function get($setting_name)
    {
        $this->validateName($setting_name);

        try
        {
            $settingRecord = $this->model->where('setting_name', '=', $setting_name)->firstOrFail();
        }
        catch(\Exception $e)
        {
            throw new RepositoryException('Could not retrieve setting '.$setting_name, RepositoryException::DATABASE_ERROR);
        }

        return $settingRecord;
    }

    public function getValue($setting_name)
    {
        return $this->get($setting_name)->setting_value;
    }

    private function validateName($setting_name)
    {
        if( !preg_match('/^[a-z0-9_]+$/', $setting_name) )
        {
            throw new RepositoryException('Setting name is invalid', RepositoryException::VALIDATION_FAILED);
        }
    }

}