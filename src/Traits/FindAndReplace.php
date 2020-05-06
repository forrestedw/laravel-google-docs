<?php


namespace Forrestedw\GoogleDocs\Traits;


use Forrestedw\GoogleDocs\BaseGoogleDocs;

//*************************************
// Starter code taken from
// https://stackoverflow.com/questions/60809866/how-to-modify-a-google-docs-document-via-api-using-search-and-replace
//*************************************

trait FindAndReplace
{
    protected function doFindAndReplace($find, $replace)
    {
        $requests = $textsAlreadyDone = $forEasyCompare = [];

        foreach ($this->allTextToArray() as $originalText) {

            if (in_array($originalText, $textsAlreadyDone, true)) {
                continue;
            }

            if (preg_match_all("/(.*?)($find)(.*?)/", $originalText, $matches, PREG_SET_ORDER)) {

                $modifiedText = self::makeReplacements($originalText, $replace, $matches);

                $requests[] = BaseGoogleDocs::newGoogleServiceDocsRequest($originalText, $modifiedText);
            }
            $textsAlreadyDone[] = $originalText;
        }

        $requestsCount = \count($requests);

        if ($requestsCount > 0) {
            parent::sendBatchUpdate(parent::newBatchUpdateRequest($requests));
            return $requestsCount;
        }
        return 0;
    }

    /**
     * Collects all pieces of text
     * (see https://developers.google.com/docs/api/concepts/structure to understand the structure)
     * as and array for manipulating.
     *
     * @return array
     */
    private function allTextToArray()
    {
        $allText = [];
        foreach ($this->document->body->content as $structuralElement) {
            if ($structuralElement->paragraph) {
                foreach ($structuralElement->paragraph->elements as $paragraphElement) {
                    if ($paragraphElement->textRun) {
                        $allText[] = $paragraphElement->textRun->content;
                    }
                }
            }
        }
        return $allText;
    }

    /**
     * Make replacements in string based on those found.
     *
     * @param string $originalText | The text to be changed.
     * @param string $replace | The word we want to replace with.
     * @param array $matches | The matches for the word we want to replace.
     * @return string
     */
    private static function makeReplacements(string $originalText, string $replace, array $matches): string
    {
        $modifiedText = $originalText;
        foreach ($matches as $match) {
            $modifiedText = str_replace($match[0], $match[1] . $replace . $match[3], $modifiedText);
        }
        return $modifiedText;
    }
}
