#  Simple Lumen Product API example
A simple boilerplate Lumen prodct API example using Basic Authentication

## Objective
Design and implement a RESTful API webservice to select, create, update and delete products for a given category.

Implement internationalisation to the service - Given a locale (en-gb, fr-ch). 
Return the product adapted for that locale.

### Installation
- Clone this repo into a directory locally/server
- Navigate into the newly created directory
- Copy or create an environment file as per the specifications outlined below
- Run php artisan migrate
- php artisan db:seed --class=DatabaseSeeder

### Environment Setup
Important environment variables are the database and default user + pass.
If you fail to provide a default user name and pass the default values are: **secure_user** - **secure_password** for basic auth requests.

```
# API Basic Auth Details
DEFAULT_USER_NAME=
DEFAULT_USER_PASS=

# Database info
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Localisation
To benefit from the localisation, you must set the 'Content-Language' header in your requests to the appropriate supported language.
Only supports en or fr (English or French) out of the box.

To expand localisation, simply make the following changes to the database tables or use the languages and translations API references below.

- Navigate to config/constants.php and add new array key => pair where key = locale and value is language
- Insert new language data into 'languages' table
- Insert translation for product into 'translations' table which joins onto 'languages' and 'products' table via their respective id values
- Finally add any new error messsages or notifications you want to be supported by localisation to the existing or newly created Lumen language JSON files located in resources/lang

### Supported Commands
This applications API works on a CRUD storage methodology

You can either generate your own requests in your code or favourite request tool, or you may import and utilise the attached Postman collection in the 'test' directory in application root. Make sure you modify the Postman environment variables **lumen_product_api_url**, **lumen_product_api_user** and **lumen_product_api_pass** to match your own environment.

<details>
  <summary>Product API Reference</summary>
  
#### Read products (GET) by category and (optional) product_name
```
{APP_URL}/product/read
```
JSON payload example
```
{
    "product_category": "Category1"
}
```

#### Create products (POST)
```
{APP_URL}/product/create
```
JSON payload example
```
{
    "product_category": "Category1",
    "product_name": "Test API product",
    "product_desc": "Test API product description",
    "product_price": "07.90"
}
```

#### Update products (POST) and (optional) product_name
```
{APP_URL}/product/update
```
JSON payload example
```
{
    "id": 3,
    "product_category": "Category1",
    "product_name": "Test API product",
    "product_desc": "Test API product description",
    "product_price": "09.90"
}
```

#### Delete products (DELETE) by product id
```
{APP_URL}/product/delete
```
JSON payload example
```
{
    "id": 3,
    "product_category": "Category1"
}
```
</details>

<details>
  <summary>Language API Reference</summary>
  
#### Read languages (GET) by language locale
```
{APP_URL}/language/read
```
JSON payload example
```
{
    "locale": "fr"
}
```

#### Create languages (POST)
```
{APP_URL}/language/create
```
JSON payload example
```
{
    "locale": "gr",
    "name": "German",
    "date_format": "dd/mm/yyyy",
    "currency": "EUR"
}
```

#### Update languages (POST) by language locale
```
{APP_URL}/language/update
```
JSON payload example
```
{
    "locale": "gr",
    "name": "German",
    "date_format": "yyyy/mm/dd",
    "currency": "EUR"
}
```

#### Delete languages (DELETE) by language locale
```
{APP_URL}/language/delete
```
JSON payload example
```
{
    "locale": "gr"
}
```
</details>

<details>
  <summary>Translation API Reference</summary>
  
#### Read translations (GET) by product_id and language_id
```
{APP_URL}/translation/read
```
JSON payload example
```
{
    "product_id": 2,
    "language_id": 1
}
```

#### Create translations (POST)
```
{APP_URL}/translation/create
```
JSON payload example
```
{
    "product_id": 2,
    "language_id": 1,
    "product_name_translation": "Un autre produit",
    "product_desc_translation": "Deuxième description",
    "product_category_translation": "Catégorie1",
    "product_price_translation": "11.68"
}
```

#### Update translation (POST) by product_id and language_id
```
{APP_URL}/translation/update
```
JSON payload example
```
{
    "product_id": 2,
    "language_id": 1,
    "product_name_translation": "Un autre produit",
    "product_desc_translation": "Deuxième description",
    "product_category_translation": "Catégorie3",
    "product_price_translation": "11.68"
}
```

#### Delete translation (DELETE) by product_id and language_id
```
{APP_URL}/translation/delete
```
JSON payload example
```
{
    "product_id": 1,
    "language_id": 3
}
```
</details>
