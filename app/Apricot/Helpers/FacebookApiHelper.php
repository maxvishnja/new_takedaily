<?php

namespace App\Apricot\Helpers;

use App\Customer;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\Fields\CustomAudienceMultikeySchemaFields;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
use FacebookAds\Object\Values\CustomAudienceTypes;



class FacebookApiHelper
{

    public function __construct()
    {


        Api::init(config('services.fbKey.app_id') , config('services.fbKey.app_secret') ,  config('services.fbKey.app_token') );
        Api::instance();
    }



    public function checkApi(){

        return Api::instance();
    }


    public function addRealUsers($id, $plans, $country)
    {

        $params['id'] = $id;

        $params['data_users'] = [];

        foreach($plans as $plan){

        $bday = '';

        if($plan->customer->getBirthday()){
            $bday = \Date::createFromFormat('Y-m-d', $plan->customer->getBirthday())->format('Y');
        }


            $params['data_users'][] = [
                $plan->customer->getFirstname(),
                $plan->customer->getLastName(),
                $plan->customer->getEmail(),
                $plan->customer->getPhone(),
                $bday,
                $plan->customer->getGender(),
                $country
            ];
        }


        if($this->addToAudience($params)){

           return true;

        } else{

            return false;

        }

    }

    public function addAlmostUsers($id, $almosts, $country)
    {

        $params['id'] = $id;

        $params['data_users'] = [];

        foreach($almosts as $almost){

            $params['data_users'][] = [$almost->name, $almost->email, $country];
        }


        if($this->addToAlmostAudience($params)){

            return true;

        } else{

            return false;

        }

    }



    /** Adds users to custom audience
     *
     * @param array $params
     */
    public function addToAudience( $params )
    {
        $audience = new CustomAudience( $params['id'] );

        $users = array();

        if ( isset($params['data_users']) )
        {

            foreach($params['data_users'] as $user){

                $users[] = $user;
            }

            $schema = array(
                CustomAudienceMultikeySchemaFields::FIRST_NAME,
                CustomAudienceMultikeySchemaFields::LAST_NAME,
                CustomAudienceMultikeySchemaFields::EMAIL,
                CustomAudienceMultikeySchemaFields::PHONE,
                CustomAudienceMultikeySchemaFields::BIRTH_YEAR,
                CustomAudienceMultikeySchemaFields::GENDER,
                CustomAudienceMultikeySchemaFields::COUNTRY,
            );

            try {

                $audience->addUsers($users, $schema);
                return true;

            } catch (\Exception $exception) {

                \Log::error("FB error add real user : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
                return false;
            }
        }
    }



    public function addToAlmostAudience( $params )
    {
        $audience = new CustomAudience( $params['id'] );

        $users = array();

        if ( isset($params['data_users']) )
        {

            foreach($params['data_users'] as $user){

                $users[] = $user;
            }

            $schema = array(
                CustomAudienceMultikeySchemaFields::FIRST_NAME,
                CustomAudienceMultikeySchemaFields::EMAIL,
                CustomAudienceMultikeySchemaFields::COUNTRY,
            );

            try {

                $audience->addUsers($users, $schema);
                return true;

            } catch (\Exception $exception) {

                \Log::error("FB error add almost user : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
                return false;
            }
        }
    }

    /**
     * Removes users from audience
     *
     * @param array $params
     */
    public function removeFromAudience( $params )
    {
        $audience = new CustomAudience( $params['id'] );
        if ( isset($params['email']) )
        {
            $emails = is_array( $params['email'] ) ? $params['email'] : [ $params['email'] ];
            $audience->removeUsers($emails, CustomAudienceTypes::EMAIL );
        }
    }


}