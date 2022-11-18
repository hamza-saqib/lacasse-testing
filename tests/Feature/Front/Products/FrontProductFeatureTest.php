<?php

namespace Tests\Feature\Front\Products;

use App\Shop\Products\Product;
use Tests\TestCase;

class FrontProductFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_product()
    {
        $asd = 'conc : ' .env('DB_CONNECTION') . 'db : ' . env('DB_DATABASE') . 'pass : ' . env('DB_PASSWORD') . ' user : ' . 
        env('DB_USERNAME') . 'port : ' .env('DB_PORT')  . 'host : ' . env('DB_HOST');
        dd($asd);

        dump($asd);
        $this->assertStringContainsString($asd, 'asd');
        
    }

}
