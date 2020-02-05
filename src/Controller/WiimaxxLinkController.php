<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\WiimaxxManager;
use App\Entity as Entity;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route(
 *     path="/node/wiimaxx/link"
 * )
 */
class WiimaxxLinkController extends AbstractController
{
    /**
     * @Route(
     *     name="wiimaxx_link_download",
     *     path="/{wiimaxxLink}.{_format}",
     *     methods={"GET"},
     *     requirements={
     *         "wiimaxxLink": \Ramsey\Uuid\Uuid::VALID_PATTERN,
     *         "_format": "jpg"
     *     }
     * )
     * @ParamConverter(
     *     name="wiimaxxLink"
     * )
     */
    public function download(WiimaxxManager $wiimaxxManager, Entity\WiimaxxLink $wiimaxxLink): BinaryFileResponse
    {
        return $this->file(
            $wiimaxxManager->getWiimaxxLinkNodeFile(
                $wiimaxxLink
            ),
            null,
            ResponseHeaderBag::DISPOSITION_INLINE
        );
    }
}
