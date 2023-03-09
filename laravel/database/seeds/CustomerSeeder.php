<?php

use Illuminate\Database\Seeder;
use App\Customer;
use App\Account;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            0 => [
                'first_name' => 'Arisha',
                'last_name' => 'Barron',
                'email' => 'arisha.b123@example.com',
                'gender' => 'female',
                'address' => '23 Test Street',
                'city' => 'Houston',
                'accounts' => array(
                	0 => array(
                		'title' => 'Arisha Barron',
                		'account_no' => '01006000000001',
                		'iban' => 'US01BANK01006000000001',
                		'type' => 'current',
                		'branch_id' => 1,
                		'balance' => 5000.45,
                	),
                	1 => array(
                		'title' => 'Arisha and Barron',
                		'account_no' => '01007000000001',
                		'iban' => 'US01BANK01007000000001',
                		'type' => 'savings',
                		'branch_id' => 1,
                		'balance' => 14609.00,
                	),
                ),
            ],
            1 => [
                'first_name' => 'Branden',
                'last_name' => 'Gibson',
                'email' => 'branden.g123@example.com',
                'gender' => 'male',
                'address' => '211 Test Street',
                'city' => 'Houston',
                'accounts' => array(),
            ],
            2 => [
                'first_name' => 'Rhonda',
                'last_name' => 'Church',
                'email' => 'rhonda.c123@example.com',
                'gender' => 'female',
                'address' => '13 Test Street',
                'city' => 'Houston',
                'accounts' => array(
                	0 => array(
                		'title' => 'Rhonda Church',
                		'account_no' => '01006000000002',
                		'iban' => 'US01BANK01006000000002',
                		'type' => 'current',
                		'branch_id' => 1,
                		'balance' => 250875.36,
                	),
                ),
            ],
            3 => [
                'first_name' => 'Georgina',
                'last_name' => 'Hazel',
                'email' => 'georgina.h123@example.com',
                'gender' => 'female',
                'address' => '55 Test Street',
                'city' => 'Houston',
                'accounts' => array(),
            ],
        ];

        // Add customers and their accounts in DB
        foreach ($customers as $customer){
            $new_customer = Customer::updateOrCreate([
                'email' => $customer['email']
        	],
        	[
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'email' => $customer['email'],
                'gender' => $customer['gender'],
                'address' => $customer['address'],
                'city' => $customer['city'],
            ]);

            if(null !== $new_customer->id){
            	if(null !== $customer['accounts'] && count($customer['accounts']) > 0){
            		foreach ($customer['accounts'] as $account) {
            			// Add Customer account
            			Account::updateOrCreate([
			                'account_no' => $account['account_no']
			        	],
			        	[
			                'title' => $account['title'],
			                'account_no' => $account['account_no'],
			                'iban' => $account['iban'],
			                'type' => $account['type'],
			                'branch_id' => $account['branch_id'],
			                'customer_id' => $new_customer->id,
			                'balance' => $account['balance'],
			            ]);
            		}
            	}
            }
        }
    }
}
