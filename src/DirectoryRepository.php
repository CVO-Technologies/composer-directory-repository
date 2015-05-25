<?php

namespace ComposerDirectoryRepository;

use Composer\Json\JsonFile;
use Composer\Package\Loader\ArrayLoader;
use Composer\Repository\ArrayRepository;

class DirectoryRepository extends ArrayRepository {

    /**
     * @var array
     */
    private $directory;

    public function __construct($config) {
        $config = array_merge_recursive([], $config);

        $this->directory = $config['path'];

        $this->initialize();
    }

    protected function initialize() {
        parent::initialize();

        $loader = new ArrayLoader(null, true);

        $directories = glob($this->directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR|GLOB_NOSORT);
        foreach ($directories as $directory) {
            if (!file_exists($directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                continue;
            }

            $jsonFile = new JsonFile($directory . DIRECTORY_SEPARATOR . 'composer.json');
            $packageData = $jsonFile->read();

            $packageData['version'] = '1.0';

            $package = $loader->load($packageData);
            $this->addPackage($package);
        }
    }

}
