<?php

namespace SD\Erecruiter;

class Connector {

    private $apiUrl = null;

    public function __construct() {
        $this->initConfig();
    }

    /**
     * Inicjalizuje konfigurację
     */
    protected function initConfig() {
       // $this->apiUrl = 'https://skk.erecruiter.pl/offersXml.ashx?cId=13210843';
	   $this->apiUrl = 'https://offers.erecruiter.pl/skk/company/13210843/offers.xml?hash=42852F0123635E09C415630BE70987C7BA111C71C5726597D98B92BD4AA91C619241A8BF80466D7B8945779051F4B74D01D31334973C9E5B71726595B8DA2CD9';


    }

    /**
     * 
     * @return boolean|SimpleXMLElement
     * @throws \Exception
     */
    protected function getData() {
        libxml_use_internal_errors(true);

        if (filter_var($this->apiUrl, FILTER_VALIDATE_URL) === false || !preg_match('#^(http|https)://#i', $this->apiUrl)) {
            throw new \Exception('API XML URL is not a valid HTTP/HTTPS URL');
        }

        $xmlContents = @file_get_contents($this->apiUrl);
        if (!$xmlContents) {
            throw new \Exception('API XML file is empty or does not exist.');
        }
        $xmlData = simplexml_load_string($xmlContents);

        if (!$xmlData) {
            throw new \Exception(libxml_get_errors());
            return false;
        }

        return $xmlData;
    }

    public function getOffers() {

        $offers = [];
        $xmlOffers = $this->getData();

        for ($i = 0; $i < count($xmlOffers->job); $i++) {

            $offers[] = [
                'title' => $xmlOffers->job[$i]->title->__toString(),
                'publish-date' => $xmlOffers->job[$i]->publishDate->__toString(),
                'expiry-date' => $xmlOffers->job[$i]->expiryDate->__toString(),
                'location' => $xmlOffers->job[$i]->location->__toString(),
                'category' => $xmlOffers->job[$i]->additionalFields->additionalField->additionalFieldValue.'',
                'url' => $xmlOffers->job[$i]->urlWithLayout.'',
                'requirements' => $xmlOffers->job[$i]->requirements->__toString(),
                'opportunities' => $xmlOffers->job[$i]->opportunities->__toString(),
                'description' => $xmlOffers->job[$i]->positionDescription->__toString(),
                'company-description' => $xmlOffers->job[$i]->companyDescription->__toString(),
                'clause' => $xmlOffers->job[$i]->clause->__toString(),
                'id' => $xmlOffers->job[$i]->jobOfferId->__toString()
            ];
        }

        return $offers;
    }

}
