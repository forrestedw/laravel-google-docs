<?php


namespace Forrestedw\GoogleDocs;


class BaseGoogleDocs
{
    /**
     * @var \Google_Service_Docs service
     */
    protected $service;

    /**
     * Connect to the Google Client service.
     *
     * @throws \Google_Exception
     */
    protected function establishTheService() : void
    {
        $client = new \Google_Client();
        $client->setApplicationName('hello');
        $client->setScopes([\Google_Service_Docs::DOCUMENTS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');

        $this->service = new \Google_Service_Docs($client);
    }

    /**
     * Make the batch update request to Google.
     *
     * @param string $documentId
     * @param \Google_Service_Docs_BatchUpdateDocumentRequest $batchUpdateRequest
     */
    protected function sendBatchUpdate(\Google_Service_Docs_BatchUpdateDocumentRequest $batchUpdateRequest) : void
    {
        $this->service->documents->batchUpdate($this->documentId, $batchUpdateRequest);
    }
    /**
     * Construction a new \Google_Service_Docs_BatchUpdateDocumentRequest
     *
     * @param array $requests
     * @return \Google_Service_Docs_BatchUpdateDocumentRequest
     */
    protected function newBatchUpdateRequest(array $requests) : \Google_Service_Docs_BatchUpdateDocumentRequest
    {
        return new \Google_Service_Docs_BatchUpdateDocumentRequest(['requests' => $requests]);
    }
    /**
     * Construction a new \Google_Service_Docs_Request
     *
     * @param $originalText
     * @param $modifiedText
     * @return \Google_Service_Docs_Request
     */
    protected static function newGoogleServiceDocsRequest($originalText, $modifiedText) : \Google_Service_Docs_Request
    {
        $replaceAllTextRequest = [
            'replaceAllText' => [
                'replaceText' => $modifiedText,
                'containsText' => [
                    'text' => $originalText,
                    'matchCase' => true,
                ],
            ],
        ];
        return new \Google_Service_Docs_Request($replaceAllTextRequest);
    }
}
