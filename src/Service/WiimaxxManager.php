<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use App\Entity as Entity;
use finfo;
use Symfony\Component\HttpFoundation\File\File;

class WiimaxxManager
{
    use HttpClient\HttpClientTrait;

    protected const NODESET_BATCH_SIZE = 100;

    protected $parameterBag;

    protected $wiimaxxVirtualTrackingLinkRepository;

    protected $wiimaxxRepository;

    protected $melixasRepository;

    protected $wiimaxxLinkRepository;

    protected $logger;

    protected $fileInfo;

    public function __construct(
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->parameterBag = $parameterBag;
        $this->wiimaxxVirtualTrackingLinkRepository = $entityManager->getRepository(
            Entity\WiimaxxVirtualTrackingLink::class
        );
        $this->wiimaxxRepository = $entityManager->getRepository(
            Entity\Wiimaxx::class
        );
        $this->melixasRepository = $entityManager->getRepository(
            Entity\Melixas::class
        );
        $this->wiimaxxLinkRepository = $entityManager->getRepository(
            Entity\WiimaxxLink::class
        );
        $this->logger = $logger;
        $this->fileInfo = new finfo(
            FILEINFO_MIME
        );
    }

    public function fetchWiimaxxVirtualTrackingLinkNodes(): void
    {
        $options = $this->parameterBag->get(
            'wiimaxx'
        );
        $this->getHttpClient()->request(
            [
                'https://wiimaxx.com/api/auth/logon' => [
                    'method' => 'POST',
                    'json' => [
                        'username' => $options['username'],
                        'password' => $options['password'],
                        'role' => 'PartnerAny',
                    ],
                    'headers' => [
                        'Origin' => 'https://wiimaxx.com',
                        'Referer' => 'https://wiimaxx.com/app/',
                    ],
                    'proxy' => false,
                ],
            ]
        );
        $wiimaxxVirtualTrackingLinkRecords = $this->getHttpClient()->request(
            [
                'https://wiimaxx.com/api/partner/track-links/get-my' => [
                    'method' => 'POST',
                    'json' => [
                        'linkType' => 1,
                    ],
                    'headers' => [
                        'Origin' => 'https://wiimaxx.com',
                        'Referer' => 'https://wiimaxx.com/app/',
                    ],
                ],
            ]
        );
        $processedWiimaxxVirtualTrackingLinkNodes = array_merge(
            ...array_values(
                array_map(
                    function (array $wiimaxxVirtualTrackingLinkRecordsChunk) use ($wiimaxxVirtualTrackingLinkRecords): array {
                        $processedWiimaxxVirtualTrackingLinkRecordsChunk = array_map(
                            function (array $wiimaxxVirtualTrackingLinkRecord) use ($wiimaxxVirtualTrackingLinkRecords): string {
                                $isWiimaxxVirtualTrackingLinkNodeExists = (bool) $this->wiimaxxVirtualTrackingLinkRepository->count(
                                    [
                                        'description' => $wiimaxxVirtualTrackingLinkRecord['description']
                                    ]
                                );

                                if ($isWiimaxxVirtualTrackingLinkNodeExists) {
                                    $this->logger->notice(
                                        sprintf(
                                            'Ignore node `wiimaxx_virtual_tracking_link`.`%s` @%s. Exists',
                                            $wiimaxxVirtualTrackingLinkRecord['_id'],
                                            $wiimaxxVirtualTrackingLinkRecord['description']
                                        )
                                    );

                                    return $wiimaxxVirtualTrackingLinkRecord['description'];
                                }

                                $wiimaxxVirtualTrackingLinkNode = $this->wiimaxxVirtualTrackingLinkRepository->create(
                                    array_merge(
                                        $wiimaxxVirtualTrackingLinkRecord,
                                        [
                                            '__rawRecord' => $wiimaxxVirtualTrackingLinkRecord,
                                            '__rawRequest' => $this->getHttpClient()->getQuery(),
                                            '__rawResponse' => $wiimaxxVirtualTrackingLinkRecords,
                                        ]
                                    )
                                );
                                $this->logger->warning(
                                    sprintf(
                                        'Create node `wiimaxx_virtual_tracking_link`.`%s` @%s',
                                        $wiimaxxVirtualTrackingLinkNode->_id,
                                        $wiimaxxVirtualTrackingLinkNode->description
                                    )
                                );

                                return $wiimaxxVirtualTrackingLinkRecord['description'];
                            },
                            $wiimaxxVirtualTrackingLinkRecordsChunk
                        );

                        $this->wiimaxxVirtualTrackingLinkRepository->flush();
                        $this->logger->info(
                            sprintf(
                                'Flush. Current memory usage is: %d Mb',
                                round(
                                    memory_get_peak_usage(
                                        true
                                    ) / 1024 / 1024,
                                    2
                                )
                            )
                        );

                        return $processedWiimaxxVirtualTrackingLinkRecordsChunk;
                    },
                    array_chunk(
                        $wiimaxxVirtualTrackingLinkRecords,
                        self::NODESET_BATCH_SIZE
                    )
                )
            )
        );

        array_filter(
            $this->wiimaxxVirtualTrackingLinkRepository->findSomeByIsActiveNotInDescription(
                true,
                $processedWiimaxxVirtualTrackingLinkNodes,
                self::NODESET_BATCH_SIZE
            ),
            function (Entity\WiimaxxVirtualTrackingLink $orphanedWiimaxxVirtualTrackingLinkNode): void {
                $orphanedWiimaxxVirtualTrackingLinkNode->__isActive = false;
                $this->wiimaxxVirtualTrackingLinkRepository->persist(
                    $orphanedWiimaxxVirtualTrackingLinkNode
                );
                $this->logger->warning(
                    sprintf(
                        'Deactivate node `wiimaxx_virtual_tracking_link`.`%s` @%s. Removed remotely',
                        $orphanedWiimaxxVirtualTrackingLinkNode->_id,
                        $orphanedWiimaxxVirtualTrackingLinkNode->description
                    )
                );
                $this->wiimaxxVirtualTrackingLinkRepository->flush();
                $this->logger->info(
                    sprintf(
                        'Flush. Current memory usage is: %d Mb',
                        round(
                            memory_get_peak_usage(
                                true
                            ) / 1024 / 1024,
                            2
                        )
                    )
                );
            }
        );

        array_filter(
            $this->wiimaxxVirtualTrackingLinkRepository->findBy(
                [
                    '__isActive' => false,
                ]
            ),
            function (Entity\WiimaxxVirtualTrackingLink $orphanedWiimaxxVirtualTrackingLinkNode): void {
                $this->logger->error(
                    sprintf(
                        'Invalid node `wiimaxx_virtual_tracking_link`.`%s` @%s. Orphaned',
                        $orphanedWiimaxxVirtualTrackingLinkNode->_id,
                        $orphanedWiimaxxVirtualTrackingLinkNode->description
                    )
                );
            }
        );
    }

