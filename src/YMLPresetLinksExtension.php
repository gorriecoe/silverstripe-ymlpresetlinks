<?php

namespace gorriecoe\YMLPresetLinks;

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

/**
 * Adds link types preset in your config.yml.
 *
 * @package silverstripe-ymlpresetlinks
 */
class YMLPresetLinksExtension extends DataExtension
{
    /**
     * Returns a list of preset types defined in your config.yml
     *
     * @return Array
     */
    public function getPresetTypes()
    {
        return $this->owner->config()->get('preset_types');
    }

    /**
     * Returns a list of preset types defined in your config.yml
     *
     * @return ArrayList
     */
    public function getPresetTypesArrayList()
    {
        $presets = $this->owner->PresetTypes;
        $types = ArrayList::create();

        foreach ($presets as $type => $options) {
            $types->push(
                ArrayData::create([
                    'Type' => $type,
                    'Title' => isset($options['Title']) ? $options['Title'] : $type,
                    'LinkURL' => $options['LinkURL'],
                    'OpenInNewWindow' => isset($options['OpenInNewWindow']) ? $options['OpenInNewWindow'] : false,
                ])
            );
        }
        return $types;
    }

    /**
     * Checks if the given type is a preset type.
     *
     * @return Boolean
     */
    public function isPresetType($type)
    {
        return in_array(
            $type,
            array_keys($this->owner->PresetTypes)
        );
    }

    /**
     * Returns the value of the given type and field.
     *
     * @return Mixed
     */
    public function getPresetTypeValue($type, $field)
    {
        return $this->owner->PresetTypesArrayList->find('Type', $type)->{$field};
    }

    /**
     * Event handler called before writing to the database.
     * If the title is empty, set a default based on the link.
     */
    public function onBeforeWrite()
    {
        $owner = $this->owner;
        if ($owner->isPresetType($owner->Type)) {
            if (empty($owner->Title)) {
                $owner->Title = $owner->getPresetTypeValue($owner->Type, 'Title');
            }
            $owner->Title = $owner->getPresetTypeValue($owner->Type, 'OpenInNewWindow');
        }
    }

    /**
     * Update Types
     */
    public function updateTypes(&$types)
    {
        $types = array_merge(
            $types,
            $this->owner->PresetTypesArrayList->map('Type', 'Title')->toArray()
        );
    }

    /**
     * Update LinkURL
     */
    public function updateLinkURL(&$linkURL)
    {
        $owner = $this->owner;
        if ($owner->isPresetType($owner->Type)) {
            $linkURL = $owner->getPresetTypeValue($owner->Type, 'LinkURL');
        }
    }
}
