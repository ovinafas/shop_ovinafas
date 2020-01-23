<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \DB::table('categories')->truncate();
        // Category::create([
        //     'name'          =>  'Root',
        //     'description'   =>  'This is the root category, don\'t delete this one',
        //     'parent_id'     =>  null,
        //     'menu'          =>  0,
        // ]);

        $categories = [
            [
                'name' => 'Books',
                'description' => 'This is Book category',
                'menu' =>  0,
                'children' => [
                        [
                            'name' => 'Comic Book',
                            'description' => 'This is Comic Book category',
                            'menu' =>  0,
                            'children' => [
                                    [
                                        'name' => 'Marvel Comic Book',
                                        'description' => 'This is Marvel category',
                                        'menu' =>  0,
                                    ],
                                    [
                                        'name' => 'DC Comic Book',
                                        'description' => 'This is Comic category',
                                        'menu' =>  0,
                                    ],
                                    [
                                        'name' => 'Action comics',
                                        'description' => 'This is Action category',
                                        'menu' =>  0,
                                    ],
                            ],
                        ],
                        [
                            'name' => 'Textbooks',
                            'description' => 'This is Textbooks category',
                            'menu' =>  0,
                                'children' => [
                                    [
                                        'name' => 'Business',
                                        'description' => 'This is Business category',
                                        'menu' =>  0,
                                    ],
                                    [
                                        'name' => 'Finance',
                                        'description' => 'This is Finance category',
                                        'menu' =>  0,
                                    ],
                                    [
                                        'name' => 'Computer Science',
                                        'description' => 'This is Computer category',
                                        'menu' =>  0,
                                    ],
                            ],
                        ],
                    ],
            ],
            [
                'name' => 'Electronics',
                'description' => 'This is Electronics category',
                'menu' =>  0,
                   'children' => [
                        [
                            'name' => 'TV',
                            'description' => 'This is TV category',
                            'menu' =>  0,
                            'children' => [
                                [
                                    'name' => 'LED',
                                    'description' => 'This is LED category',
                                    'menu' =>  0
                                ],
                                [
                                    'name' => 'Blu-ray',
                                    'description' => 'This is Blu-ray category',
                                    'menu' =>  0,
                                ],
                            ],
                        ],
                        [
                            'name' => 'Mobile',
                            'description' => 'This is Mobile category',
                            'menu' =>  0,
                            'children' => [
                                [
                                    'name' => 'Samsung',
                                    'description' => 'This is Samsung category',
                                    'menu' =>  0,
                                ],
                                [
                                    'name' => 'iPhone',
                                    'description' => 'This is iPhone category',
                                    'menu' =>  0,
                                ],
                                [
                                    'name' => 'Xiomi',
                                    'description' => 'This is Xiomi category',
                                    'menu' =>  0,
                                ],
                            ],
                        ],
                    ],
            ],
        ];

        foreach($categories as $category)
        {
            \App\Category::create($category);
        }

        // factory('App\Category', 10)->create();
    }
}
