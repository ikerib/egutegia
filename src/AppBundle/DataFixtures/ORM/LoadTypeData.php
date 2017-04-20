<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 4/20/17
 * Time: 12:33 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Type;

class LoadTypeData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load ( ObjectManager $manager )
    {
        $type1 = new Type();
        $type1->setName( 'Oporrak' );
        $type1->setColor( '#e01b1b' );
        $manager->persist($type1);

        $type2 = new Type();
        $type2->setName( 'Norberarentzako' );
        $type2->setColor( '#d451cb' );
        $manager->persist($type2);

        $type3 = new Type();
        $type3->setName( 'Konpentsatuak' );
        $type3->setColor( '#32a121' );
        $manager->persist($type3);

        $manager->flush();


        $this->addReference('type-oporrak', $type1);
        $this->addReference('type-norberarentzako', $type2);
        $this->addReference('type-konpentsatuak', $type2);
    }

    public function getOrder()
    {
        return 1;
    }
}