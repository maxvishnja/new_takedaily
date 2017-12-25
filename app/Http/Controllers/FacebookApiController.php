<?php

namespace App\Http\Controllers;

use App\AlmostCustomers;
use App\Apricot\Helpers\FacebookApiHelper;
use App\Customer;
use App\Plan;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\Fields\CustomAudienceMultikeySchemaFields;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
use FacebookAds\Object\Values\CustomAudienceTypes;


class FacebookApiController extends Controller
{




        public function checkApi()
        {
            $query = new FacebookApiHelper();

            dd( $query->checkApi());

        }


        public function createAudience()
        {


            dd(config('services.fbApi'));


            $plans = AlmostCustomers::where('location','=', 'nl')->get();

            $query = new FacebookApiHelper();

            $query = $query->addAlmostUsers(120330000013084017, $plans, 'NL');

            if($query){
                echo 'SUcces';
            } else {
                echo 'NO';
            }

        }


    public function addUserNl($id = 120330000013084017)
    {

        $params['id'] = $id;

        $customers = Customer::where('locale','=', 'nl')->get();

        $params['data_users'] = [];

        foreach($customers as $customer){

            $params['data_users'][] = [$customer->getFirstname(), $customer->getLastName(), $customer->getEmail()];
        }


       if($this->addToAudience($params)){
            echo 'Success';
       } else{
           echo 'Error';
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
                );

                try {

                    $audience->addUsers($users, $schema);
                    return true;

                } catch (\Exception $exception) {

                    \Log::error("FB error add user : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
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