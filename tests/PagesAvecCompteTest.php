<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class PagesAvecCompteTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('jean.dupont@gmail.com');
        $client->loginUser($testUser);
        
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/creation-association'];
        //yield ['/logout'];
        yield ['/mes-associations'];
        yield ['/tableau-de-bord/accueil/1'];
        yield ['/tableau-de-bord/contacts/1'];
        yield ['/tableau-de-bord/publipostage/1'];
        yield ['/tableau-de-bord/ajout-adherent/1'];
        yield ['/tableau-de-bord/ajout-excel/1'];
    }
}
