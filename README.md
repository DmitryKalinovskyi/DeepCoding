# DeepCoding 
DeepCoding - competitive platform for learning and problem solving. Here you will discover different algorithms, data structures in different topics.  
Actually this is my second year course work, in Zhytomyr Polytechic State University. The main purpose of that project is to make custom framework with tools like ORM, Routing, Service Injection and etc for the backend part of that platform.

# Backend
Backend is Restfull API written in PHP 8.2. Backend consist of 2 main parts - framework and src (actual platform logic).
Also in development was used several tools:
- WAMP server
- MySQL
- Composer - for package managment and class autoloading
- Firebase/PHP-JWT - for managing access tokens
- VLucas/PHPDotenv - .env support library in php
- Docker - for virtualized code testing.

During development of the framework i was looking in different resources, the main framework analogy was ASP.NET framework for building api and server-side web-pages.
If your never work with it, i will explain you a point.

## Application
Application is the main component of our server. Application allow to run middleware chain that was previously builded using ApplicationBuilder.
ApplicationBuilder allow to manage services that will be inside our application and middlewares. Also you can use configuration class to shorten the initialization.

```php
// Create app and configure all services.
$appBuilder = new AppBuilder();

$appBuilder->useConfigurationInstance(
    new DefaultConfiguration(isDevelopment: true));

// basic service configuration
$appBuilder->services()
    ->addTransientForInterface(IJWTService::class, JWTService::class)
    ->addTransientForInterface(IPasswordHashingService::class, PasswordHashingService::class)
    ->addTransientForInterface(ICodeRunnerResolver::class, CodeRunnerResolver::class)
    ->addTransientForInterface(ICodeTestingService::class, CodeTestingService::class)
    ->addTransientForInterface(ILoggingService::class, FileLogger::class, fn() =>
    new FileLogger($_ENV["LOG_PATH"]))
;
```

## Service Container
Service Container used in Application to later inject required services inside middlewares and controller. To inject service you can create public variable and add attribute [Resolable] or just add it inside constructor.
```php
class UsersController extends APIController
{
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private IUserRepository $userRepository;
    #[Resolvable]
    private IPasswordHashingService $hashingService;
}
```
## Routing
Routing is simple. There are classes that are responsible for returning special action by url or setting that action by regex expression.
And also there are middleware wrapper that will call action based in the url. To add route to controller in the application builder (when using default configuration) you need to use RouteMapper class.
```php
$appBuilder->services()->invokeFunction(function(RouteMapper $routeMapper){
    $routeMapper->mapControllers("/api", "./src/Modules/Users/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Authentication/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Problems/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/News/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Scheme/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Reports/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Following/Controllers");
    $routeMapper->mapControllers("/api/g", "./src/Modules/GroupedAPIRequests/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/CodeRunner/Controllers");
});
```

## ORM
Probably ORM is the part that i mostly working on. It consist of several layers that helps to execute queries to the database. 
- QueryBuilders
- Queries
- DBSets
- DBContext

The main purpose of query builders is to build query that are understandable by database (without parameters).
Queries are generalized for all QueryBuilders.
They used to manage query parameters and have all functionallity of query builders. 
Note that query builders don't know about Queries, DBSets and DBContext.
DBSets are shorthand usage of queries for the some table. They have some very helpfull methods that can fast build probably hard queries based on Model class.
And the last is DBContext that manages the pdo connection and query execution.  

Final usage of the orm:
```php
class UserRepository implements IUserRepository
{
    private DeepCodeContext $db;

    public function __construct(DeepCodeContext $context){

        $this->db = $context;
    }

    public function insert($model): void
    {
        $this->db->users->insert($model);
    }

    public function find($key): mixed
    {
        return $this->db->users->select()
            ->where("Id = :id")
            ->first([':id' => $key]);
    }
}
```
