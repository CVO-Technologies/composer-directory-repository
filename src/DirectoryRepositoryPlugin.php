<?php

namespace ComposerDirectoryRepository;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class DirectoryRepositoryPlugin implements PluginInterface {

    public function activate(Composer $composer, IOInterface $io) {
        $composer->getRepositoryManager()->setRepositoryClass('directory', 'ComposerDirectoryRepository\DirectoryRepository');
        print_r($composer->getRepositoryManager()->createRepository('directory', [
            'path' => 'plugins'
        ]));
    }

}
