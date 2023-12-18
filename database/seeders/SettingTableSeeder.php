<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Setting as SeederSetting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingArray['site_name']                       = 'Food Bank';
        $settingArray['site_email']                      = 'info@food-bank.xyz';
        $settingArray['site_phone_number']               = '+8801777664555';
        $settingArray['site_logo']                       = 'logo.png';
        $settingArray['fav_icon']                        = 'favicon.png';
        $settingArray['site_address']                    = 'Dhaka';
        $settingArray['site_footer']                     = '@ All Rights Reserved';
        $settingArray['site_description']                = 'FoodBank is the best online food order management system.';
        $settingArray['currency_name']                   = 'USD';
        $settingArray['currency_code']                   = '$';
        $settingArray['locale']                          = 'en';
        $settingArray['geolocation_distance_radius']     = 20;
        $settingArray['order_commission_percentage']     = 5;
        $settingArray['free_delivery_radius']            = 5;
        $settingArray['charge_per_kilo']                 = 0;
        $settingArray['basic_delivery_charge']           = 0;
        $settingArray['timezone']                        = '';
        $settingArray['frontend_theme']                  = 'default';
        $settingArray['twilio_auth_token']               = '';
        $settingArray['twilio_account_sid']              = '';
        $settingArray['twilio_from']                     = '';
        $settingArray['twilio_disabled']                 = 1;
        $settingArray['stripe_key']                      = 'pk_test_Kqmq6XXBwdoYJFLV1CSDnaxz';
        $settingArray['stripe_secret']                   = 'sk_test_JLeo9KvVZvhgsMzQ7KCl43in';
        $settingArray['razorpay_key']                    = 'razorpay_key';
        $settingArray['razorpay_secret']                 = 'razorpay_secret';
        $settingArray['paystack_key']                    = 'paystack_key';
        $settingArray['mail_host']                       = '';
        $settingArray['mail_port']                       = '';
        $settingArray['mail_username']                   = '';
        $settingArray['mail_password']                   = '';
        $settingArray['order_attachment_checking']       = '';
        $settingArray['delivery_boy_order_amount_limit'] = 10000;
        $settingArray['mail_from_name']                  = '';
        $settingArray['mail_from_address']               = '';
        $settingArray['mail_disabled']                   = 1;
        $settingArray['fcm_secret_key']                  = '';
        $settingArray['facebook_key']                    = '';
        $settingArray['facebook_secret']                 = '';
        $settingArray['facebook_url']                    = '';
        $settingArray['google_map_api_key']              = 'AIzaSyBAAS4mcYl5qr5HzBwXFCDwqw3PnQDl7ZQ';
        $settingArray['google_key']                      = '';
        $settingArray['google_secret']                   = '';
        $settingArray['google_url']                      = '';
        $settingArray['otp_type_checking']               = 'email';
        $settingArray['otp_digit_limit']                 = 6;
        $settingArray['otp_expire_time']                 = 10;
        $settingArray['license_code']                    = session()->has('license_code') ? session()->get('license_code') : "";
        $settingArray['facebook']                        = '';
        $settingArray['instagram']                       = '';
        $settingArray['youtube']                         = '';
        $settingArray['twitter']                         = '';
        $settingArray['billing-type']                    = 10;
        $settingArray['support_phone']                   = '+9901555555';
        $settingArray['customer_app_name']               = 'Customer';
        $settingArray['customer_app_logo']               = 'logo.png';
        $settingArray['customer_splash_screen_logo']     = 'logo.png';
        $settingArray['vendor_app_name']                 = 'Vendor';
        $settingArray['vendor_app_logo']                 = 'logo.png';
        $settingArray['vendor_splash_screen_logo']       = 'logo.png';
        $settingArray['delivery_app_name']               = 'Delivery';
        $settingArray['delivery_app_logo']               = 'logo.png';
        $settingArray['delivery_splash_screen_logo']     = 'logo.png';
        $settingArray['banner_title']                    = 'FoodBank is the best online food order management system.';
        $settingArray['banner_image']                    = 'hero.png';


        SeederSetting::set($settingArray);
        SeederSetting::save();
    }
}
