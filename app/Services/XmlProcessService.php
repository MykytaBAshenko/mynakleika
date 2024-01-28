<?php

namespace App\Services;

/**
 * Class XmlProcessService
 * @package App\Services
 */
class XmlProcessService
{
    /**
     * @var \SimpleXMLElement
     */
    private $sxml;

    /**
     * @param string $xml
     * @return $this
     */
    public function setSxml(string $xml)
    {
        $this->sxml = simplexml_load_string($xml);

        return $this;
    }

    /**
     * @return bool
     */
    public function isErrors(): bool
    {
        return !empty($this->sxml->xpath('//Message[@type="errors"]'));
    }

    /**
     * @return array
     */
    public function processXmlErrors(): array
    {
        $processErrors = [];
        $locale = session()->get('locale', 'ru');
        foreach ($this->sxml->xpath('//Message[@type="errors"]') as $error) {
            $content = $error->xpath('Content[@lang="'. $locale. '"]');
            if (!empty($content)) {
                $processErrors[] = trim((string) $content[0]);
            }
        }

        return $processErrors;
    }

    /**
     * @return array
     */
    public function processXmlWarnings(): array
    {
        $processWarnings = [];
        $locale = session()->get('locale', 'ru');
        foreach ($this->sxml->xpath('//Message[@type="warnings"]') as $warning) {
            $content = $warning->xpath('Content[@lang="'. $locale. '"]');
            if (!empty($content)) {
                $processWarnings[] = trim((string) $content[0]);
            }
        }

        return $processWarnings;
    }

    /**
     * @return array
     */
    public function processXmlPreflightData(): array
    {
        $processPreflightData = [];
        $sizes = $this->sxml->xpath('//SizeCUT');
        if ($sizes) {
            $processPreflightData['width'] = isset($sizes[0]['width'])
                ? (int) round((float) $sizes[0]['width'])
                : 0
            ;
            $processPreflightData['height'] = isset($sizes[0]['height'])
                ? (int) round((float) $sizes[0]['height'])
                : 0
            ;
        }

        return $processPreflightData;
    }
}
