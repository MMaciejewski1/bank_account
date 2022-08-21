Install:
1. Install PHP 8.1 or higher
2. Install Composer https://getcomposer.org/download/
3. git clone this repo
4. cd to repo
5. composer install
6. symfony server:start

Endpoints:

1.'/api/account', methods: ['GET']
get info about all bank account own by user

2.'/api/account/create', methods: ['GET']
create new bank account for user

3.'/api/account/createNew/', methods: ['POST']
'/api/account/createNew/{mail}/{password}', methods: ['GET']
create new bank account and new user for post and get use

4.'/api/account/login/{mail}/{password}', methods: ['GET']
log in user 
5.'/api/account/addFunds/{id}/{value}', methods: ['GET']
add 'value' funds to bank account with 'id'

6.'/api/account/withdrawFunds/{id}/{value}', methods: ['GET']
withdraw 'value' funds to bank account with 'id'

7.'/api/account/checkFunds/{id}', methods: ['GET']
return amount funds for bank account with 'id'

8.'/api/transaction/history/{id}', methods: ['GET']
return history for bank account with 'id'

Test account:
mail: test@test.com
password: 123

You can test rest api endpoints using app on index, its example of using this endpoints by web app
