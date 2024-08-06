<?php declare(strict_types=1);

namespace Topdata\TopdataFileAttachmentsSW6\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Content\Media\MediaService;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class FileDownloadController extends StorefrontController
{

    public function __construct(
        private readonly EntityRepository $topdataFaProductDocumentRepository,
        private readonly MediaService     $mediaService,
    )
    {
    }

    /**
     * @Route("/topdata/file/download/{documentId}", name="frontend.topdata.file.download", methods={"GET"})
     */
    public function downloadFile(string $documentId, Context $context): BinaryFileResponse
    {
        $criteria = new Criteria([$documentId]);
        $criteria->addAssociation('media');

        $document = $this->topdataFaProductDocumentRepository->search($criteria, $context)->first();

        if (!$document || !$document->getMedia()) {
            throw new \Exception('Document not found');
        }

        $filePath = $this->mediaService->getFilePath($document->getMedia());

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $document->getName()
        );

        return $response;
    }
}
