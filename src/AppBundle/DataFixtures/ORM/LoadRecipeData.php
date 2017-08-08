<?php
namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Country;

class LoadRecipeData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        // Countries List
        $countryList = array(
            'Argentina' => ['アルゼンチン', 'Argentina.png'],
            'Brazil' => ['ブラジル', 'Brazil.png'],
            'China' => ['中国', 'China.png'],
            'Cuba' => ['キューバ', 'Cuba.png'],
            'Egypt' => ['エジプト', 'Egypt.png'],
            'France' => ['フランス', 'France.png'],
            'Greece' => ['ギリシャ', 'Greece.png'],
            'India' => ['インド', 'India.png'],
            'Italy' => ['イタリア', 'Italy.png'],
            'Japan' => ['日本', 'Japan.png'],
            'Mexico' => ['メキシコ', 'Mexico.png'],
            'South Korea' => ['韓国', 'South-Korea.png'],
            'Spain' => ['スペイン', 'Spain.png'],
            'Thailand' => ['タイ王国', 'Thailand.png'],
            'Usa' => ['アメリカ', 'Usa.png'],
            'Vietnam' => ['ベトナム', 'Vietnam.png'],
        );

        foreach ($countryList as $key => $country) {
            $countryDb = new Country($key);
            $countryDb->setNameJa($country[0]);
            $countryDb->setFlagImage($country[1]);

            $manager->persist($countryDb);
            $manager->flush();
        }

    }
}