    public function fetchWiimaxxNodes(): void
    {
        $options = $this->parameterBag->get(
            'wiimaxx'
        );
        $this->getHttpClient()->request(
            [
                'https://wiimaxx.com/api/auth/logon' => [
                    'method' => 'POST',
                    'json' => [
                        'username' => $options['username'],
                        'password' => $options['password'],
                        'role' => 'PartnerAny',
                    ],
                    'headers' => [
                        'Origin' => 'https://wiimaxx.com',
                        'Referer' => 'https://wiimaxx.com/app/',
                    ],
                    'proxy' => false,
                ],
            ]
        );

        array_filter(
            $this->wiimaxxVirtualTrackingLinkRepository->findBy(
                [
                    'wiimaxxNode' => null,
                    '__isActive' => true,
                ],
                null,
                self::NODESET_BATCH_SIZE
            ),
            function (Entity\WiimaxxVirtualTrackingLink $wiimaxxVirtualTrackingLink): void {
                $response = $this->getHttpClient()->request(
                    [
                        'https://wiimaxx.com/api/profile/virtual/search-for-tracking' => [
                            'method' => 'POST',
                            'json' => [
                                'isAdult' => true,
                                'siteId' => 'FC',
                                'searchParams' => [
                                    'username' => $wiimaxxVirtualTrackingLink->description,
                                ],
                            ],
                            'headers' => [
                                'Origin' => 'https://wiimaxx.com',
                                'Referer' => 'https://wiimaxx.com/app/',
                            ],
                        ],
                    ]
                );
                $wiimaxxSearchRecord = current(
                    array_filter(
                        $response,
                        function (array $wiimaxxSearchRecord) use ($wiimaxxVirtualTrackingLink): bool {
                            return $wiimaxxSearchRecord['username'] === $wiimaxxVirtualTrackingLink->description;
                        }
                    )
                );

                if (!$wiimaxxSearchRecord) {
                    $wiimaxxVirtualTrackingLink->__isActive = false;
                    $this->wiimaxxVirtualTrackingLinkRepository->persist(
                        $wiimaxxVirtualTrackingLink
                    );
                    $this->logger->warning(
                        sprintf(
                            'Deactivate node `wiimaxx_virtual_tracking_link`.`%s` @%s. Wiimaxx record does not exists',
                            $wiimaxxVirtualTrackingLink->_id,
                            $wiimaxxVirtualTrackingLink->description
                        )
                    );

                    return;
                }

                $wiimaxxNode = $this->wiimaxxRepository->create(
                    array_merge(
                        $wiimaxxSearchRecord,
                        [
                            '__rawRequest' => $this->getHttpClient()->getQuery(),
                            '__rawResponse' => $response,
                        ]
                    )
                );
                $wiimaxxRecord = $this->getHttpClient()->request(
                    [
                        'https://wiimaxx.com/api/profile/virtual/get' => [
                            'method' => 'POST',
                            'json' => [
                                'profileId' => $wiimaxxNode->_id,
                            ],
                            'headers' => [
                                'Origin' => 'https://wiimaxx.com',
                                'Referer' => 'https://wiimaxx.com/app/',
                            ],
                        ],
                    ]
                );
                $wiimaxxNode = $this->wiimaxxRepository->update(
                    $wiimaxxNode,
                    array_merge(
                        $wiimaxxRecord,
                        [
                            'virtualTrackingLinkNode' => $wiimaxxVirtualTrackingLink,
                            '__rawRecord' => $wiimaxxRecord,
                            '__rawRequest' => $this->getHttpClient()->getQuery(),
                            '__rawResponse' => $wiimaxxRecord,
                        ]
                    )
                );
                $this->wiimaxxVirtualTrackingLinkRepository->update(
                    $wiimaxxVirtualTrackingLink,
                    [
                        'wiimaxxNode' => $wiimaxxNode,
                    ]
                );
                $this->logger->warning(
                    sprintf(
                        'Create node `wiimaxx`.`%s` @%s',
                        $wiimaxxNode->_id,
                        $wiimaxxNode->username
                    )
                );
            }
        );

        $this->wiimaxxRepository->flush();
        $this->logger->info(
            sprintf(
                'Flush. Current memory usage is: %d Mb',
                round(
                    memory_get_peak_usage(
                        true
                    ) / 1024 / 1024,
                    2
                )
            )
        );

        array_filter(
            $this->wiimaxxVirtualTrackingLinkRepository->findBy(
                [
                    '__isActive' => false,
                ]
            ),
            function (Entity\WiimaxxVirtualTrackingLink $wiimaxxVirtualTrackingLinkNode): void {
                if (!$wiimaxxVirtualTrackingLinkNode->wiimaxxNode) {
                    return;
                }

                if (!$wiimaxxVirtualTrackingLinkNode->wiimaxxNode->__isActive) {
                    return;
                }

                $wiimaxxVirtualTrackingLinkNode->wiimaxxNode->__isActive = false;
                $this->wiimaxxRepository->persist(
                    $wiimaxxVirtualTrackingLinkNode->wiimaxxNode
                );
                $this->logger->warning(
                    sprintf(
                        'Deactivate node `wiimaxx`.`%s` @%s. Orphaned',
                        $wiimaxxVirtualTrackingLinkNode->wiimaxxNode->_id,
                        $wiimaxxVirtualTrackingLinkNode->wiimaxxNode->username
                    )
                );
                $this->wiimaxxRepository->flush();
                $this->logger->info(
                    sprintf(
                        'Flush. Current memory usage is: %d Mb',
                        round(
                            memory_get_peak_usage(
                                true
                            ) / 1024 / 1024,
                            2
                        )
                    )
                );
            }
        );
    }

