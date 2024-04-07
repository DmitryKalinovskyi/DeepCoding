# Structure of ORM tool 

- Raw QueryBuilders for each individual Database
- Proxy Query builder use concrete instance of QueryBuilder (MySQLQueryBuilder for example), and link it with DBContext.
- DBSet this is shorthand tool for modifying already defined tables.
- DBContext - root class that make interaction with database, you can modify tables in several ways (using DBSets or building own query).

Creating Raw QueryBuilders and Proxy allow us to separate the logic of building the actual query for each Database and query execution.


