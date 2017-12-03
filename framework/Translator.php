<?php

namespace LightSwoole\Framework;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator as LaravelTranslator;

/**
 * Class Translator
 *
 * @package LightSwoole\Framework
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class Translator
{
    /**
     * translator
     * 
     * @var null|Illuminate\Translation\Translator
     */
    private $translator = null;

    /**
     * locale
     * 
     * @var null|string
     */
    private $locale = null;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        if ($this->translator === null) {
            $locale = config('app.locale', 'en');
            $this->locale = $locale;
            $fallback_locale = config('app.fallback_locale', 'en');
            $filesystem = new Filesystem();
            $fileLoader = new FileLoader($filesystem, BASE_PATH.DS.'resources'.DS.'lang');
            $translator = new LaravelTranslator($fileLoader, $locale);
            $translator->setFallback($fallback_locale);
            $this->translator = $translator;
        }
    }

    /**
     * Get Laravel Translator instance
     * 
     * @return Illuminate\Translation\Translator
     */
    public function getInstance()
    {
        return $this->translator;
    }

    /**
     * trans
     * 
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $locale
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    public function trans($id, $parameters = [], $locale = null)
    {
        return $this->translator->trans($id, $parameters, (is_null($locale) ? $this->locale : $locale));
    }

    /**
     * transChoice
     * 
     * @param  string  $id
     * @param  int|array|\Countable  $number
     * @param  array   $parameters
     * @param  string  $locale
     * @return string
     */
    public function transChoice($id, $number, array $parameters = [], $locale = null)
    {
        return $this->translator->transChoice($id, $number, $parameters, (is_null($locale) ? $this->locale : $locale));
    }
}