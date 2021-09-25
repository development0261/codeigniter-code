		require_once(BASEPATH.'libraries/stripe/init.php');
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
		\Stripe\Stripe::setApiVersion($this->config->item('stripe_version'));
		$fp1 = fopen('/home/uplogic/Downloads/download.png', 'r');
		$fp2 = fopen('/home/uplogic/Downloads/download.png', 'r');
		$file1 = \Stripe\File::create([
			'purpose' => 'identity_document',
			'file' => $fp1
		]);
		$file2 = \Stripe\File::create([
			'purpose' => 'identity_document',
			'file' => $fp2
		]);
		$acc = \Stripe\Account::create([
		  "type" => "custom",
		  "country" => "US",
		  "email" => "final@example.com",
		  "requested_capabilities" => ["card_payments", "transfers"],
		  'business_type' => 'individual',
		  'business_profile' => [
				'url' => 'http://stayput.uplogictech.com/',
				'mcc' => '5734',
			],
			'individual' => [						
				  		'address' => [
				  		'city' => 'Metrotech Center',
				  		'country' => 'US',
				  		'line1' => '6 Metrotech Center',
				  		'postal_code' => '11201',
				  		'state' => 'New York',
				  		],
				  		'dob' => [
							'day' => '31',
							'month' => '10',
							'year' => '1980'
							],
						'email' => 'indi@gmail.com',
						'first_name' => 'Name',
						'last_name' => 'test',

						'gender' => 'male',
						'ssn_last_4' => '7788',
						'phone' => '5556781212',
						'verification' => [
					  		'document' => [
					  			'back' => $file1->id,
					  			'front' => $file2->id
					  		]
				  		]
					  ],
			'external_account' => [
				'object' => 'bank_account',
				'country' => 'US',
				'currency' => 'USD',
				'routing_number' => '110000000',
				'account_number' => '000123456789'
			], 
			'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ]
		]);
		$acc_id = $acc->id;