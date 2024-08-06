# Topdata File Attachments for Shopware 6

## Description

Topdata File Attachments is a Shopware 6 plugin that allows you to attach files to products in your online store. This plugin enhances product information by providing downloadable resources directly on the product detail page.

## Features

- Attach multiple files to individual products
- Display file attachments on the product detail page
- Secure file downloads for customers
- Easy management of product attachments in the Shopware 6 admin panel

## Installation

1. Upload the plugin files to your Shopware 6 installation
2. Install the plugin via the Shopware 6 admin panel or CLI
3. Activate the plugin

## Usage

After installation and activation:

1. Go to the product detail page in the Shopware 6 admin panel
2. Find the new "File Attachments" section
3. Upload and manage file attachments for the product
4. The attachments will automatically appear on the storefront product detail page

## Adding a PDF file to a product using the Admin API

To add a PDF file to a product using the Shopware 6 Admin API, you can use the following curl commands:

1. First, upload the PDF file:

```bash
curl -X POST \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/octet-stream" \
  -H "Content-Disposition: attachment; filename=example.pdf" \
  --data-binary @/path/to/your/file.pdf \
  https://your-shop-domain.com/api/_action/media/upload
```

2. Then, create a media entity for the uploaded file:

```bash
curl -X POST \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "mediaFolderId": "YOUR_MEDIA_FOLDER_ID",
    "name": "Example PDF",
    "fileName": "example.pdf",
    "mimeType": "application/pdf",
    "fileExtension": "pdf"
  }' \
  https://your-shop-domain.com/api/media
```

3. Finally, associate the media with the product:

```bash
curl -X POST \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "productId": "YOUR_PRODUCT_ID",
    "mediaId": "MEDIA_ID_FROM_PREVIOUS_STEP",
    "name": "Example PDF"
  }' \
  https://your-shop-domain.com/api/topdata-fa-product-document
```

Replace `YOUR_ACCESS_TOKEN`, `your-shop-domain.com`, `YOUR_MEDIA_FOLDER_ID`, `YOUR_PRODUCT_ID`, and `MEDIA_ID_FROM_PREVIOUS_STEP` with your actual values.

## Support

For support, please contact:

TopData Software GmbH
Website: https://www.topdata.de

## License

This plugin is released under the MIT License.

Copyright (c) 2024 TopData Software GmbH
