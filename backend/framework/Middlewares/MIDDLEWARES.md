# About middlewares

Middlewares are targeted for handling request in some pipeline. You can manage it using ApplicationBuilder.


## Using middlewares
Middlewares can be created as class or lambda function and assigned to the application with Use, UseMiddleware functions.


### Rules for class middleware

- Each middleware class should implement __invoke(): void method
- You can pass required dependencies inside __invoke 
- Middleware should take care of the invoking next middleware, by receiving next

### Rules for lambda middleware
- Required dependencies passed into function parameters
- Should care about invoking next middleware