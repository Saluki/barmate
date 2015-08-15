<?php namespace App\Console\Commands;

use App\Models\Categories;
use App\Models\Groups;
use App\Models\Products;
use App\User;
use Artisan;
use DB;
use Faker\Factory;
use Hash;
use Illuminate\Console\Command;

class DatabaseFaker extends Command {

    const NB_USERS = 20;
    const MAX_NB_PRODUCTS = 9;

	protected $name = 'db:faker';
	protected $description = 'Seed the database with fake data for testing purposes';

    private $faker;

	public function __construct()
	{
		parent::__construct();

        $this->faker = Factory::create();
	}

	public function fire()
	{
        $this->displayWarning();

        Artisan::call('db:seed', ['--force'=>true]);
        $this->info('Created administrator account \'admin@barmate.com\' with password \'password\'.');

        $groupId = Groups::firstOrFail()->group_id;

        $this->seedUsers($groupId);
        $this->seedCategories($groupId);

        $this->info("\nFake data successfully created. Happy testing!");
	}

	protected function getArguments()
	{
		return [];
	}

	protected function getOptions()
	{
		return [];
	}

    private function displayWarning()
    {
        $this->error("\nWatch out!");
        $this->info('This command will truncate all your Barmate data.');
        $this->info("Use this command only for testing purposes.\n");

        if( $this->confirm('Are you sure you want to continue? ', false)==false )
        {
            $this->info('Command aborted');
            die;
        }
    }

    private function seedUsers($groupId)
    {
        for($i=0; $i<self::NB_USERS; $i++)
        {
            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $email = strtolower($firstName.'.'.$lastName.'@'.$this->faker->domainName);

            User::create([  'firstname'         => $firstName,
                            'lastname'          => $lastName,
                            'group_id'          => $groupId,
                            'email'             => $email,
                            'password_hash'     => Hash::make('password'),
                            'role'              => ( $i%2 == 0 ) ? 'USER' : 'MNGR',
                            'inscription_date'  => $this->faker->dateTime,
                            'is_active'         => ( $i%5 == 0 ) ? false : true ]);
        }

        $this->info('Added '.self::NB_USERS.' users to the application with password \'password\'.');
    }

    private function seedCategories($groupId)
    {
        DB::table('categories')->delete();

        $categories = ['Saison', 'Gueuze', 'Tripel', 'Witbier', 'Dubbel'];
        shuffle($categories);

        foreach($categories as $categoryName)
        {
            $category = Categories::create(['group_id'          => $groupId,
                                            'category_title'    => $categoryName]);

            $nbProducts = rand(1, self::MAX_NB_PRODUCTS);

            for($i=1; $i<=$nbProducts; $i++)
            {
                Products::create(['category_id' => $category->category_id,
                                    'product_name' => $categoryName.''.$i,
                                    'description' => '',
                                    'price' => rand(1, 4),
                                    'quantity' => rand(24,48)]);
            }
        }

        $this->info('Created '.count($categories).' categories with products in the application.');
    }

}
