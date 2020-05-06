<?php

namespace Forrestedw\GoogleDocs;


use Forrestedw\GoogleDocs\Traits\FindAndReplace;

class GoogleDoc extends BaseGoogleDocs
{
    use FindAndReplace;

    /**
     * The id of the document.
     * eg 1QbVPiSgv8FR30Ap2rcv5crIiO4VCUkRA4srdYSc8D3w
     *
     * @var string
     */
    protected $documentId;

    /**
     * @var \Google_Service_Docs document
     */
    protected $document;

    /**
     * Loads a document by its id.
     *
     * @param $documentId
     * @return $this
     * @throws \Google_Exception
     */
    public function getById($documentId)
    {
        $this->documentId = $documentId;
        parent::establishTheService();
        $this->setDocument();
        return $this;
    }

    /**
     * Set the document.
     */
    private function setDocument() : void
    {
        $this->document = $this->service->documents->get($this->documentId);
    }

    /**
     * Do find and replace in the given document.
     *
     * @param $find
     * @param $replace
     * @return int
     */
    public function findAndReplace($find, $replace)
    {
        return self::doFindAndReplace($find, $replace);
    }



    /**
     * Get the title of a document.
     *
     * @return string
     */
    public function title() : string
    {
        return $this->document->getTitle();
    }
}
