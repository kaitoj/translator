<?php

return [

    'prefix_path' => 'translator', 
    'namespace' => 'Kaitoj\Translator\Http\Controllers',
    /*
     * Language lines will be fetched by these loaders. You can put any class here that implements
     * the Kaitoj\Translator\TranslationLoaders\{interface}.
     */
    'translation_loaders' => [
        Kaitoj\Translator\TranslationLoaders\Db::class,
    ],

    /*
     * This is the model used by the Translation loader. You can put any model here
     * as long as it extends Kaitoj\Translator\Translation.
     */
    'model' => Kaitoj\Translator\Translation::class,

    /*
     * This is the translation manager which overrides the default Laravel `translation.loader`
     */
    'translation_manager' => Kaitoj\Translator\TranslationLoaderManager::class,

];
