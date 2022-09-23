<?php

namespace App\Traits;

use TCG\Voyager\Traits\Translatable as VoyagerTranslatable;

trait Translatable
{
	use VoyagerTranslatable;

    /**
     * Get a single translated attribute.
     *
     * @param $attribute
     * @param null $language
     * @param bool $fallback
     *
     * @return null
     */
    public function getTranslatedAttribute($attribute, $language = null, $fallback = false)
    {
        // If multilingual is not enabled don't check for translations
        if (!config('voyager.multilingual.enabled')) {
            return $this->getAttributeValue($attribute);
        }

        list($value) = $this->getTranslatedAttributeMeta($attribute, $language, $fallback);

        return $value;
    }

    /**
     * Save translations.
     *
     * @param object $translations
     *
     * @return void
     */
    public function saveTranslations($translations)
    {
        $defaultLocale = config('voyager.multilingual.default');
        $translatableLocales = config('voyager.multilingual.locales');
        $translatableLocales = array_diff($translatableLocales, [$defaultLocale]);

        foreach ($translations as $field => $locales) {
            $savedLocales = [];
            foreach ($translatableLocales as $translatableLocale) {
                foreach ($locales as $locale => $translation) {
                    if ($translatableLocale == $translation->getLocale()) {
                        $translation->save();
                        $savedLocales[] = $translatableLocale;
                    }
                }
            }
            $emptyLocales = array_diff($translatableLocales, $savedLocales);
            if ($emptyLocales) {
                $this->deleteAttributeTranslations([$field], $emptyLocales);
            }
        }
    }
}
