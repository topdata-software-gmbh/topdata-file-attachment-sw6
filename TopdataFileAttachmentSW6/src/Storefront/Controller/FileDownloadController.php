<?php declare(strict_types=1);

namespace Topdata\TopdataFileAttachmentSW6\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
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
    private $productDocumentRepository;
    private $mediaService;

    public function __construct(
        EntityRepositoryInterface $productDocumentRepository,
        MediaService $mediaService
    ) {
        $this->productDocumentRepository = $productDocumentRepository;
        $this->mediaService = $mediaService;
    }

    /**
     * @Route("/topdata/file/download/{documentId}", name="frontend.topdata.file.download", methods={"GET"})
     */
    public function downloadFile(string $documentId, Context $context): BinaryFileResponse
    {
        $criteria = new Criteria([$documentId]);
        $criteria->addAssociation('media');

        $document = $this->productDocumentRepository->search($criteria, $context)->first();

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
