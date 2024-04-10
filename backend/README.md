# Purpose of this project

This project is course work platform 
to solve different problems related to algorithms and data structures

# API MVP

## Available for user
### Main page
- News
- News search

### Problems page
- Topics collections (optional)
- Problems filter
- Pagination

### Concrete problem page
- Information about problem
- Code editor (if authorized)
- Submissions
- Discussions
- Ability to submit code
- Ability to start discussion
- Latex support

### Profile
- Activity information
- Basic user information (name, description...)
- Friends
- Avatar
- Badges

### Leaderboard
- List of most active users
- Pagination

### Competitions
- Competition list
- Registration to the competition

### Competition
- List of problems
- Timer

### Reporting page
- Ability to create report.

## Admin management

### Problems
- Creating a problem
- Providing tests for the problem
- Ability to manage access to the problem
- Editing the problem
- Removing the problem
- Providing tests for different compilers
- Providing default code template for the problem.
- Viewing collection of created problems
- Filtering them

### Main page
- Adding/Editing/Removing news
- Reordering

### User managing
- Creating/Editing/Removing users
- Manager one user or group of user
- Changing roles

### Competitions managing
- Creating/Editing/Removing

# Roadmap for building web-page framework 

- [x] Create basic router
- [x] Create basic Controller
- [X] Custom orm (basic structure)
- [X] Dependency injection (implemented as service collection)
- [X] Routes automapper
- [ ] ORM joins
- [ ] ORM expressions
- [ ] Handle routes with route parameter ("/route/:param")
- [ ] Middlewares
- [ ] Authentication/ Authorization (JWT Token based)
- [ ] Caching system

## More detailed description of Middlewares
Middlewares have purpose to prepare the data, or make some request validation. Usually they contain logic that is similar, authentication as example.
Imagine, you have several endpoints and several of them requires authorization. If you try to do this without middlewares, you need to include some Authentication service,
then make authenticate user. If user is unauthenticated, you make response with 401 (Server don't know who you are).

```php
public ProfileController extends APIController{
    
    private IAuthenticationService $_authenticationService;
    private DeepCodeContext $_db;
    public function __construct(IAuthenticationService $authenticationService,
                                       DeepCodeContext $db){
        $this->_authenticationService = $authenticationService;
        $this->_db = $db;
    }
    
    #[Route("profile/:id")]
    #[HttpPatch]
    public UpdateProfile($id){
        $user = $_authenticationService->authenticate();
        
        if($user === null)
            return statusCode(401);
        
        // you need to have rules, or this should be your profile.
        if($user->Id !== $id)
            return statusCode(403);
        
        // update user...
        
        return statusCode(200);
    }
    
}
```

as you can see, in each endpoint you should repeat authentication, that makes code overcomplicated, and broke one of the programming principles (Dry)

Using middlewares we can do same thing simpler

```php
public ProfileController extends APIController{
    
    private IAuthenticationService $_authenticationService;
    private DeepCodeContext $_db;
    public function __construct(IAuthenticationService $authenticationService,
                                       DeepCodeContext $db){
        $this->_authenticationService = $authenticationService;
        $this->_db = $db;
    }
    
    #[Route("profile/:id")]
    #[HttpPatch]
    #[Authorize]
    #[WithId(":id") | HasRole("Admin")]
    public UpdateProfile($id){
        $user = $_authenticationService->authenticate();
        
        // update user...
        
        return statusCode(200);
    }
}
```

```php
//index.php

app->middlewares
    ->addScoped(IAuthorizationMiddleware::class, JWTAuthorizationMiddleware::class);
    ->addScoped(IAuthentication::class, UserAuthentication::class);

app->handleRequest();
```