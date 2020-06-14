<?php

return [

    /*
     * Language lines will be fetched by these loaders. You can put any class here that implements
     * the Kaitoj\Translator\TranslationLoaders\{interface}.
     */
    'translation_loaders' => [
        Kaitoj\Translator\TranslationLoaders\Db::class,
    ],

    /*
     * This is the model used by the Translation loader. You can put any model here
     * as long as it extends Kaitoj\Translator\LanguageLine.
     */
    'model' => Kaitoj\Translator\LanguageLine::class,

    /*
     * This is the translation manager which overrides the default Laravel `translation.loader`
     */
    'translation_manager' => Kaitoj\Translator\TranslationLoaderManager::class,

];