    public function fetchMelixasNodes(): void
    {
        $options = $this->parameterBag->get(
            'melixas'
        );
        $this->getHttpClient()->request(
            [
                'https://melixas.com/api/auth/logon' => [
                    'method' => 'POST',
                    'json' => [
                        'username' => $options['username'],
                        'password' => $options['password'],
                    ],
                    'headers' => [
                        'Origin' => 'https://melixas.com',
                        'Referer' => 'https://melixas.com/',
                    ],
                    'proxy' => false,
                ],
            ]
        );

        array_filter(
            $this->wiimaxxRepository->findBy(
                [
                    'melixasNode' => null,
                    '__isActive' => true,
                ],
                null,
                self::NODESET_BATCH_SIZE
            ),
            function (Entity\Wiimaxx $wiimaxxNode): void {
                $response = $this->getHttpClient()->request(
                    [
                        'https://melixas.com/api/profile/private/search-by-params' => [
                            'method' => 'POST',
                            'json' => [
                                'addTags' => false,
                                'searchParams' => [
                                    'username' => $wiimaxxNode->username,
                                    'gender' => 'Female',
                                    'lookingFor' => 'Male',
                                ],
                                'pagingParams' => [
                                    'skipPriority' => false,
                                    'skipCount' => 0,
                                    'limitCount' => 24,
                                ],
                            ],
                            'headers' => [
                                'Origin' => 'https://melixas.com',
                                'Referer' => 'https://melixas.com/',
                            ],
                        ],
                    ]
                );

                $melixasRecord = current(
                    array_filter(
                        $response,
                        function (array $melixasRecord) use ($wiimaxxNode): bool {
                            return $melixasRecord['username'] === $wiimaxxNode->username;
                        }
                    )
                );

                if (!$melixasRecord) {
                    $wiimaxxNode->__isActive = false;
                    $this->wiimaxxRepository->persist(
                        $wiimaxxNode
                    );
                    $this->logger->warning(
                        sprintf(
                            'Deactivate node `wiimaxx`.`%s` @%s. Melixas record does not exists',
                            $wiimaxxNode->_id,
                            $wiimaxxNode->username
                        )
                    );
                    $wiimaxxNode->virtualTrackingLinkNode->__isActive = false;
                    $this->wiimaxxVirtualTrackingLinkRepository->persist(
                        $wiimaxxNode->virtualTrackingLinkNode
                    );
                    $this->logger->warning(
                        sprintf(
                            'Deactivate node `wiimaxx_virtual_tracking_link`.`%s` @%s. Melixas record does not exists',
                            $wiimaxxNode->virtualTrackingLinkNode->_id,
                            $wiimaxxNode->virtualTrackingLinkNode->description
                        )
                    );

                    return;
                }

                $melixasNode = $this->melixasRepository->create(
                    array_merge(
                        $melixasRecord,
                        [
                            'wiimaxxNode' => $wiimaxxNode,
                            '__rawRecord' => $melixasRecord,
                            '__rawRequest' => $this->getHttpClient()->getQuery(),
                            '__rawResponse' => $response,
                        ]
                    )
                );
                $wiimaxxNode->melixasNode = $melixasNode;
                $this->wiimaxxRepository->persist(
                    $wiimaxxNode
                );
                $this->logger->warning(
                    sprintf(
                        'Create node `melixas`.`%s` @%s',
                        $melixasNode->_id,
                        $melixasNode->username
                    )
                );
            }
        );

        $this->melixasRepository->flush();
        $this->logger->info(
            sprintf(
                'Flush. Current memory usage is: %d Mb',
                round(
                    memory_get_peak_usage(
                        true
                    ) / 1024 / 1024,
                    2
                )
            )
        );

        array_filter(
            $this->wiimaxxRepository->findBy(
                [
                    '__isActive' => false,
                ]
            ),
            function (Entity\Wiimaxx $wiimaxxNode): void {
                if (!$wiimaxxNode->melixasNode) {
                    return;
                }

                if (!$wiimaxxNode->melixasNode->__isActive) {
                    return;
                }

                $wiimaxxNode->melixasNode->__isActive = false;
                $this->melixasRepository->persist(
                    $wiimaxxNode->melixasNode
                );

                $this->logger->warning(
                    sprintf(
                        'Deactivate node `melixas`.`%s` @%s. Orphaned',
                        $wiimaxxNode->melixasNode->_id,
                        $wiimaxxNode->melixasNode->username
                    )
                );
                $this->melixasRepository->flush();
                $this->logger->info(
                    sprintf(
                        'Flush. Current memory usage is: %d Mb',
                        round(
                            memory_get_peak_usage(
                                true
                            ) / 1024 / 1024,
                            2
                        )
                    )
                );
            }
        );
    }

