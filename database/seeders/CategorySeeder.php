<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = new Category();
        $category1->user_id = '1';
        $category1->name = 'Uncategorized';
        $category1->save();

        $category2 = new Category();
        $category2->user_id = '1';
        $category2->name = 'Electricals';
        $category2->save();

        $category3 = new Category();
        $category3->user_id = '1';
        $category3->name = 'Electronics';
        $category3->save();

        $category4 = new Category();
        $category4->user_id = '1';
        $category4->name = 'Gadgets';
        $category4->save();

        $category5 = new Category();
        $category5->user_id = '1';
        $category5->name = 'Household Appliances';
        $category5->save();

        $category6 = new Category();
        $category6->user_id = '1';
        $category6->name = 'Locks & Security';
        $category6->save();

        $category7 = new Category();
        $category7->user_id = '1';
        $category7->name = 'Plumbing';
        $category7->save();

        $category8 = new Category();
        $category8->user_id = '1';
        $category8->name = 'Refrigeration';
        $category8->save();

        $category8 = new Category();
        $category8->user_id = '1';
        $category8->name = 'Communication';
        $category8->save();

        $category8 = new Category();
        $category8->user_id = '1';
        $category8->name = 'Mechanical';
        $category8->save();

        $category8 = new Category();
        $category8->user_id = '1';
        $category8->name = 'Interiror Decoration';
        $category8->save();

    }
}
