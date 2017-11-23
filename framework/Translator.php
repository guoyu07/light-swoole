<?php

namespace LightSwoole\Framework;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator as LaravelTranslator;

class Translator
{

    private $translator = null;

    public function __construct()
    {
        if ($this->translator === null) {
            $locale = config('app.locale', 'en');
            $fallback_locale = config('app.fallback_locale', 'en');
            $filesystem = new Filesystem();
            $fileLoader = new FileLoader($filesystem, BASE_PATH.DS.'resources'.DS.'lang');
            $translator = new LaravelTranslator($fileLoader, $locale);
            $translator->setFallback($fallback_locale);
            $this->translator = $translator;
        }
    }

    public function getInstance()
    {
        return $this->translator;
    }

    public function trans($id, $parameters = [], $locale = null)
    {
        if (is_null($locale)) {
            $locale = config('app.locale', 'en');
        }
        return $this->translator->trans($id, $parameters, $locale);
    }

    public function trans_choice($id, $number, array $parameters = [], $locale = null)
    {
        if (is_null($locale)) {
            $locale = config('app.locale', 'en');
        }
        return $this->translator->transChoice($id, $number, $parameters, $locale);
    }


}