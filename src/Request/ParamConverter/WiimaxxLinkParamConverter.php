<?php

namespace App\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpKernel\Exception as Exception;
use App\Entity as Entity;

class WiimaxxLinkParamConverter implements ParamConverterInterface
{
    protected $wiimaxxlinkRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->wiimaxxlinkRepository = $entityManager->getRepository(
            Entity\WiimaxxLink::class
        );
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $wiimaxxLink = $this->wiimaxxlinkRepository->find(
            $request->attributes->get(
                $configuration->getName()
            )
        );

        if (!$wiimaxxLink) {
            throw new Exception\NotFoundHttpException(
                'Wiimaxx Link does not exists.'
            );
        }

        $request->attributes->set(
            $configuration->getName(),
            $wiimaxxLink
        );

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getName() === 'wiimaxxLink';
    }
}