    public function fetchWiimaxxLinkNodes(): void
    {
        $options = $this->parameterBag->get(
            'wiimaxx'
        );
        $this->getHttpClient()->request(
            [
                'https://wiimaxx.com/api/auth/logon' => [
                    'method' => 'POST',
                    'json' => [
                        'username' => $options['username'],
                        'password' => $options['password'],
                        'role' => 'PartnerAny',
                    ],
                    'headers' => [
                        'Origin' => 'https://wiimaxx.com',
                        'Referer' => 'https://wiimaxx.com/app/',
                    ],
                    'proxy' => false,
                ],
            ]
        );

        array_filter(
            $this->wiimaxxRepository->findSomeByIsActiveNotInUuid(
                true,
                array_column(
                    $this->wiimaxxLinkRepository->findSomeAggregatedByWiimaxx(),
                    '__uuid'
                ),
                self::NODESET_BATCH_SIZE
            ),
            function (Entity\Wiimaxx $wiimaxxNode): void {
                $wiimaxxLinkRecords = $this->getHttpClient()->request(
                    [
                        'https://wiimaxx.com/api/links/list' => [
                            'method' => 'POST',
                            'json' => [
                                'ownerIds' => [
                                    $wiimaxxNode->_id
                                ],
                                'isProfileLinkOnly' => false,
                                'width' => 600, // TODO: what is this?
                            ],
                            'headers' => [
                                'Origin' => 'https://wiimaxx.com',
                                'Referer' => 'https://wiimaxx.com/app/',
                            ],
                        ],
                    ]
                );

                array_walk(
                    $wiimaxxLinkRecords[$wiimaxxNode->_id],
                    function (array $wiimaxxLinkRecord) use ($wiimaxxNode, $wiimaxxLinkRecords): void {
                        $wiimaxxLinkNode = $this->wiimaxxLinkRepository->create(
                            array_merge(
                                $wiimaxxLinkRecord,
                                [
                                    'wiimaxxNode' => $wiimaxxNode,
                                    '__rawRecord' => $wiimaxxLinkRecord,
                                    '__rawRequest' => $this->getHttpClient()->getQuery(),
                                    '__rawResponse' => $wiimaxxLinkRecords,
                                ]
                            )
                        );
                        $file = $this->getWiimaxxLinkNodeFile(
                            $wiimaxxLinkNode,
                            false
                        );
                        $this->getHttpClient()->request(
                            [
                                sprintf(
                                    'https://wiimaxx.com/api/img/view/%s',
                                    $wiimaxxLinkRecord['fileId']
                                ) => [
                                    'method' => 'GET',
                                    'sink' => $file->getPathname(),
                                    'query' => [
                                        't' => intval(
                                            microtime(true) * 1000
                                        ),
                                    ],
                                    'headers' => [
                                        'Referer' => 'https://wiimaxx.com/',
                                    ],
                                ],
                            ],
                            false
                        );

                        if (mb_substr($this->fileInfo->file($file->getPathname()), 0, 9) === 'image/png') {
                            $image = imagecreatefrompng(
                                $file->getPathname()
                            );
                            imagejpeg(
                                $image,
                                $file->getPathname(),
                                80
                            );
                            imagedestroy(
                                $image
                            );
                            $this->logger->notice(
                                sprintf(
                                    'Convert node `wiimaxx_link`.`%s` @%s. Not in JPG format',
                                    $wiimaxxLinkNode->fileId,
                                    $wiimaxxNode->username
                                )
                            );
                        }

                        $this->logger->warning(
                            sprintf(
                                'Create node `wiimaxx_link`.`%s` @%s',
                                $wiimaxxLinkNode->fileId,
                                $wiimaxxNode->username
                            )
                        );
                    }
                );

                $this->wiimaxxLinkRepository->flush();
                $this->logger->info(
                    sprintf(
                        'Flush. Current memory usage is: %d Mb',
                        round(
                            memory_get_peak_usage(
                                true
                            ) / 1024 / 1024,
                            2
                        )
                    )
                );
            }
        );
    }

