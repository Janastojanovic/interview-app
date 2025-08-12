<?php

declare(strict_types=1);

namespace App\Core;

use App\Application\Interfaces\UserServiceInterface;
use App\Application\Services\UserService;
use App\Data\DB;
use App\Data\Repository\GenericRepository;
use App\Data\Repository\UserLogRepository;
use App\Data\Repository\UserRepository;
use App\Domain\Interfaces\GenericRepositoryInterface;
use App\Domain\Interfaces\UserLogRepositoryInterface;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Presentation\Exceptions\RouteNotFoundException;
use Dotenv\Dotenv;

class App
{
    private static DB $db;
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = []
    ) {}
    public static function db(): DB
    {
        return static::$db;
    }
    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');

        $dotenv->load();

        $this->config = new Config($_ENV);

        static::$db = new DB($this->config->db ?? []);

        $this->container->set(GenericRepositoryInterface::class, GenericRepository::class);
        $this->container->set(UserRepositoryInterface::class, UserRepository::class);
        $this->container->set(UserLogRepositoryInterface::class, UserLogRepository::class);
        $this->container->set(UserServiceInterface::class, UserService::class);

        return $this;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }
}
