## Surplus Backend Challenge
### 1. Description
Surplus backend challenge is a challenge to build an application that has a REST API concept on the backend side to meet the needs of the product management system.

### 2. Requirements
- PHP 7.4
- Laravel 8.75
- MySQL Database

### 3. How to Install
- Run ``` git clone https://github.com/sultanmaula/surplus-backend-challenge.git``` to clone this repository to your local
- Run ``` composer install ```
- Run ``` cp .env.example .env ```
- Change .env configuration with your database settings
- Run ``` php artisan migrate ``` to migrate the database
- Run ``` php artisan key:generate ``` to generate the keys
- Run ``` php artisan serve ``` to start the application

### 4. Documentation
- Category
    - List Category [GET] : ``` {{base_url}}api/category ```
    - Add Category [POST] : ``` {{base_url}}api/category ```
    - Detail Category [GET] : ``` {{base_url}}api/category/{category_id} ```
    - Delete Category [DELETE] : ``` {{base_url}}api/category/{category_id} ```
        - BODY :
            - name => required & string => ex : Gadget
            - enable => required & boolean => ex : 1
    - Update Category [POST] : ``` {{base_url}}api/category/{category_id}?_method=PATCH ```
        - BODY :
            - name => required & string => ex : Gadget
            - enable => required & boolean => ex : 1
    
- Product
    - List Product [GET] : ``` {{base_url}}api/product ```
    - Detail Product [GET] : ``` {{base_url}}api/product/{product_id} ```
    - Delete Product [DELETE] : ``` {{base_url}}api/product/{product_id} ```
    - Add Product [POST] : ``` {{base_url}}api/product ```
        - BODY :
            - name => required & string => ex : Smartphone Android
            - description => required & string => ex : This is desc of smartphone
            - enable => required & boolean => ex : 1
            - category_id[] => integer (can multiple) => ex : 1 [ID of Gadget]
            - image[] => file (can multiple) => ex : Choose/upload files
    - Update Product [POST] : ``` {{base_url}}api/product/{product_id}?_method=PATCH ```
        - BODY :
            - name => required & string => ex : Smartphone Android
            - description => required & string => ex : This is desc of smartphone
            - enable => required & boolean => ex : 1
            - category_id[] => integer (can multiple) => ex : 1 [ID of Gadget]
            - image[] => file (can multiple) => ex : Choose/upload files

### 5. Contact
- Email : <a href="mailto:sultanmaulachamzah@gmail.com">sultanmaulachamzah@gmail.com</a>
- WhatsApp : <a href="https://wa.me/6285231731037">+62 85231731037</a>
- Website : <a href="https://sultanmaula.com">sultanmaula.com</a>