<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 5/16/17
 * Time: 2:23 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\User;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class DirectoryNamer implements DirectoryNamerInterface
{
    /**
     * Returns the name of a directory where files will be uploaded
     *
     * Directory name is formed based on user ID and media type
     *
     * @param Document $document
     * @param PropertyMapping $mapping
     *
     * @return string
     */
    public function directoryName($document, PropertyMapping $mapping)
    {
        /** @var Calendar $calendar */
        $calendar = $document->getCalendar();

        /** @var User $user */
        $user = $calendar->getUser();

        return $user->getUsername().'/'.$calendar->getYear().'/';
    }
}