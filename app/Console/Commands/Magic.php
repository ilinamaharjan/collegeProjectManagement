<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class Magic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use this command if you want to generate every files needed for Repository Pattern followed in this project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->ask('Please enter name of your model [Note: Must be singular]');

        try {
            // Create Model and migration files
            Artisan::call('make:model ' . ucwords($model) . ' --migration');
            $this->line('Created Model & Migration Files');

            // Create Repository Interface file
            $newRepoInterfaceName = ucwords($model) . 'RepositoryInterface';
            $newRepoInterfacePath = 'app/Repositories/' . $newRepoInterfaceName . '.php';
            $newRepoInterfaceContent = "<?php

namespace App\Repositories;

interface $newRepoInterfaceName {

}";

            if (file_put_contents($newRepoInterfacePath, $newRepoInterfaceContent) !== false) {
                $this->line('Created Repository Interface ' . $newRepoInterfaceName);
            } else {
                $this->error('Cannot create Repository Interface ' . $newRepoInterfaceName);
            }

            // Create Repository File
            $newRepoName = ucwords($model) . 'Repository';
            $newRepoPath = 'app/Repositories/' . $newRepoName . '.php';
            $newRepoContent ="<?php

namespace App\Repositories;

class $newRepoName implements $newRepoInterfaceName {

}";

            if (file_put_contents($newRepoPath, $newRepoContent) !== false) {
                $this->line('Created Repository ' . $newRepoName);
            } else {
                $this->error('Cannot create Repository ' . $newRepoName);
            }

            // Update ImpexoServiceProvider.php
            $impexoServiceProvider = 'app/Providers/MagicServiceProvider.php';
            $impexoServiceProviderContents = file_get_contents($impexoServiceProvider);
            $reposUsePositionTop = strpos($impexoServiceProviderContents, '// REPOS USE');
            $useInterface = "use App\Repositories\\" . $newRepoInterfaceName;
            $useRepo = "use App\Repositories\\" . $newRepoName;

            $addStringTop = "$useInterface;
$useRepo;
";

            $updatedimpexoServiceProviderContentsFirst = substr_replace($impexoServiceProviderContents, $addStringTop, $reposUsePositionTop, 0);

            $reposUsePositionBot = strpos($updatedimpexoServiceProviderContentsFirst, '// REPOS BIND END');

            $addStringBot = '
        $this->app->bind(
            ' . $newRepoInterfaceName . '::class,
            ' . $newRepoName . '::class
        );
';

            $updatedimpexoServiceProviderContentsSecond = substr_replace($updatedimpexoServiceProviderContentsFirst, $addStringBot, $reposUsePositionBot, 0);

            if (file_put_contents($impexoServiceProvider, $updatedimpexoServiceProviderContentsSecond) !== false) {
                $this->line('Updated MagicServiceProvider');
            } else {
                $this->error('Cannot Update MagicServiceProvider');
            }

            // Create Controller file
            $newControllerName = ucwords($model) . 'Controller';
            $newControllerPath = 'app/Http/Controllers/' . $newControllerName . '.php';
            $modelName = strtolower($model);
            $newControllerContent = "<?php

namespace App\Http\Controllers;

use App\Repositories\\" . $newRepoInterfaceName . ";
use Illuminate\Http\Request;

class " . $newControllerName . " extends Controller
{
    protected $" . $modelName . ";

    public function __construct(" . $newRepoInterfaceName . ' $' . $modelName . ") {
        $" . "this->" . $modelName . "= $" . $modelName . ";
    }
}
";

            if (file_put_contents($newControllerPath, $newControllerContent) !== false) {
                $this->line('Created Controller ' . $newControllerName);
            } else {
                $this->error('Cannot create Controller ' . $newControllerName);
            }

            $this->line(" ");
            $this->line('************************************************');
            $this->line('Process completed. 😊 Happy Coding 😊');
            $this->line('Made with ❤️ by Techart Trekkies Pvt. Ltd.');
            $this->line('************************************************');
            $this->line(" ");
        } catch(Throwable $e) {
            $this->error("Opps!! Something Went Wrong.");
            $this->error($e);
        }

        return 0;
    }
}
