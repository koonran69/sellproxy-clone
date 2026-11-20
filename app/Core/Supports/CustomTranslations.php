<?php

namespace App\Core\Supports;

trait CustomTranslations
{
    /**
     * Lấy bản dịch theo locale hiện tại, nếu không có thì fallback về 'vi'.
     *
     * @param string $attribute
     * @return string|null
     */
    public function getTranslate($attribute)
    {
        $locale = app()->getLocale();

        if ($this->hasTranslation($attribute, $locale)) {
            return $this->getTranslation($attribute, $locale);
        }

        return $this->getTranslation($attribute, 'vi');
    }
}