    public function validateMelixasNodes(): void
    {
        $options = $this->parameterBag->get(
            'melixas'
        );
        $this->getHttpClient()->request(
            [
                'https://melixas.com/api/auth/logon' => [
                    'method' => 'POST',
                    'json' => [
                        'username' => $options['username'],
                        'password' => $options['password'],
                    ],
                    'headers' => [
                        'Origin' => 'https://melixas.com',
                        'Referer' => 'https://melixas.com/',
                    ],
                    'proxy' => false,
                ],
            ]
        );

        array_filter(
            $this->melixasRepository->findBy(
                [
                    '__isActive' => true,
                ]
            ),
            function (Entity\Melixas $melixasNode): void {
                $response = $this->getHttpClient()->request(
                    $melixasNode->__rawRequest[0]
                );
                $melixasRecord = current(
                    array_filter(
                        $response,
                        function (array $melixasRecord) use ($melixasNode): bool {
                            return $melixasRecord['username'] === $melixasNode->username;
                        }
                    )
                );

                if ($melixasRecord['username'] === $melixasNode->username) {
                    $this->logger->notice(
                        sprintf(
                            'Ignore node `melixas`.`%s` @%s. Up to date',
                            $melixasNode->_id,
                            $melixasNode->username
                        )
                    );

                    return;
                }

                $melixasNode->__isActive = false;
                $this->melixasRepository->persist(
                    $melixasNode
                );
                $melixasNode->wiimaxxNode->__isActive = false;
                $this->wiimaxxRepository->persist(
                    $melixasNode->wiimaxxNode
                );
                $melixasNode->wiimaxxNode->virtualTrackingLinkNode->__isActive = false;
                $this->wiimaxxVirtualTrackingLinkRepository->persist(
                    $melixasNode->wiimaxxNode->virtualTrackingLinkNode
                );
                $this->logger->warning(
                    sprintf(
                        'Deactivate node `melixas`.`%s` @%s. Record does not exists',
                        $melixasNode->_id,
                        $melixasNode->username
                    )
                );
                $this->melixasRepository->flush();
                $this->logger->info(
                    sprintf(
                        'Flush. Current memory usage is: %d Mb',
                        round(
                            memory_get_peak_usage(
                                true
                            ) / 1024 / 1024,
                            2
                        )
                    )
                );
            }
        );
    }

    public function getWiimaxxLinkNodeFile(Entity\WiimaxxLink $wiimaxxLinkNode, bool $checkPath = true): File
    {
        return new File(
            sprintf(
                '%s/%s.jpg',
                $this->parameterBag->get(
                    'wiimaxx'
                )['link']['storage_path'],
                $wiimaxxLinkNode->__uuid
            ),
            $checkPath
        );
    }
}
