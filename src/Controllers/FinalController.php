<?php

namespace Triptasoft\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Triptasoft\LaravelInstaller\Events\LaravelInstallerFinished;
use Triptasoft\LaravelInstaller\Helpers\EnvironmentManager;
use Triptasoft\LaravelInstaller\Helpers\FinalInstallManager;
use Triptasoft\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Triptasoft\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Triptasoft\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Triptasoft\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
